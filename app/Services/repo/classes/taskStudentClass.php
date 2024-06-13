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
        return  course::whereHas('tasks', function($q) use ($request) {
          $q->whereRaw('DATE(date) = ?',$request->date);
        })
        ->whereHas('courseTeacherStudent'  , function($q) use ($request) {
          $q->where('student_id',$request->student_id);
        })
        ->with(['tasks'])
        ->get();
    }
   
    public function getStudentInCourse(string $id)
    {
      try {
        $course = course::findOrFail($id)->where('id' , $id)
        ->with(['courseTeacherStudent.student','courseTeacherStudent.taskStudent'])
        ->get();
         return $course;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->returnError(__('strings.error_course_not_found'));
        }
    }
   

}
