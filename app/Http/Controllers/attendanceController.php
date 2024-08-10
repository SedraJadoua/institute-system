<?php

namespace App\Http\Controllers;

use App\Http\Requests\attendance\storeRequest;
use App\Http\Requests\student\courseTeacherStudentRequest;
use App\Http\Requests\teacher\courseTeacherRequest;
use App\Services\repo\interfaces\attendanceInterface;
use Illuminate\Http\Request;

class attendanceController extends Controller
{
    protected $attendance;
    public function __construct(attendanceInterface $attendance)
    {
        $this->attendance = $attendance;
    }

    public function index(courseTeacherRequest $request)
    {
        return $this->attendance->index($request);
    }
 

    public function store(storeRequest $request)
    {
        return $this->attendance->store($request);
    }

    public function studentAttendanceAndPresence(courseTeacherStudentRequest $request)
    {
        return $this->attendance->studentAttendanceAndPresence($request);
    }


    public function attendanceAndPresence(courseTeacherRequest $request)
    {
        return $this->attendance->attendanceAndPresence( $request);
    }
    public function attendanceAndPresence2(courseTeacherRequest $request)
    {
        return $this->attendance->attendanceAndPresence2( $request);
    }
}
