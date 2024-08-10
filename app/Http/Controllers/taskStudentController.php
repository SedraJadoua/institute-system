<?php

namespace App\Http\Controllers;

use App\Http\Requests\student\courseTeacherStudentRequest;
use App\Http\Requests\task\indexRequest;
use App\Http\Requests\taskStudent\storeRequest;
use App\Http\Requests\teacher\courseTeacherRequest;
use App\Services\repo\interfaces\taskStudentInterface;
use Illuminate\Http\Request;

class taskStudentController extends Controller
{

   protected $taskStudent;

   public function __construct(taskStudentInterface $taskStudent)
   {
     $this->taskStudent = $taskStudent;
   }

    /**
     * Display a listing of the resource.
     */
    public function index(indexRequest $request)
    {
        return $this->taskStudent->index($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeRequest $request)
    {
        return $this->taskStudent->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function getTasksStudent(Request $request)
    {
        return $this->taskStudent->getTasksStudent($request);
    }

    
    public function marksStudentInCourse(courseTeacherStudentRequest $request)
    {
        return $this->taskStudent->marksStudentInCourse($request);
    }

    


    public function getMarksForTeacher(courseTeacherRequest $request)
    {
        return $this->taskStudent->getMarksForTeacher($request);
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


    public function getStudentInCourse(Request $request)
    {
        return $this->taskStudent->getStudentInCourse($request);
    }
}
