<?php

namespace App\Http\Requests\auth;

use App\Trait\ResponseJson;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class teacherRegister extends FormRequest
{
    use ResponseJson;

    protected function failedValidation(Validator $validator){
       $res = $this->sendListError($validator->errors());
       throw new HttpResponseException($res);
    }  
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:students,email|unique:teachers,email',
            'first_name_ar' => 'required|regex:/^[\p{Arabic}]+$/u',
            'first_name_en' => 'required|regex:/^[a-zA-Z]+$/',
            'last_name_ar' => 'required|regex:/^[\p{Arabic}]+$/u',
            'last_name_en' => 'required|regex:/^[a-zA-Z]+$/',
            'phoneNumber' => 'required|regex:/^\+\d{1,14}$/',
            'speciality_id' => 'required|exists:specialties,id',
        ];
    }

    public function messages()
    {
        return [
              'phoneNumber.regex' => __('validation.regex.phoneNumber'),
              'first_name_ar.regex' => __('validation.regex.first_name_ar'),
              'last_name_ar.regex' => __('validation.regex.last_name_ar'),
              'first_name_en.regex' => __('validation.regex.first_name_en'),
              'last_name_en.regex' => __('validation.regex.last_name_en'),
        ];
    }
}
