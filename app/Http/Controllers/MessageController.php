<?php

namespace App\Http\Controllers;

use App\Http\Requests\message\storeRequest;
use App\Services\repo\interfaces\messageInterface;
use Illuminate\Http\Request;

class MessageController extends Controller
{

    protected $message;

    public function  __construct(messageInterface $message)
    {
        $this->message = $message;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->message->index();   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeRequest $request)
    {
        return $this->message->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $group_id)
    {
        return $this->message->show($group_id);
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
