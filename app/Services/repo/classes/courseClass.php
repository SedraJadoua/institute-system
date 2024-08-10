<?php

namespace App\Services\repo\classes;

use App\Http\Requests\course\availableHours;
use App\Http\Requests\course\openCourse;
use App\Http\Requests\course\storeRequest;
use App\Http\Requests\course\updateRequest;
use App\Mail\acceptMessageToTeacher;
use App\Models\attendance;
use App\Models\course;
use App\Models\daysSystem;
use App\Models\group;
use App\Models\member;
use App\Models\session;
use App\Models\student;
use App\Models\teacher;
use App\Models\teacherCourse;
use App\Services\repo\interfaces\courseInterface;
use App\Trait\ResponseJson;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Mail;
use Throwable;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class courseClass implements courseInterface
{

    use ResponseJson;

    public function index(bool $workshop)
    {
       
        $teacherCourses  = teacherCourse::
        whereHas('course', function($q) use ($workshop) {
            $q->where('workshop', $workshop);
        })
        ->where('accept' , 1)
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

        if($request->start_time == $request->end_time){
            return $this->returnError(trans('strings.start_time_cannot_be_same_end_time'));
        }

        $teacherCourse = teacherCourse::Create([
            'course_id' => $request->course_id, 
            'level' => $request->level, 
            'total_days' => $request->total_days, 
            'total_cost' => $request->total_cost,
            'accept' => 0,
        ]);
        
        for ($i=1; $i <= $request->total_days ; $i++) { 
           session::create([
            'number_of_session' => $i,
            'course_teacher_id' => $teacherCourse->id,
           ]);    
        }
           
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
        } else {
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
            $course->specialty_id = $request->specialty_id;
            $course->save();

            return $this->returnSuccessMessage(__('strings.update'), $course);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->returnError(__('strings.error_course_not_found'));
        }
    }

    public function destroy($id)
    {
        try {
            $teacherCourse = teacherCourse::findOrFail($id);
            $mediaImages = $teacherCourse->course->getMedia('photos');
            if ($mediaImages) {
                foreach ($mediaImages as $media) {
                    $media->delete();
                    Storage::delete($media->getPath());
                }
                $teacherCourse->delete();
                return $this->returnSuccessMessage(trans('strings.delete'), $teacherCourse);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->returnError(__('strings.error_course_not_found'));
        }
    }


    public function progressOfCourse(Request $request)
    {
       try {
        $data = [];
        if(student::find($request->user_id)){
            $student_id = $request->user_id;
            $coursesTeacher =  teacherCourse::whereHas('students', function ($q) use ($student_id) {
                $q->where('students.id', $student_id);
            })
            ->where('accept' , 1)
            ->with('course' , 'daysSystem')
            ->get();

        }
        else if(teacher::find($request->user_id)){
            $teacher_id = $request->user_id;
            $coursesTeacher =  teacherCourse::where('teacher_id', $teacher_id)
            ->where('accept' , 1)
            ->with('course' , 'daysSystem')->get(); 
        } else {
            return $this->returnError(trans('strings.invalid'));

        }
        // return  $coursesTeacher;
        $coursesTeacher = json_decode($coursesTeacher, true);
        for ($i = 0; $i < count($coursesTeacher); $i++) {
            $courseData = [];
            $courseData = $coursesTeacher[$i];
            $sessionCount = session::where('course_teacher_id', $coursesTeacher[$i]['id'])->has('attendances')->count();
            $courseData['course']['Progress']  = $sessionCount > 0 ? (float) number_format($sessionCount / $coursesTeacher[$i]['total_days'], 2) : 0 ;
            $data[] = $courseData;
        }
        return $data;
        

       } catch (\Throwable $th) {
            return $this->returnError($th->getMessage());
       }
    }


    public function courseNeedTeacher()
    {
        $teacherCourses =  teacherCourse::whereNull('teacher_id')
        ->where('accept' , '0')
        ->with(['daysSystem' , 'course'])
        ->get(); 
        return $teacherCourses->map(function($item){
        $media = $item->course->getFirstMedia('photos');
           return [
               'course_teacher_id' => $item->id,
               'course' => [
                'id' =>  $item->course->id ?? '',
                'name' =>  $item->course->name ?? '',
                'image' => $media ? $media->getUrl() : null,
               ],
               'days_system' => [
                 'work_day' => $item->daysSystem->work_day ?? '',
                 'date' => $item->daysSystem->date ?? '',
                 'start_time' => $item->daysSystem->start_time ?? '',
               ],
           ];
        })->values();
    }


    public function accept(Request $request)
    {
        $validate = Validator::make($request->all() , 
        [
            'teacher_id' => 'required|exists:course_teacher,teacher_id',
            'course_id' => 'required|exists:course_teacher,course_id',
        ]);

        if($validate->fails()){
            return $this->sendListError($validate->errors());
        }

        $exists  = teacherCourse::
        where('course_id' , $request->course_id)
        ->where('teacher_id' , $request->teacher_id)
        ->first();

        if($exists)
        {
            return $this->returnSuccessMessage(trans('strings.already_registered'));
        }

        $courseTeacher  = teacherCourse::
        where('course_id' , $request->course_id)
        ->whereNull('teacher_id')
        ->first();

       if($courseTeacher){
        $teacherCourse = new teacherCourse();
        $teacherCourse->course_id = $request->course_id;
        $teacherCourse->total_days = $courseTeacher->total_days;
        $teacherCourse->level = $courseTeacher->level;
        $teacherCourse->total_cost = $courseTeacher->total_cost;
        $teacherCourse->accept = 1;
        $teacherCourse->teacher_id = $request->teacher_id;
        $teacherCourse->save();
        return $this->sendResponse($teacherCourse , trans('strings.submit'));
       }

       return $this->returnError(trans('strings.some_thing_went_wrong'));
    }


    public function acceptTeacher(Request $request)
    {
        $validate = Validator::make($request->all() , 
        [
            'teacher_id' => 'required|exists:teachers,id',
            'course_id' => 'required|exists:course_teacher,course_id',
        ]);

        if($validate->fails()){
            return $this->sendListError($validate->errors());
        }
        
        DB::beginTransaction();

       try {
        $teacherCourses  = teacherCourse::
        where('course_id' , $request->course_id)
        ->where('accept' , 0)
        ->get();

        if(count($teacherCourses) < 1 ) 
        {
           return $this->returnError(trans('strings.no_teacher_join'));
        }
        foreach ($teacherCourses as $teacherCourse) {

            if($teacherCourse->teacher_id == null){

                $teacherCourse->accept = 1;
                $teacherCourse->teacher_id = $request->teacher_id;
                $teacherCourse->save();
                $teacher = $teacherCourse->teacher;
                $course = $teacherCourse->course;
                Mail::to($teacher->email)
                ->send(new acceptMessageToTeacher($teacher->first_name.$teacher->last_name , $course->name));
                //create group
                $group = $teacherCourse->group()->Create([
                  'name' => $course->getRawOriginal('name'),
                ]);
                 // create teacher member in group
                 $group->members()->Create([
                     'teacher_id' =>$teacher->id,
                 ]);

            }else{
                $teacherCourse->delete();
            }
         
        }
        DB::commit();
       } catch (\Throwable $th) {
         DB::rollBack();
         return $this->returnError(trans($th->getMessage()));
    }

        return $this->returnSuccessMessage(trans('strings.accept'));
    }
    
    public function courseNeedTeacherInDash(Request $request){



        $coursesTeacher = course::whereHas('courseTeacher' , function($q){
        $q->where('accept' , '0' );
       })
       ->with(['teachers' , 'courseTeacher' => function($q){
        $q->with(['daysSystem'])->whereNull('teacher_id');
       }])
       ->get();

       return  $coursesTeacher->map(function($item){
       $daysSystem =   $item->daysSystem->first();
        return [
            'course_id' => $item->id,
            'name' =>  $item->name,
            'date' => $daysSystem->date ?? null,
            'start_time' => $daysSystem->start_time ?? null,
            'teachers' => $item->teachers->makeHidden(['pivot' , 'email' , 'photo' , 'description']),  
        ];
       });  
    }

    

    public function getCoursesAddedOnly(){
        return course::select('name' , 'id')
        ->doesntHave('courseTeacher')
        ->get();
    }


    public function getCoursesofSpeciality(Request $request){
      
        $validate = Validator::make($request->all(), [
            'specialty_id' => 'required|exists:specialties,id',
        ]);
         if($validate->fails()){
            return $this->sendListError($validate->errors());
         }

         return course::where('specialty_id' , $request->specialty_id)->get();

    }

}