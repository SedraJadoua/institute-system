<?php

namespace App\Services\repo\interfaces;

use App\Http\Requests\course\storeRequest;
use App\Http\Requests\course\updateRequest;

interface courseInterface{

    public function index(); 
    public function store(storeRequest $request); 
    public function show($id); 
    public function destroy($id);
    public function update(updateRequest $request, string $id);

    public function newestWorkshops();
    public function newestCourses();
    public function ProgressOfCourse($request);
    
}