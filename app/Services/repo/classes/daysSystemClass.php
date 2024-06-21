<?php

namespace App\Services\repo\classes;

use App\Http\Requests\daysSystem\storeRequest;
use App\Models\classroom;
use App\Models\daysSystem;
use App\Services\repo\interfaces\daysSystemInterface;
use App\Trait\ResponseJson;

class daysSystemClass implements daysSystemInterface {
 
    use ResponseJson;

    public function store(storeRequest $request){
    }
}