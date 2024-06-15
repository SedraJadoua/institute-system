<?php 

namespace App\Services\repo\classes;

use App\Models\courseTeacherStudent;
use App\Models\payment;
use App\Models\teacherCourse;
use App\Services\repo\interfaces\paymentInterface;
use App\Trait\ResponseJson;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Omnipay\Omnipay;

class paymentClass implements paymentInterface {

    use ResponseJson;
    private $gateway;

    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(true);
    }


    public function charge(Request $request){
         $validate = Validator::make(
            $request->all(),
            [
             'amount' => 'required|numeric' , 
             'course_id' => 'required|exists:courses,id',
             'teacher_id' => 'required|exists:teachers,id',
            ]
        );

        if($validate->fails()){
            return $this->sendListError($validate->errors());
        }

        try {
            $courseTeacher = teacherCourse::where('course_id',$request->post('course_id') )
            ->where('teacher_id' ,$request->post('teacher_id'))
            ->first();
            $courseTeacherStudent = courseTeacherStudent::where('course_teacher_id' , $courseTeacher->id)
            ->where('student_id' , auth()->user()->id)
            ->first();
            $response = $this->gateway->purchase(array(
                'amount' => '20000',
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => route('success' , ['course_teacher_student'=> '9c497122-26af-48dd-a6a9-3a74caed9112']),
                'cancelUrl' => route('payError' , ['course_teacher_student'=> '9c497122-26af-48dd-a6a9-3a74caed9112']),
            ))->send();
           
            if ($response->isRedirect()) {
                return response()->json([
                    'redirect_url' => $response->getRedirectUrl(),
                ]);   
            } else {
                return $this->returnError($response->getMessage());
            }
        } catch(Exception $e) {
            return $this->returnError($e->getMessage());
        }
    
    }


    public function success(Request $request){
      
       
        if ($request->input('paymentId') && $request->input('PayerID'))
        {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id'             => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();
          
            if ($response->isSuccessful())
            {
                // The customer has successfully paid.
                $arr_body = $response->getData();
          
                // Insert transaction data into the database
                $payment = new payment();
                $payment->date = now();
                $payment->payment_id = $arr_body['id'];
                $payment->payment_method = $arr_body['payer']['payment_method'];
                $payment->teacher_course_student_id =  $request->get('course_teacher_student');
                $payment->amount = $arr_body['transactions'][0]['amount']['total'];
                $payment->save();
          
                return response()->json([
                    'message' => trans('strings.payment_successfully').$arr_body['id'], 
                ]);
            } else {
                return response()->json([
                    'error' => $response->getMessage()
                ]);
            }
        } else {
            return response()->json([
                'error' => trans('strings.Transaction_is_declined')
            ]);
         }
    }

    public function payError(){
          return $this->returnError(trans('string.User_cancelled_the_payment'));
    }
}