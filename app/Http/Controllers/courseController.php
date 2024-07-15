<?php

namespace App\Http\Controllers;

use App\Http\Requests\course\availableHours;
use App\Http\Requests\course\openCourse;
use App\Http\Requests\course\storeRequest;
use App\Http\Requests\course\updateRequest;
use App\Services\repo\interfaces\courseInterface;
use App\Trait\ResponseJson;
use Illuminate\Http\Request;

class courseController extends Controller
{
   use ResponseJson;

    protected $course;
    public function __construct(courseInterface $course) {
        $this->course = $course;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function newestWorkshop()
    {
        return $this->course->newestWorkshops();
    }

    public function newestCourses()
    {
        return $this->course->newestCourses();
    }


    public function progressOfCourse(Request $request)
    {
        return $this->course->progressOfCourse($request);
    }


    public function openNewCourse(openCourse $request)
    {
        return $this->course->openNewCourse($request);
    }


    public function returnHoursAvilable(availableHours $request)
    {
        return $this->course->returnHoursAvilable($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeRequest $request)
    {
        $data =[];
        try {
           $data =  $this->course->store($request);
           return  $this->returnSuccessMessage(__('strings.insert_course'),$data);
        } catch (\Throwable $th) {
            return $this->returnError($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->course->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateRequest $request, string $id)
    {
      return $this->course->update($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->course->destroy($id);
    }
}
