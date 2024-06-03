<?php

namespace App\Services\repo\classes;

use App\Http\Requests\task\indexRequest;
use App\Services\repo\interfaces\taskInterface;
use App\Trait\ResponseJson;

class taskClass implements taskInterface
{
    use ResponseJson;

    public function index()
    {
        return 'se';
    }


}
