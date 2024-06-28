<?php


namespace App\Trait;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait  ResponseJson{
   
    protected function validationErrorResponse(Validator $validator)
    {
      $res = $this->sendListError($validator->errors());
      throw new HttpResponseException($res);   
    }



    public function sendResponse($result, $message = 'ok')
    {
        $respon = [
            'success' => true, 
            'data' => $result,
            'message' => $message
        ];
        return response()->json($respon, 200); 
    }

    public function sendListError( $errorMessage , $code = 404,)
    {
        $respon = [
            'success' => false, 
            'data' => null,
            'message' => $errorMessage->first(),
         ];

        return response()->json($respon, $code); //404=>error
    }

    public function returnError( $msg)
    {
        return response()->json([
            'success' => false,
            'data' => null,
            'message' => $msg
        ]);
    }

    public function returnSuccessMessage($msg = "", $result = null)
    {
        return [
            'success' => true,
            'data' => $result,
            'message' => $msg
        ];
    }
}