<?php

namespace App\Services\repo\classes;

use App\Http\Requests\course\storeRequest;
use App\Http\Requests\course\updateRequest;
use App\Models\course;
use App\Models\session;
use App\Models\student;
use App\Services\repo\interfaces\courseInterface;
use App\Trait\ResponseJson;
use Illuminate\Support\Facades\Storage;

class courseClass implements courseInterface
{

    use ResponseJson;

    public function index()
    {
        return course::where('workshop', 1)->latest('updated_at')
        ->with('media')
        ->limit(15)
        ->get()
        ->each(function ($course){
            $course->setRelation('media', $course->media->map->only(['uuid' , 'original_url']));
        });
    }
    public function newestWorkshops()
    {
        return course::where('workshop', 1)->latest('updated_at')
        ->with('media')
        ->limit(15)
        ->get()
        ->each(function ($course){
            $course->setRelation('media', $course->media->map->only(['uuid' , 'original_url']));
        });
    }

    public function newestCourses()
    {
        return course::where('workshop', 0)->latest('updated_at')
        ->with('media')
        ->limit(15)
        ->get()
        ->each(function ($course){
            $course->setRelation('media', $course->media->map->only(['uuid' , 'original_url']));
        });
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
        ]);
        $fileAdders = $course->addMultipleMediaFromRequest(['photo'])
            ->each(function ($fileAdder) {
                $fileAdder->toMediaCollection('photos');
            });

        if (is_array($request->teacher_id)) {
            foreach ($request->teacher_id  as $teacher_id) {
                $course->teachers()->attach($teacher_id, [
                    'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                    'level' => $request->level,
                    'total_cost' => $request->total_cost,
                    'total_days' => $request->total_days,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        } else {
            $course->teachers()->attach($request->teacher_id, [
                'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                'level' => $request->level,
                'total_cost' => $request->total_cost,
                'total_days' => $request->total_days,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        return  $course::where('id', $course->id)
        ->with(['media'])
        ->get()
         ->each(function ($course) {
         $course->setRelation('media', $course->media->map->only(['uuid' , 'original_url']));
         });
        
    }


    public function show($id)
    {
        try {
            $course = Course::with(['teachers.specialty', 'daysSystem', 'courseTeacher'])->findOrFail($id);
            $course->originalUrls = $course->getmedia('photos')->map(function ($item) {
                return  $item->original_url;
            });
            // $course->makeHidden('media');
            return $course;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return $this->returnError(__('strings.error_course_not_found'));
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


    public function ProgressOfCourse($request)
    {
        $data = [];
        $courses =  Course::whereHas('courseTeacher.students', function ($q) use ($request) {
            $q->where('students.id', $request->student_id);
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
    }
}
