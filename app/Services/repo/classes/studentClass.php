<?php

namespace App\Services\repo\classes;

use App\Http\Requests\photo\userPhotoRequest;
use App\Http\Requests\student\updateRequest;
use App\Models\student;
use App\Services\repo\interfaces\studentInterface;
use App\Trait\ResponseJson;
use Illuminate\Support\Facades\File;

class studentClass implements studentInterface {
     
    use ResponseJson;
    
    public function index(){
        return student::with(['courseTeacher.teacher' , 'courseTeacher.course'])->get();
    }

    public function show(string $id){
        try {
            $student = student::with(['courseTeacher.attendance' , 'courseTeacher.sessions'])->findOrFail($id);
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


    public function addPhoto(userPhotoRequest $request)
    {
        try 
        {
            $student = student::findOrFail($request->student_id);
            $photo = $request->photo;
            $photoName = time().'.'.$photo->extension();
            $student->photo = $photoName;
            $student->save();
            $photo->move(public_path('storage/images/'),$photoName);
           
            return $this->returnSuccessMessage(trans('strings.photo_add'), $student);
     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
         return $this->returnError(('strings.error_teacher_not_found'));
     }
}


    public function updatePhoto(userPhotoRequest $request)
    {
        try 
        {
            $student = student::findOrFail($request->student_id);
            $fileUrl = parse_url($student->photo);
            $relativePath = $fileUrl['path'];
            File::delete(public_path($relativePath));
            $photo = $request->photo;
            $photoName = time().'.'.$photo->extension();
            $photo->move(public_path('storage/images'),$photoName);
            $student->photo = $photoName;
            $student->save();
            return $this->returnSuccessMessage(trans('strings.photo_add'), $student);
         
     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
         return $this->returnError(('strings.error_teacher_not_found'));
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