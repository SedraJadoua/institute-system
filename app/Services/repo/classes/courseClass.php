<?php


namespace App\Services\repo\classes;

use App\Http\Requests\course\availableHours;
use App\Http\Requests\course\openCourse;
use App\Http\Requests\course\storeRequest;
use App\Http\Requests\course\updateRequest;
use App\Models\course;
use App\Models\daysSystem;
use App\Models\session;
use App\Models\teacherCourse;
use App\Services\repo\interfaces\courseInterface;
use App\Trait\ResponseJson;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Throwable;

class courseClass implements courseInterface
{

    use ResponseJson;

    public function index(bool $workshop)
    {
       
        $teacherCourses  = teacherCourse::
        whereHas('course', function($q) use ($workshop) {
            $q->where('workshop', $workshop);
        })
        ->limit(15)
        ->with(['course'])
        ->whereNotNull('teacher_id')
        ->latest('updated_at')
        ->get();
         $teacherCourses->each(function ($teacherCourse) {
            $course = $teacherCourse->course;
            if ($course) {
                 $mediaItems = $course->getMedia('photos');
                 $mediaUrls = $mediaItems->map->only(['uuid' , 'original_url']);
                $teacherCourse->course->media_urls = $mediaUrls; // Attach media URLs to the course
            }
        });
    return $teacherCourses->map(function ($item) {
        return [
            'id' => $item['id'],
            'course' => collect($item['course'])->only(['name' , 'media_urls'])
        ];
    });
    }
    public function newestWorkshops()
    {
       return $this->index(1);
    }

    public function newestCourses()
    {
        return $this->index(0);   
    }

    public function returnHoursAvilable(availableHours $request)
    {     
        try{
        $endDate = daysSystem::getEndDate($request->date,$request->work_day , $request->total_days);
        $results =  daysSystem::getSpecificDays($request->date, $endDate, $request->work_day);
        $daysSystem = daysSystem::where('classroom_id', $request->classroom_id)
        ->whereIn('day' , $results)
        ->select('start_time' , 'end_time')
        ->get();
        $uniqueDaysSystem = $daysSystem->unique(function ($item) {
            return $item['start_time'] . $item['end_time'];
        })->values();
        $busyTime =  daysSystem::convertObjectToArray($uniqueDaysSystem);
        return $this->avilableTime($busyTime);
       } catch(Throwable $e){
         throw $e;
       }
    }


    public function openNewCourse(openCourse $request)
    {
       try{
        DB::beginTransaction();
        $teacherCourse = teacherCourse::Create([
            'course_id' => $request->course_id, 
            'level' => $request->level, 
            'total_days' => $request->total_days, 
            'total_cost' => $request->total_cost,
           ]);
           
         if($request->has('work_day')){
            $endDate = daysSystem::getEndDate($request->date,$request->work_day , $request->total_days);
            $results = daysSystem::getSpecificDays($request->date, $endDate, $request->work_day);
            foreach($results as $result){
            $teacherCourse->daysSystem()->create([
                'classroom_id' => $request->classroom_id,
                'date' => $request->date,
                'day' => $result,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'work_day' => $request->work_day
            ]);
            }

         }else {
            $teacherCourse->daysSystem()->create([
                'classroom_id' => $request->classroom_id,
                'date' => $request->date,
                'day' => $request->date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'end_course' => $request->date,
            ]);
         }

        DB::commit();
        
        return $this->returnSuccessMessage(trans('strings.open_course') , $teacherCourse);
       }catch(Throwable $e){
         DB::rollBack();
         throw $e;
       }
    }


    public function avilableTime(array $busyTime)
    {
        try{
        $range = range(8 , 18);
        foreach ($busyTime as $time)
        {
         for ( $i=$time[0]+1 ; $i <$time[1] ; $i++) {
            $range = array_filter($range, function($value) use ($i) {
                return $value != $i;
            });
         }
       }
        sort($range);  
        foreach($range as $hour){
         $h = Carbon::today()->setTime($hour, 0);
            $ranges[] = $h->format('H:i');
        }     
       return $ranges;

    }
        catch(Throwable $th) {
            return $this->returnError($th->getMessage());
        }
    }

    public function store(storeRequest $request)
    {
        
        $course =  course::Create([
            'workshop' =>  $request->workshop,
            'name' =>  json_encode([
                'en' => $request->name_en,
                'ar' => $request->name_ar
            ]),
            'description' => json_encode([
                'en' => $request->description_en,
                'ar' => $request->description_ar
            ]),
            'specialty_id' => $request->specialty_id,
        ]);
        if($request->has('photo'))
        $fileAdders = $course->addMultipleMediaFromRequest(['photo'])
            ->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('photos');
            });
        return $course::where('id', $course->id)
        ->with(['media' ])
        ->get()
         ->each(function ($course) {
         $course->setRelation('media', $course->media->map->only(['uuid' , 'original_url']));
         });
    }


    public function show($id)
    {
        try{
            $teacherCourse = teacherCourse::with(['teacher.specialty','daysSystem.classroom'])->findOrFail($id);
            $teacherCourse->course->originalUrls = $teacherCourse->course->getmedia('photos')->map(function($item){
                return $item->original_url;
            });
             $teacherCourse->rate =  $teacherCourse->evaluation->avg('rate');
             return $teacherCourse->makeHidden(['evaluation']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->returnError(__('strings.some_thing_went_wrong'));
        }
    }

    public function update(updateRequest $request, string $id)
    {
        try {

            $course = course::findOrFail($id);
            $course->name = json_encode(['ar' => $request->name_ar, 'en' => $request->name_en]);
            $course->description = json_encode(['en' => $request->description_en, 'ar' => $request->description_ar]);
            $course->workshop = $request->workshop;
            $course->save();

            return $this->returnSuccessMessage(__('strings.update'), $course);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->returnError(__('strings.error_course_not_found'));
        }
    }

    public function destroy($id)
    {
        try {
            $course = course::findOrFail($id);
            $mediaImages = $course->getMedia('photos');
            if ($mediaImages) {
                foreach ($mediaImages as $media) {
                    $media->delete();
                    Storage::delete($media->getPath());
                }
                $course->delete();
                return $this->returnSuccessMessage(trans('strings.delete'), $course->makeHidden('media'));
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->returnError(__('strings.error_course_not_found'));
        }
    }


    public function progressOfCourse(Request $request)
    {
       try {
        
        $data = [];
        $student_id = $request->student_id;
        $courses =  Course::whereHas('courseTeacher.students', function ($q) use ($student_id) {
            $q->where('students.id', $student_id);
        })->with('courseTeacher')->get();
        $courses = json_decode($courses, true);
        for ($i = 0; $i < count($courses); $i++) {
            $courseData = [];
            $courseData['course'] = $courses[$i];
            $session = session::where('course_teacher_id', $courses[$i]['course_teacher'][0]['id'])->get();
            $courseData['course']['Progress']  = round(count($session) / $courses[$i]['course_teacher'][0]['total_days'], 2);
            $data[] = $courseData;
        }
        return $data;
       } catch (\Throwable $th) {
            return $this->returnError($th->getMessage());
       }
    }
}
