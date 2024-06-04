<?php


namespace App\Services\repo\interfaces;

use App\Http\Requests\auth\adminLogin;
use App\Http\Requests\auth\codeCheckRequest;
use App\Http\Requests\auth\login;
use App\Http\Requests\auth\student\changePasswordRequest;
use App\Http\Requests\auth\student\forgotPasswordRequest;
use App\Http\Requests\auth\studentRegister;
use App\Http\Requests\auth\teacherRegister;
use Illuminate\Http\Request;

interface authInterface{

    public function studentRegister(studentRegister $request);
    public function teacherRegister(teacherRegister $request);
    
    public function loginAdmin(adminLogin $request);
    public function login(login $request);
    public function forgotPassword(forgotPasswordRequest $request);
    public function changePassword(changePasswordRequest $request);
    
}