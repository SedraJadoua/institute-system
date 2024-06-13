<?php

namespace App\Services\repo\interfaces;

interface attendanceInterface {
 
    public function index();
    public function getTeacherCourses(string $teacherId);
    public function attendanceAndPresence(string $teacherId ,string $courseId);

}