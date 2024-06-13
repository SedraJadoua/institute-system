<?php  

namespace App\Services\repo\interfaces;

use App\Http\Requests\File\storeRequest;

interface fileInterface {

    public function index(string $sessionId);
    public function store(storeRequest $request);
    public function destroy(string $id);
}