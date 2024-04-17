<?php

namespace App\Services\repo\classes;

use App\Http\Requests\teacher\updateRequest;
use App\Models\teacher;
use App\Services\repo\interfaces\teacherInterface;
use App\Trait\ResponseJson;

class teacherClass implements teacherInterface {
     
    use ResponseJson;
    
    public function index(){
        return teacher::with(['specialty'])->get();
    }

    public function show(string $id){
        try {
            $teacher = teacher::with(['specialty'])->findOrFail($id);
            return $teacher->makeHidden('deleted_at');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {

            return $this->returnError(__('strings.error_teacher_not_found'));
        }
    }


    public function update(updateRequest $request ,string $id){
        try {
            $teacher = teacher::findOrFail($id);
            $teacher->email = $request->email;
            $teacher->first_name = json_encode(['ar' => $request->first_name_ar, 'en' => $request->first_name_en]);
            $teacher->last_name = json_encode(['ar' => $request->last_name_ar, 'en' => $request->last_name_en]);
            $teacher->phoneNumber = $request->phoneNumber;  
            $teacher->speciality_id = $request->speciality_id;
            $teacher->save();
            return $this->returnSuccessMessage(__('strings.update'), $teacher);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->returnError(__('strings.error_teacher_not_found'));
        }
    }


    public function destroy($id)
    {
        try {
               $course = teacher::findOrFail($id)->delete();
                return $this->returnSuccessMessage(trans('strings.delete'), $course);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->returnError(__('strings.error_teacher_not_found'));
        }
    }

    public function restore($id) 
    {
        try {
            $teacher = teacher::onlyTrashed()->findOrFail($id);
            $teacher->restore();
            return $this->returnSuccessMessage(__('strings.restore_teacher') , $teacher);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $th) {
            return $this->returnError(__('strings.error_teacher_not_found'));
        }   
    }


    public function restoreAll() 
    {
        $teachers = teacher::onlyTrashed()->restore(); 
        return $this->returnSuccessMessage(__('strings.restore_All_teacher') , $teachers);
    }
}