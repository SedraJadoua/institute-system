<?php

namespace App\Http\Requests\session;

use App\Rules\arabicLanguage;
use App\Rules\englishLanguage;
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
            'title_ar' =>[ 'required' , new arabicLanguage ],
            'title_en' => [ 'required' , new englishLanguage ],
            'date' => 'required|date_format:H:i',
            'course_teacher_id' => 'required|exists:course_teacher,id',
        ];
    }
}
 