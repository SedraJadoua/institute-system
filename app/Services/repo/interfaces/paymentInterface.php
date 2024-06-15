<?php 

namespace App\Services\repo\interfaces;

use Illuminate\Http\Request;

interface paymentInterface {
 
    public function charge(Request $request);
    public function success(Request $request);
    public function payError();
}