<?php

namespace App\Services\repo\classes;

use App\Http\Requests\session\storeRequest;
use App\Http\Requests\student\updateRequest;
use App\Models\session;
use App\Models\student;
use App\Models\teacherCourse;
use App\Services\repo\interfaces\sessionInterface;
use App\Trait\ResponseJson;
use Illuminate\Support\Facades\Request;

class sessionClass implements sessionInterface {
     
    use ResponseJson;
    
    public function index(){
       return session::with(['courseTeacher.daysSystem.classroom' , 'students.attendances'])->get();
    }


    public function store(storeRequest $request)
    {
        // return $request;
        $session = session::create([
            'title' => json_encode([
                'ar' => $request->title_ar,
                'en' => $request->title_en,
            ]),
            'date' => $request->date,
            'course_teacher_id' => $request->course_teacher_id,
        ]);
        
        return $this->returnSuccessMessage(__('strings.insert_session'), $session);
    }

    public function show(string $id){
        try {
            $session = session::with(['students.attendances' , 'courseTeacher'])->findOrFail($id);
            return $session;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->returnError(__('strings.error_session_not_found'));
        }
    }

    public function update(updateRequest $request ,string $id){
        try {
            $student = student::findOrFail($id);
            $student->email = $request->email;
            $student->first_name = json_encode(['ar' => $request->first_name_ar, 'en' => $request->first_name_en]);
            $student->last_name = json_encode(['ar' => $request->last_name_ar, 'en' => $request->last_name_en]);
            $student->phoneNumber = $request->phoneNumber;  
            $student->gender = $request->gender;
            $student->age = $request->age;
            $student->save();
            return $this->returnSuccessMessage(__('strings.update_Student'), $student);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->returnError(__('strings.error_student_not_found'));
        }
    }


    public function destroy($id)
    {
        try {
               $student = student::findOrFail($id)->delete();
                return $this->returnSuccessMessage(trans('strings.delete'), $student);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->returnError(__('strings.error_student_not_found'));
        }
    }


}