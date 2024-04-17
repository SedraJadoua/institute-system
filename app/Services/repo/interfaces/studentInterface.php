<?php

namespace App\Services\repo\interfaces;

use App\Http\Requests\student\updateRequest;
use Illuminate\Http\Request;

interface studentInterface {

    public function index();
    public function update(updateRequest $request ,string $id);
    public function show(string $id);
    public function destroy(string $id);

    public function restore($id);
    public function restoreAll();



}