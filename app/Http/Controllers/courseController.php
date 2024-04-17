<?php

namespace App\Http\Controllers;

use App\Http\Requests\course\storeRequest;
use App\Http\Requests\course\updateRequest;
use App\Services\repo\interfaces\courseInterface;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;

class courseController extends Controller
{
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeRequest $request)
    {
        return $this->course->store($request);
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
