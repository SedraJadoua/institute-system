<?php

namespace App\Http\Controllers;

use App\Services\repo\interfaces\paymentInterface;
use Illuminate\Http\Request;

class paymentController extends Controller
{
    protected $payment;

    public function __construct(paymentInterface $payment)
    {
        $this->payment = $payment;
    }

    public function charge(Request $request){
       return $this->payment->charge($request);    
    }
    
    public function success(Request $request){
       return $this->payment->success($request);    
    }

    public function payError(){
       return $this->payment->payError();    
    }
}
