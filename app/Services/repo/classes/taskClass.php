<?php

namespace App\Services\repo\classes;

use App\Http\Requests\task\indexRequest;
use App\Http\Requests\task\storeRequest;
use App\Models\task;
use App\Services\repo\interfaces\taskInterface;
use App\Trait\ResponseJson;
use Carbon\Carbon;

class taskClass implements taskInterface
{
    use ResponseJson;

    public function index()
    {
    }

    public function store(storeRequest $request)
    {
      $date = Carbon::createFromFormat('d-m-Y H:i', $request->date)->format('Y-m-d H:i:s');

       $task = task::Create([
        "name" => json_encode([
          "ar" => $request->name_ar,
          "en" => $request->name_en,
        ]),
        "mark" =>  $request->mark,
        "date" => $date,
        "course_teacher_id"=> $request->course_teacher_id,
       ]);
       return $task;
    }
   
    public function update(storeRequest $request , string $id)
    {
      
      try {
        $task = task::findOrFail($id);
        $date = Carbon::createFromFormat('d-m-Y H:i' , $request->date)->format('Y-m-d H:i:s');
        $task->mark = $request->mark;
        $task->name = json_encode(['ar' => $request->name_ar, 'en' => $request->name_en]);
        $task->date = $date;  
        $task->course_teacher_id = $request->course_teacher_id;
        $task->save();
        return $task;
         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return $this->returnError(__('strings.error_student_not_found'));
      }    
    }

}
