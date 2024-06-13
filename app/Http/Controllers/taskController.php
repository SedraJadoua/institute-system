<?php

namespace App\Http\Controllers;

use App\Http\Requests\task\storeRequest;
use App\Services\repo\interfaces\taskInterface;
use App\Trait\ResponseJson;

class taskController extends Controller
{
   use ResponseJson;
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
    public function store(storeRequest $request)
    {
      $task =  $this->task->store($request);
      return $this->returnSuccessMessage(trans('strings.insert_task') ,$task );
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
    public function update(storeRequest $request, string $id)
    {
        $task = $this->task->update($request , $id);
        return $this->returnSuccessMessage(trans('strings.update') , $task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
