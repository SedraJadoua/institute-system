<?php

namespace App\Http\Requests\daysSystem;

use App\Trait\ResponseJson;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class storeRequest extends FormRequest
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
            'work_day' => 'required_without:day_workshop_ar,day_workshop_en|string',
            'day_workshop_ar' => 'required_without:work_day|string',
            'day_workshop_en' => 'required_without:work_day|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required_with:start_time|date_format:H:i|after:start_time',
            'teacher_course_id' => 'required|exists:course_teacher,id',
            'classroom_id' => 'required|exists:classrooms,id'
        ];
    }
}
