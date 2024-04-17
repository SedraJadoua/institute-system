<?php

namespace App\Http\Controllers;

use App\Http\Requests\auth\adminLogin;
use App\Http\Requests\auth\login;
use App\Http\Requests\auth\studentRegister;
use App\Http\Requests\auth\teacherRegister;
use App\Services\repo\interfaces\authInterface;

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
}
