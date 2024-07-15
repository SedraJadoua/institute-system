<?php

namespace App\Http\Requests\course;

use App\Trait\ResponseJson;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class availableHours extends FormRequest
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
            'work_day' => 'nullable|string|required_without_all:day_workshop_ar,day_workshop_en',
            'course_id' => 'required|exists:courses,id', 
            'total_days' => 'required|integer', 
            'classroom_id' => 'required|exists:classrooms,id',
            'date' => 'required|date_format:Y-m-d|after_or_equal:today',
        ];
    }
}
