<?php

namespace App\Http\Controllers;

use App\Http\Requests\daysSystem\storeRequest;
use App\Services\repo\interfaces\daysSystemInterface;
use Illuminate\Http\Request;

class daysSystemController extends Controller
{
    protected $daysSystem;

    public function __construct(daysSystemInterface $daysSystem)
    {
        $this->daysSystem = $daysSystem;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeRequest $request)
    {
        return $this->daysSystem->store($request);
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
