<?php

namespace App\Http\Controllers;

use App\Http\Requests\File\storeRequest;
use App\Services\repo\interfaces\fileInterface;
use App\Trait\ResponseJson;
use Illuminate\Http\Request;

class fileController extends Controller
{
    use ResponseJson;
     
    protected $file;


    public function __construct(fileInterface $file)
    {
        $this->file = $file;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(string $sessionId)
    {
        return $this->file->index($sessionId);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeRequest $request)
    {
        $file =  $this->file->store($request) ;
        return $this->returnSuccessMessage(trans('strings.insert_file'), $file);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->file->destroy($id);
        
    }

}
