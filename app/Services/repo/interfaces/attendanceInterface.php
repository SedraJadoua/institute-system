<?php

namespace App\Services\repo\interfaces;

use App\Http\Requests\attendance\storeRequest;
use App\Http\Requests\student\courseTeacherStudentRequest;
use App\Http\Requests\teacher\courseTeacherRequest;
use Illuminate\Http\Request;

interface attendanceInterface {
 
    public function index(courseTeacherRequest $request);
    public function attendanceAndPresence2(courseTeacherRequest $request);
    public function store(storeRequest $request);
    public function attendanceAndPresence(courseTeacherRequest $request);
    public function studentAttendanceAndPresence(courseTeacherStudentRequest $request);
}