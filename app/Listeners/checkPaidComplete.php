<?php

namespace App\Listeners;

use App\Events\paymentTransaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class checkPaidComplete
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(paymentTransaction $event): void
    {
        // in table courseTeacherStudent made paid is true
        $courseTeacherStudent = $event->courseTeacherStudent;
        $totalCost = $courseTeacherStudent->courseTeacher->total_cost;
        $sum = $courseTeacherStudent->payments->sum('amount');
        if($totalCost <= $sum){
            $courseTeacherStudent->paid = true;
            $courseTeacherStudent->save();
        }
    } 
}
