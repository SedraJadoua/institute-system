<?php

namespace App\Http\Controllers;

use App\Http\Requests\auth\adminLogin;
use App\Http\Requests\auth\codeCheckRequest;
use App\Http\Requests\auth\login;
use App\Http\Requests\auth\student\changePasswordRequest;
use App\Http\Requests\auth\student\forgotPasswordRequest;
use App\Http\Requests\auth\studentRegister;
use App\Http\Requests\auth\teacherRegister;
use App\Services\repo\interfaces\authInterface;
use Illuminate\Http\Request;

class auth extends Controller
{
    public $auth;

    public function __construct(authInterface $auth)
    {
        $this->auth = $auth;
    }


    public function studentRegister(studentRegister $request){
       return $this->auth->studentRegister($request);
    }

    public function teacherRegister(teacherRegister $request){
       return $this->auth->teacherRegister($request);
    }

    public function loginAdmin(adminLogin $request){
       return $this->auth->loginAdmin($request);
    }

    public function login(login $request){
       return $this->auth->login($request);
    }

    public function forgotPassword(forgotPasswordRequest $request){
       return $this->auth->forgotPassword($request);
    }
    public function changePassword(changePasswordRequest $request){
       return $this->auth->changePassword($request);
    }
}
