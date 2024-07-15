<?php

namespace App\Http\Controllers;

use App\Http\Requests\classroom\storeRequest;
use App\Services\repo\interfaces\classroomInterface;
use App\Trait\ResponseJson;
use Illuminate\Http\Request;

class classroomController extends Controller
{
    use ResponseJson;
    protected $classroom;
    public function __construct(classroomInterface $classroom)
    {
       $this->classroom = $classroom; 
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->classroom->index();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeRequest $request)
    {
        $classroom = $this->classroom->store($request);
        return $this->returnSuccessMessage(trans('strings.insert_classroom') , $classroom);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return $this->classroom->show($id);
    }

    public function appointments(string $id){
        return $this->classroom->appointments($id);
    }
}
