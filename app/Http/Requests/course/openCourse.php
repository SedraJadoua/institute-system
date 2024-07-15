<?php

namespace App\Http\Requests\course;

use App\Trait\ResponseJson;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class openCourse extends FormRequest
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
            'level' => 'required|integer|between:0,3', 
            'total_days' => 'required|integer', 
            'total_cost' => 'required|numeric|gte:0.0|lte:100000.0',
            'classroom_id' => 'required|exists:classrooms,id',
            'date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'start_time' => ['required ','date_format:H:i'],
            'end_time' => 'required_with:start_time|date_format:H:i|after:start_time',
        ];
    }

    // public function withValidator($validator) {
    //     $validator->after(function($validator){
    //         $workDay = $this->input('work_day');
    //         $dayWorkshopAr = $this->input('day_workshop_ar');
    //         $dayWorkshopEn = $this->input('day_workshop_en');
    //         if (isset($workDay) && (isset($dayWorkshopAr) || isset($dayWorkshopEn))) {
    //             $validator->errors()->add('_', trans('validation.only_one'));
    //         }
    //     });
    // }
    
}
