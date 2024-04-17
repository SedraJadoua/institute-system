<?php 


namespace App\Services\repo\classes;

use App\Http\Requests\auth\adminLogin;
use App\Http\Requests\auth\login;
use App\Http\Requests\auth\studentRegister;
use App\Http\Requests\auth\teacherRegister;
use App\Mail\LoginCredentials;
use App\Models\student;
use App\Models\teacher;
use App\Services\repo\interfaces\authInterface;
use App\Trait\ResponseJson;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\Token;

class auth implements authInterface{

    use ResponseJson;

    public function studentRegister(studentRegister $request){

      $data = $request->validated();
      $userName = strstr($data['email'] , '@' , true);
      $password = str_pad(rand(0 , 999999), 6 , '2' , STR_PAD_LEFT);
      $student = new student();
      $student->first_name = json_encode([ 'en' => $data['first_name_en'] , 'ar' => $data['first_name_ar']]);
      $student->last_name = json_encode([ 'en' => $data['last_name_en'] , 'ar' => $data['last_name_ar']]);
      $student->email= $data['email'];
      $student->password = Hash::make($password);
      $student->user_name = $userName;
      $student->phoneNumber = $data['phoneNumber'];
      $student->age = $data['age'];
      $student->gender = $data['gender'];
      $result = $student->save();
  
      if($result){
        try {
          Mail::to($data['email'])
          ->send(new LoginCredentials($userName , $password));
         } catch (\Throwable $th) {
         return $th->getMessage();
         }
        return $this->returnSuccessMessage(__('auth.Login_Student') , $student);
      }
      return $this->returnError(__('auth.error'));
    }



    public function teacherRegister(teacherRegister $request)
    {
      $data = $request->validated();
      $userName = strstr($data['email'] , '@' , true);
      $password = str_pad(rand(0 , 999999), 6 , '2' , STR_PAD_LEFT);
      $teacher = new teacher();
      $teacher->first_name = json_encode(['en' => $data['first_name_en'] , 'ar' => $data['first_name_ar']]);
      $teacher->last_name = json_encode(['en' => $data['last_name_en'] , 'ar' => $data['last_name_ar']]);
      $teacher->email= $data['email'];
      $teacher->password = Hash::make($password);
      $teacher->user_name = $userName;
      $teacher->phoneNumber = $data['phoneNumber'];
      $result = $teacher->save();
 
      if($result){ 
        try {
          Mail::to($data['email'])
          ->send(new LoginCredentials($userName , $password));
         } catch (\Throwable $th) {
         return $th->getMessage();
         }
        return $this->returnSuccessMessage(__('auth.Login_Teacher') , $teacher);
      }
      return $this->returnError(__('auth.error'));
    }


    public function loginAdmin(adminLogin $request){
        $data = $request->validated();
        $admin = teacher::where('is_admin' , 1)->first();    
        if(!$admin){
          return $this->returnError(__('auth.error'));
        }
        if($data['info'] == $admin->user_name | $data['info'] == $admin->email){
           if(Hash::check($data['password'], $admin->password)){
            Token::where('user_id', $admin->id)->delete();
            $admin->token = $admin->createToken('adminToken')->accessToken;
            return $this->sendResponse($admin , __('auth.Login'));
           }
        }
        return $this->returnError(__('auth.error'));
      }

      public function login(login $request)
      {
        $teacher = teacher::where('user_name', request('user_name'))->first();
        if($teacher)
        {
          if (Hash::check(request('password'), $teacher->password)) {
            Token::where('user_id', $teacher->id)->delete();
            $teacher->token = $teacher->createToken('TeacherToken')->accessToken;
            return $this->sendResponse($teacher, __('auth.Login_Teacher'));
           }
        }

        else if(!$teacher){
          $student = student::where('user_name' , request('user_name'))->first();
          if($student){
            if(Hash::check( request('password'), $student->password)){
              Token::where('user_id' , $student->id)->delete();
              $student->token = $student->createToken('StudentToken')->accessToken;
              return $this->sendResponse($student, __('auth.Login_Student'));
            }
          }
        }
        return $this->returnError(__('auth.error'));
   }



}