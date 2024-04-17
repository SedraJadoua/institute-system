<?php

namespace App\Services\repo\interfaces;

use App\Http\Requests\teacher\updateRequest;
use Illuminate\Http\Request;

interface teacherInterface {

    public function index();
    public function update(updateRequest $request ,string $id);
    public function show(string $id);
    public function destroy(string $id);

    public function restore($id);
    public function restoreAll();

}