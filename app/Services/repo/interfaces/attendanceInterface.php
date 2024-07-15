<?php

namespace App\Services\repo\interfaces;

use Illuminate\Http\Request;

interface attendanceInterface {
 
    public function index();
    public function getTeacherCourses(Request $request);
    public function attendanceAndPresence(Request $request);

}