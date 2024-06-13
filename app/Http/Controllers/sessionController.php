<?php

namespace App\Http\Controllers;

use App\Http\Requests\session\storeRequest;
use App\Services\repo\interfaces\sessionInterface;
use Illuminate\Http\Request;

class sessionController extends Controller
{

    protected $session;

    public function __construct(sessionInterface $session) {
        $this->session = $session;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->session->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeRequest $request)
    {
         return $this->session->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       return $this->session->show($id);
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
