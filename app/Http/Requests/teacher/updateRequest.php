<?php

namespace App\Http\Requests\teacher;

use App\Trait\ResponseJson;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class updateRequest extends FormRequest
{

    use ResponseJson;
    
    protected function failedValidation(Validator $validator)
    {
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
            'email' =>  [
                'required',
                'email',
                Rule::unique('students', 'email')->ignore($this->id),
                Rule::unique('teachers', 'email')->ignore($this->id),
            ],
            'first_name_ar' => 'required|regex:/^[\p{Arabic}]+$/u',
            'first_name_en' => 'required|regex:/^[a-zA-Z]+$/',
            'last_name_ar' => 'required|regex:/^[\p{Arabic}]+$/u',
            'last_name_en' => 'required|regex:/^[a-zA-Z]+$/',
            'phoneNumber' => 'required|regex:/^\+\d{5,14}$/',
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

    protected function prepareForValidation()
    {
        
        $this->merge([
            'id' => $this->route('teacher'),
        ]);
    }
}
