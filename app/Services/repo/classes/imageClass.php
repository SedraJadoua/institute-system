<?php

namespace App\Services\repo\classes;

use App\Http\Requests\photo\storeRequest;
use App\Models\classroom;
use App\Models\course;

use App\Services\repo\interfaces\imageInterface;
use App\Trait\ResponseJson;
use Ramsey\Uuid\Uuid;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class imageClass implements imageInterface
{
    use ResponseJson;

    public function store(storeRequest $request)
    {
        $course = course::findOrFail($request->course_id);
        $fileAdders = $course->addMultipleMediaFromRequest(['photo'])
        ->each(function ($fileAdder) {
            $fileAdder->toMediaCollection('photos');
        });
        $data = course::where('id' , $request->course_id)
        ->with('media')
        ->get()
        ->each(function($course){
            $course->setRelation('media', $course->media->map->only(['uuid' , 'original_url']));
        });
        return $data;
    }

    public function delete($id)
    {
        $mediaItem = Media::findByUuid($id);
        return  $mediaItem->delete();
    }

    public function update($request , $uuid){
    
        $course = course::whereHas('media' , function($q) use ($uuid)  {
            $q->where('uuid' , $uuid);
        })->firstOrFail();
        $mediaItem = Media::findByUuid($uuid);
        $data = $course->addMedia($request->file('photo'))
        ->toMediaCollection($mediaItem->collection_name);
       $mediaItem->delete();
       return $data->only(['uuid' , 'original_url']);
    }
}
