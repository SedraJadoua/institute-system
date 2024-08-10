<?php

namespace App\Services\repo\interfaces;

use App\Http\Requests\student\courseTeacherStudentRequest;
use App\Http\Requests\task\indexRequest;
use App\Http\Requests\taskStudent\storeRequest;
use App\Http\Requests\teacher\courseTeacherRequest;
use Illuminate\Http\Request ;

interface taskStudentInterface{

    public function index(indexRequest $request); 
    public function store(storeRequest $request); 
    public function getStudentInCourse(Request $request);
    public function getTasksStudent(Request $request);
    public function marksStudentInCourse(courseTeacherStudentRequest $request);
    public function getMarksForTeacher(courseTeacherRequest $request);
}