<?php

namespace App\Services\repo\interfaces;

use App\Http\Requests\daysSystem\storeRequest;

interface daysSystemInterface{

    public function store(storeRequest $request);
}