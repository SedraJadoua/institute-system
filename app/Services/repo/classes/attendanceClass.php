<?php

namespace App\Services\repo\classes;

use App\Models\course;
use App\Models\session;
use App\Models\teacher;
use App\Models\teacherCourse;
use App\Services\repo\interfaces\attendanceInterface;
use App\Trait\ResponseJson;
use Auth;

class attendanceClass implements attendanceInterface {

    use ResponseJson;

    public function index()
    {
         
    }

    public function getTeacherCourses()
    {
        $teacher_id =  Auth::guard('teacher')->user()->id;
        $teacher = teacher::where('id' , $teacher_id)->with(['teacherCourse.course'])->get();
        if($teacher){
        $data = [];
        $jsonData = json_decode($teacher, true);
        $courses =  $jsonData[0]['teacher_course'];
        for ($i = 0; $i < count($courses); $i++) {
            $courseData = [];
            $courseData['teacher_course'] = $courses[$i];
            $session = session::where('course_teacher_id', $courses[$i]['id'])->get();
            $courseData['teacher_course']['Progress']  = round(count($session) / $courses[$i]['total_days'], 2);           
            $data[] = $courseData;
        }
          return $data;
       }
        return $this->returnError(__('strings.error_teacher_not_found'));
    }

    public function attendanceAndPresence(string $courseId)
    {
        try {
            course::findOrFail($courseId);
            $teacherCourse =
             teacherCourse::where('teacher_id' ,Auth::guard('teacher')->user()->id)
            ->where('course_id' , $courseId)
            ->with(['sessions.attendances.student' , 'students'])
            ->first();
            return $teacherCourse;
            }
            catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->returnError(__('strings.error_course_not_found'));

           }  
        
        }
}