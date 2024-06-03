<?php

namespace App\Http\Controllers;

use App\Http\Requests\photo\storeRequest;
use App\Http\Requests\photo\updateRequest;
use App\Services\repo\interfaces\imageInterface;
use App\Trait\ResponseJson;
use Illuminate\Http\Request;

class imageController extends Controller
{
    use ResponseJson;
     
    protected $image;
    public function __construct(imageInterface $image) {
        $this->image = $image;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(storeRequest $request)
    {
        try {
            $data = $this->image->store($request);
            return $this->sendResponse($data , __('strings.insert_photo'));
        } catch (\Throwable $th) {
          return $this->returnError($th->getMessage());
        }
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
    public function update(updateRequest $request, string $id)
    { 
        $data = [];
        try {
            $data = $this->image->update($request , $id);
            return $this->sendResponse($data , __('strings.update_photo'));
        } catch (\Throwable $th) {
            return $this->returnError(__($th->getMessage()));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = [];
        try {
            $data = $this->image->delete($id);
            return $this->sendResponse($data , __('strings.delete_photo'));
        } catch (\Throwable $th) {
            return $this->returnError(__('strings.error_photo_not_found'));
        }
    }
}
