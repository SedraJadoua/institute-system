<?php

namespace App\Services\repo\classes;

use App\Events\paymentTransaction;
use App\Models\courseTeacherStudent;
use App\Models\payment;
use App\Services\repo\interfaces\localPaymentInterface;
use App\Trait\ResponseJson;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class localPaymentClass implements localPaymentInterface{

    use ResponseJson;


    public function index(){
       
     $courseTeacherStudent =  courseTeacherStudent::where('paid' , 0)->get();
      return $courseTeacherStudent->map(function($item){          
            $student =   $item->student;
            $courseTeacher  = $item->courseTeacher;
            $course  = $courseTeacher->course;
            $sum_of_payments = $item->payments->sum('amount');
            $total_cost = $courseTeacher->total_cost;
            $left_payment = $total_cost - $sum_of_payments;
            if($left_payment < 0){
                $left_payment = 0;
            }
            return [
             'student_name' => $student->first_name." ". $student->last_name,
             'course_name' => $course->name,
             'left_payment' => $left_payment,  
            ];
       });    
    }

    public function show(Request $request)
    {
        try 
        {
            $courseTeacherStudent = courseTeacherStudent::
            where('course_teacher_id' , $request->course_teacher_id)
            ->where('student_id' , $request->student_id)
            ->with('payments')
            ->first();
            if(!$courseTeacherStudent){
                return $this->returnError(trans('strings.some_thing_went_wrong'));
            }
            // return $courseTeacherStudent;
            $total_cost = $courseTeacherStudent->courseTeacher->total_cost;
            $pay = $courseTeacherStudent->payments->sum('amount');
            $left_payment  = $total_cost - $pay;
            if($left_payment < 0 ){
            $left_payment = 0;
            }
            $payments =  $courseTeacherStudent->payments->map(function($item){
            $date = Carbon::parse($item->date);
            $created_at =  Carbon::parse($item->created_at);
            return [
                    'date' => $item->date,
                    'day' => $date->format('l'),
                    'amount' => $item->amount,
                    'payment_method' => $item->payment_method,
                    'hour' => $created_at->format('h:i A'),
                ];
            })->toArray();

           return [
                'left payments' => $left_payment,
                'payments' => $payments,
            ];
        } catch (\Throwable $th) {
            return $this->returnError($th->getMessage());
        }

    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $validate = Validator::make(
                $request->all(),
                [
                 'amount' => 'required|numeric' , 
                 'course_teacher_id' => 'required|exists:course_teacher,id',
                 'student_id' => 'required|exists:students,id',
                ]
            );
            if($validate->fails()){
                return $this->sendListError($validate->errors());
            }
            $courseTeacherStudent = courseTeacherStudent::where('course_teacher_id' , $request->course_teacher_id)
                ->where('student_id' , $request->student_id)
                ->first();
            $total_payment = $courseTeacherStudent->payments->sum('amount');

            if($courseTeacherStudent->paid == 1 ){
                return $this->returnSuccessMessage(trans('strings.The_full_amount_has_been_paid'));
            }           
            $amount =  $request->amount * 4000;
            $total_cost =  $courseTeacherStudent->courseTeacher->total_cost;
            $left_payment = $total_cost - $total_payment;
            
            if($amount > $left_payment)
            {
              return $this->returnError(trans('strings.remaining_amount').$left_payment/4000 ."$");
            }
            $payment = new payment();
            $payment->date = now();
            // $payment->payment_id = $arr_body['id'];
            $payment->payment_method ='0';
            $payment->teacher_course_student_id =  $courseTeacherStudent->id;
            $payment->amount = $amount;
            $payment->save(); 
             
            DB::commit();

            event(new paymentTransaction($courseTeacherStudent));


            return $this->sendResponse($payment ,trans('strings.insert_payment'));
        
        } catch (\Throwable $th) {
            DB::rollBack();
           return $this->returnError($th->getMessage());
        }
    }

}