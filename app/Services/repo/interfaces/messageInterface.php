<?php 

namespace App\Services\repo\interfaces;

use App\Http\Requests\message\storeRequest;

interface messageInterface {
 
    public function index();
    public function store(storeRequest $request);
    public function show(string $group_id);
}