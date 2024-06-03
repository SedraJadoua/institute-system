<?php

namespace App\Services\repo\classes;

use App\Http\Requests\task\indexRequest;
use App\Models\course;
use App\Services\repo\interfaces\taskStudentInterface;
use App\Trait\ResponseJson;

class taskStudentClass implements taskStudentInterface
{
    use ResponseJson;

    public function index(indexRequest $request)
    {
  return  course::whereHas('courseTeacherStudent.taskStudent', function($q) use ($request) {
      $q->whereRaw('DATE(date) = ?',$request->date);
    })
    ->whereHas('courseTeacherStudent'  , function($q) use ($request) {
      $q->where('student_id',$request->student_id);
    })
    ->with(['courseTeacherStudent.taskStudent'])
    ->get();
    }


}
