<?php

namespace App\Services\repo\interfaces;

use App\Http\Requests\evaluation\storeRequest;
use App\Http\Requests\teacher\courseTeacherRequest;

interface evaluationInterface{
    public function index(courseTeacherRequest $request);
    public function store(storeRequest $request);
}