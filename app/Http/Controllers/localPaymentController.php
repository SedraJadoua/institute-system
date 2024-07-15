<?php

namespace App\Http\Controllers;

use App\Services\repo\interfaces\localPaymentInterface;
use Illuminate\Http\Request;

class localPaymentController extends Controller
{
    protected $localPay;
    public function __construct(localPaymentInterface $localPay)
    {
        $this->localPay = $localPay;
    }

    public function index(Request $requst)
    {
        return $this->localPay->index($requst);
    }
    
    public function store(Request $requst)
    {
        return $this->localPay->store($requst);
    }

    public function show(Request $requst)
    {
        return $this->localPay->show($requst);
    }
}
