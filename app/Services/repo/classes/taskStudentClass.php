<?php

namespace App\Services\repo\classes;

use App\Http\Requests\task\indexRequest;
use App\Models\course;
use App\Services\repo\interfaces\taskStudentInterface;
use App\Trait\ResponseJson;
use Auth;

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
        
        // return Auth::guard('teacher')->user()->id;
        // return course::findOrFail($id)->where('id' , $id)
        // ->whereHas(['courseTeacher' => function($q){
        //     $q->where('teacher_id',  Auth::guard('teacher')->user()->id );
        //   }])
        // ->get();

        return course::where('id', $id)
        ->whereHas('courseTeacher', function ($query) {
            $query->where('teacher_id', Auth::guard('teacher')->user()->id );
        })->with(['courseTeacherStudent' => function($q){
          $q->with(['student' , 'taskStudent']);
          }]
        )
        ->get();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->returnError(__('strings.error_course_not_found'));
        }
    }
   

}
