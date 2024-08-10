<?php

namespace App\Http\Controllers;

use App\Http\Requests\evaluation\storeRequest;
use App\Http\Requests\teacher\courseTeacherRequest;
use App\Services\repo\interfaces\evaluationInterface;
use Illuminate\Http\Request;

class evaluationController extends Controller
{
    protected $evaluation;

    public function __construct(evaluationInterface $evaluation)
    {
        $this->evaluation = $evaluation;
    }

    public function index(courseTeacherRequest $request){
        return $this->evaluation->index($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeRequest $request)
    {
        return $this->evaluation->store($request);
    }
}
