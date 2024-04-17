<?php

namespace App\Services\repo\classes;

use App\Http\Requests\student\updateRequest;
use App\Models\student;
use App\Services\repo\interfaces\studentInterface;
use App\Trait\ResponseJson;

class studentClass implements studentInterface {
     
    use ResponseJson;
    
    public function index(){
        return student::with(['courseTeacher'])->get();
    }

    public function show(string $id){
        try {
            $student = student::with(['courseTeacher'])->findOrFail($id);
            return $student->makeHidden('deleted_at');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return $this->returnError(__('strings.error_student_not_found'));
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

    public function restore($id) 
    {
        try {
            $student = student::onlyTrashed()->findOrFail($id);
            $student->restore();
            return $this->returnSuccessMessage(__('strings.restore_teacher') , $student);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->returnError(__('strings.error_student_not_found'));
        }   
    }


    public function restoreAll() 
    {
        $students = student::onlyTrashed()->restore(); 
        return $this->returnSuccessMessage(__('strings.restore_All_student') , $students);
    }
}