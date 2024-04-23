<?php

namespace App\Services\repo\interfaces;

use App\Http\Requests\session\storeRequest;
use App\Http\Requests\student\updateRequest;
use Illuminate\Http\Request;

interface sessionInterface {

    public function index();
    public function store(storeRequest $request);
    public function update(updateRequest $request ,string $id);
    public function show(string $id);
    public function destroy(string $id);
}