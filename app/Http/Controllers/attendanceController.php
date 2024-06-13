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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
      
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function getTeacherCourses(string $teacherId)
    {
        return $this->attendance->getTeacherCourses($teacherId);
    }


    public function attendanceAndPresence(string $teacherId , string $courseId)
    {
        return $this->attendance->attendanceAndPresence($teacherId , $courseId);
    }
}