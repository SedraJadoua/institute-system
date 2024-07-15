<?php 

namespace App\Services\repo\interfaces;

use App\Http\Requests\message\storeRequest;
use Illuminate\Http\Request;

interface messageInterface {
 
    public function index(Request $request);
    public function store(storeRequest $request);
    public function show(Request $request);
}