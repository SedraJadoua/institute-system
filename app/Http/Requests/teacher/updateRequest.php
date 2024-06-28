<?php

namespace App\Http\Requests\teacher;

use App\Trait\ResponseJson;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class updateRequest extends FormRequest
{
    use ResponseJson;
   
    protected function failedValidation(Validator $validator)
    {
      return $this->validationErrorResponse($validator);
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
                Rule::unique('teachers', 'email')->ignore($this->id),
                Rule::unique('students', 'email'),
            ],
            'first_name_ar' => 'required|regex:/^[\p{Arabic}]+$/u',
            'first_name_en' => 'required|regex:/^[a-zA-Z]+$/',
            'last_name_ar' => 'required|regex:/^[\p{Arabic}]+$/u',
            'last_name_en' => 'required|regex:/^[a-zA-Z]+$/',
            'phoneNumber' => 'required|regex:/^\+\d{5,14}$/',
            'speciality_id' => 'required|exists:specialties,id',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string'
        ];
    }

    protected function prepareForValidation()
    {
       $this->merge([
            'id' => $this->route('teacher'),
        ]);
    }
}
