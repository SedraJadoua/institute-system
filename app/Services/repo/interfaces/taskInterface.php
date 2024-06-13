<?php

namespace App\Services\repo\interfaces;

use App\Http\Requests\task\indexRequest;
use App\Http\Requests\task\storeRequest;

interface taskInterface{

 public function index();    
 public function store(storeRequest $request);
 public function update(storeRequest $request , string $id);
}