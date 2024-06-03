<?php

namespace App\Http\Controllers;

use App\Http\Requests\task\indexRequest;
use App\Services\repo\interfaces\taskInterface;
use App\Services\repo\interfaces\taskStudentInterface;
use Illuminate\Http\Request;

class taskController extends Controller
{

   protected $task;

   public function __construct(taskInterface $task)
   {
     $this->task = $task;
   }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->task->index();
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
}
