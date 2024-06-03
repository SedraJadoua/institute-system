<?php


namespace App\Services\repo\interfaces;

use App\Http\Requests\photo\storeRequest;

interface imageInterface{

    public function store(storeRequest $request); 
    public function delete($id);
    public function update( $request,  $id);
}