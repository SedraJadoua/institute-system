<?php

namespace App\Http\Controllers;

use App\Services\repo\interfaces\attendanceInterface;
use Illuminate\Http\Request;

class attendanceController extends Controller
{
    protected $attendance;
    public function __construct(attendanceInterface $attendance)
    {
        $this->attendance = $attendance;
    }

    public function getTeacherCourses(Request $request)
    {
        return $this->attendance->getTeacherCourses($request);
    }


    public function attendanceAndPresence(Request $request)
    {
        return $this->attendance->attendanceAndPresence( $request);
    }
}
