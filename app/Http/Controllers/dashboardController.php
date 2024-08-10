<?php 

namespace App\Http\Controllers;

use App\Services\repo\interfaces\dashboardInterface;

class dashboardController extends Controller{

    protected $dash;

    public function __construct(dashboardInterface $dash)
    {
        $this->dash = $dash;
    }


    public function statistics(){
       return $this->dash->statistics();
    }
    
    public function courses(){
       return $this->dash->courses();
    }
    public function workshops(){
       return $this->dash->workshops();
    }
}