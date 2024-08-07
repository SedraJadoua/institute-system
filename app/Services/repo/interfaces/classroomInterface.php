<?php

namespace App\Services\repo\interfaces;

use App\Http\Requests\classroom\storeRequest ;

interface classroomInterface
{
    public function index(); 
    public function store(storeRequest $request);
    public function show($id);
    public function appointments(string $id);
}