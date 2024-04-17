<?php

namespace App\Http\Controllers;

use App\Http\Requests\student\updateRequest;
use App\Services\repo\interfaces\studentInterface;
use Illuminate\Http\Request;

class studentController extends Controller
{
    protected $student;
    public function __construct(studentInterface $student)
    {
       $this->student = $student; 
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->student->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->student->show($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateRequest $request, string $id)
    {
        return $this->student->update($request , $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->student->destroy($id);
    }

    public function restore($id)
    {
        return $this->student->restore($id);
    }
   
    public function restoreAll()
    {
        return $this->student->restoreAll();
    }
}
