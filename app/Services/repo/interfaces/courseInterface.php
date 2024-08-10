<?php

namespace App\Services\repo\interfaces;

use App\Http\Requests\course\availableHours;
use App\Http\Requests\course\openCourse;
use App\Http\Requests\course\storeRequest;
use App\Http\Requests\course\updateRequest;
use Illuminate\Http\Request;

interface courseInterface{

    public function index(bool $workshop); 
    public function store(storeRequest $request); 
    public function show($id); 
    public function destroy($id);
    public function update(updateRequest $request, string $id);

    public function newestWorkshops();
    public function newestCourses();
    public function progressOfCourse(Request $request);
    public function returnHoursAvilable(availableHours $request);
    public function openNewCourse(openCourse $request);
    public function courseNeedTeacher();
    public function accept(Request $request);
    public function courseNeedTeacherInDash(Request $request);
    public function acceptTeacher(Request $request);
    public function getCoursesofSpeciality(Request $request);
    public function getCoursesAddedOnly();
}