<?php

namespace App\Http\Controllers;

use App\Http\Requests\daysSystem\storeRequest;
use App\Services\repo\interfaces\daysSystemInterface;
use Illuminate\Http\Request;

class daysSystemController extends Controller
{
    protected $daysSystem;

    public function __construct(daysSystemInterface $daysSystem)
    {
        $this->daysSystem = $daysSystem;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeRequest $request)
    {
        return $this->daysSystem->store($request);
    }
}
