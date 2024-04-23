<?php

namespace App\Services\repo\interfaces;

use App\Http\Requests\specialty\storeRequest;

interface specialtInterface {
    public function index();
    public function store(storeRequest $request);
    public function show(string $id); 
}