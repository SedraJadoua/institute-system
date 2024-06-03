<?php

namespace App\Services\repo\interfaces;

use App\Http\Requests\course\storeRequest;
use App\Http\Requests\course\updateRequest;
use App\Http\Requests\task\indexRequest;
use Illuminate\Support\Facades\Request;

interface taskStudentInterface{

    public function index(indexRequest $request); 

    
}