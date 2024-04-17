<?php

namespace App\Services\repo\classes;

use App\Http\Requests\course\storeRequest;
use App\Http\Requests\course\updateRequest;
use App\Models\course;
use App\Services\repo\interfaces\courseInterface;
use App\Trait\ResponseJson;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

class courseClass implements courseInterface
{

    use ResponseJson;

    public function index()
    {
        return course::where('workshop', 1)->latest('updated_at')->limit(15)->get();
    }
    public function newestWorkshops()
    {
        return course::where('workshop', 1)->latest('updated_at')->limit(15)->get();
    }

    public function newestCourses()
    {
        return course::where('workshop', 0)->latest('updated_at')->limit(15)->get();
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

        return $this->returnSuccessMessage(__('strings.insert_course'), $course);
    }


    public function show($id)
    {
        try {
            $course = Course::with(['teachers.specialty', 'daysSystem', 'courseTeacher'])->findOrFail($id);
            $course->originalUrls = $course->getmedia('photos')->map(function ($item) {
                return  $item->original_url;
            });
            $course->makeHidden('media');
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
}
