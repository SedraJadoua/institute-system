<?php


namespace App\Services\repo\interfaces;

use App\Http\Requests\auth\adminLogin;
use App\Http\Requests\auth\login;
use App\Http\Requests\auth\studentRegister;
use App\Http\Requests\auth\teacherRegister;

interface authInterface{

    public function studentRegister(studentRegister $request);
    public function teacherRegister(teacherRegister $request);
    
    public function loginAdmin(adminLogin $request);
    public function login(login $request);
    
}