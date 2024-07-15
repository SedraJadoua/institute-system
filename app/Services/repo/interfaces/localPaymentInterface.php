<?php

namespace  App\Services\repo\interfaces;

use Illuminate\Http\Request;

interface localPaymentInterface {

    public function index();
    public function store(Request $request);
    public function show(Request $request);
}