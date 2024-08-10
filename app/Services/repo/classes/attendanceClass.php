<?php

namespace App\Services\repo\classes;

use App\Http\Requests\attendance\storeRequest;
use App\Http\Requests\student\courseTeacherStudentRequest;
use App\Http\Requests\teacher\courseTeacherRequest;
use App\Models\attendance;
use App\Models\session;
use App\Models\teacherCourse;
use App\Services\repo\interfaces\attendanceInterface;
use App\Trait\ResponseJson;
use Throwable;

class attendanceClass implements attendanceInterface {

    use ResponseJson;

    public function index(courseTeacherRequest $request)
    {
        
        return  teacherCourse::whereId($request->course_teacher_id)
        
        ->with(['students','sessions.attendances' ])
        ->get();       
    }

    public function store(storeRequest $request)
    { 
       $attendance = attendance::where('session_id', $request->session_id)
       ->where('student_id' , $request->student_id)
       ->first();

       if($attendance){
         $attendance->status = $request->status;
         $attendance->save();
        return $this->sendResponse($attendance , trans('strings.update_attendance_successfully'));
       } 

       $attendance = attendance::create([
        'student_id' => $request->student_id,
        'session_id' => $request->session_id,
        'status' => $request->status,
       ]);
       return $this->sendResponse($attendance , trans('strings.insert_attendance'));
    }


    public function studentAttendanceAndPresence(courseTeacherStudentRequest $request)
    {
       $data = [];
       $presence = 0;
        $totalDays = teacherCourse::whereId($request->course_teacher_id)
        ->value('total_days');
       for ($i= 1; $i <= $totalDays; $i++) { 
         $sessionId  = session::where('course_teacher_id' , $request->course_teacher_id)
        ->where('number_of_session' , $i)
        ->value('id');
        if($sessionId != null ){
            $attendance = attendance::where('session_id' ,$sessionId )
            ->where('student_id' , $request->student_id)->value('status');
            if($attendance == 1) {
                $presence++;
            }
            $data['session'.$i] =   $attendance;
        }else {
            $data['session'.$i] = null;
        
        }
       }
       $data['AttendanceRate'] = $presence/$totalDays;
       return $data;

    }

    public function attendanceAndPresence2(courseTeacherRequest $request) {
         try{
          $teacherCourse = TeacherCourse::with('students.sessions.attendances')
          ->findOrFail($request->course_teacher_id);
          
          return $teacherCourse->students->map(function($item){
            $student_id = $item->id;
              return [
                'id' => $student_id,
                'name' => $item->first_name . ' ' . $item->last_name,
                'sessions' => $item->sessions->map(function($item) use ($student_id) {
                        $attendance = $item->attendances
                        ->where('student_id', $student_id)
                        ->first();
        
                    return [
                        'id' => $item->id,
                        'number_of_session' => $item->number_of_session,
                        'attendance' => $attendance ? $attendance->status  : null,
                    ];
              
          })
        ];
    });

         }  catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->returnError(__('strings.error_course_not_found'));
           }  
           catch (Throwable $e) {
            return $this->returnError($e->getMessage());
        }
    }
    

    public function attendanceAndPresence(courseTeacherRequest $request)
    {
        try {
            $teacherCourse =  teacherCourse::whereId($request->course_teacher_id)
            ->first();

            if ($teacherCourse) {
            return [
            'students' => $teacherCourse->students->map(function($item){
               return [
                'id' => $item->id,
                'name' => $item->first_name . ' ' . $item->last_name,
               ];
            }),
            'sessions' => $teacherCourse->sessions->map(function($item) {
            return [
                'id' => $item->id,
                'number_of_sessions' => $item->number_of_session,
                'students' => $item->attendances ? $item->attendances->map(function($attendance) {
            return [
                'id' => $attendance->student->id ?? null,
                'name' => $attendance->student->first_name . ' ' . $attendance->student->last_name,
                'attendance' => $attendance->status ?? 0,
            ];
        }) : null,
    ];
}),
            ];
        }
            ;
            }
            catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->returnError(__('strings.error_course_not_found'));
           }  
           catch (Throwable $e) {
            return $this->returnError($e->getMessage());
        }
    }
}