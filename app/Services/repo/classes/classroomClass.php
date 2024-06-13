<?php

namespace App\Services\repo\classes;

use App\Http\Requests\classroom\storeRequest;
use App\Models\classroom;
use App\Services\repo\interfaces\classroomInterface;
use App\Trait\ResponseJson;

class classroomClass implements classroomInterface
{
    use ResponseJson;

    public function index()
    {
       return classroom::with('daysSystem')->get();
    }


    public function store(storeRequest $request)
    {
      if($request->has('status')){
        $classRoom = classroom::Create([
            'name' => json_encode([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
            ]),
            'status' => $request->status,
            'size' => $request->size,
        ]);
      }
      else {
        $classRoom = classroom::Create([
            'name' => json_encode([
                'name_ar' => $request->name_ar,
                'name_en' => $request->name_en,
            ]),
            'size' => $request->size,
        ]);
      }
      
      return $classRoom;
    }

}
