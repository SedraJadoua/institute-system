<?php

namespace App\Services\repo\interfaces;

use App\Http\Requests\task\indexRequest;
use Illuminate\Http\Request ;

interface taskStudentInterface{

    public function index(indexRequest $request); 
    // public function store(Request $request); 
    public function getStudentInCourse(string $id);
    
}