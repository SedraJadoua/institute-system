<?php

namespace App\Services\repo\interfaces;

interface attendanceInterface {
 
    public function index();
    public function getTeacherCourses();
    public function attendanceAndPresence(string $courseId);

}