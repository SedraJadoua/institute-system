<?php

namespace App\Http\Controllers;

use App\Http\Requests\specialty\storeRequest;
use App\Services\repo\interfaces\specialtInterface;
use Illuminate\Http\Request;

class specialtyController extends Controller
{
    protected $specialty;

    public function __construct(specialtInterface $specialty) {
        $this->specialty = $specialty;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->specialty->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeRequest $request)
    {
        return $this->specialty->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->specialty->show($id);
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
