<?php

namespace App\Http\Controllers;

use App\Http\Requests\teacher\updateRequest;
use App\Services\repo\interfaces\teacherInterface;
use Illuminate\Http\Request;


class teacherController extends Controller
{
    protected $teacher;

    public function __construct(teacherInterface $teacher) {
        $this->teacher = $teacher;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->teacher->index();
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
        return $this->teacher->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateRequest $request, string $id)
    {
        return $this->teacher->update($request , $id);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->teacher->destroy($id);
    }


    public function restore( $id)
    {
        return $this->teacher->restore($id);
    }
   
    public function restoreAll()
    {
        return $this->teacher->restoreAll();
    }
   
}
