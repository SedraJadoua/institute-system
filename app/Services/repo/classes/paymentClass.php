<?php 

namespace App\Services\repo\classes;

use App\Events\paymentTransaction;
use App\Models\courseTeacherStudent;
use App\Models\payment;
use App\Models\teacherCourse;
use App\Services\repo\interfaces\paymentInterface;
use App\Trait\ResponseJson;
use DB;
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

    public function charge(Request $request)
    {
        try
        {
        DB::beginTransaction();
        $validate = Validator::make(
        $request->all(),
        [
        'amount' => 'required|numeric' , 
        'course_teacher_id' => 'required|exists:course_teacher,id',
        'student_id' => 'required|exists:students,id',
        ]
        );
        $clientId = env('PAYPAL_CLIENT_ID');
        $secret = env('PAYPAL_CLIENT_SECRET');
    
        if (empty($clientId) || empty($secret)) {
            return $this->returnError('PayPal credentials are not set.');
        }
    
        if($validate->fails()){
            return $this->sendListError($validate->errors());
        }

        $courseTeacherStudent = courseTeacherStudent::
        where('course_teacher_id' , $request->course_teacher_id)
        ->where('student_id' , $request->student_id)
        ->first();
        $response = $this->gateway->purchase(array(
            'amount' => $request->post('amount'),
            'currency' => env('PAYPAL_CURRENCY'),
            'returnUrl' => route('success' 
            ,['course_teacher_student'=> $courseTeacherStudent]
            ),
            'cancelUrl' => route('payError'),
            ))->send();
            if ($response->isRedirect()) {
            // for API
            return response()->json([
                'redirect_url' => $response->getRedirectUrl(),
            ]);   
            // for web
            // $response->redirect();
    
            } 
            else {
                return $this->returnError($response->getMessage());
            }
            DB::commit();
        } catch(Exception $e) {
            DB::rollBack();
            return $this->returnError($e->getMessage());
        }
    
    }


    public function success(Request $request){
        try 
        {
        DB::beginTransaction();


        if ($request->input('paymentId') && $request->input('PayerID'))
        {
        $transaction = $this->gateway->completePurchase(array(
            'payer_id'             => $request->input('PayerID'),
            'transactionReference' => $request->input('paymentId'),
        ));
        $response = $transaction->send();
        
        $courseTeacherStudent = courseTeacherStudent::findOrFail($request->get('course_teacher_student'));
        if(!$courseTeacherStudent){
            return $this->returnError(trans('strings.register_to_course'));
        }
        if($courseTeacherStudent->paid == 1 ){
            return $this->returnSuccessMessage(trans('strings.The_full_amount_has_been_paid'));
        }    
        if ($response->isSuccessful())
        {
        // The customer has successfully paid.
        $arr_body = $response->getData();
        // check for flag paid
             
        $total_payment = $courseTeacherStudent->payments->sum('amount');
        $amount = $arr_body['transactions'][0]['amount']['total'] * 4000 ;
        $total_cost =  $courseTeacherStudent->courseTeacher->total_cost;
        $left_payment = $total_cost - $total_payment;
            
        if($amount > $left_payment)
        {
        return $this->returnError(trans('strings.remaining_amount').$left_payment/4000 .'$');
        }
        // Insert transaction data into the database
        $payment = new payment();
        $payment->date = now();
        $payment->payment_id = $arr_body['id'];
        $payment->payment_method = '1';
        $payment->teacher_course_student_id =  $courseTeacherStudent->id;
        $payment->amount = $amount;
        $payment->save();
              
        DB::commit();

        event(new paymentTransaction($courseTeacherStudent));

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
         
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->returnError($th->getMessage());
        }        
    }

    public function payError(){
          return $this->returnError(trans('string.User_cancelled_the_payment'));
    }
}