<?php

namespace App\Http\Requests\course;

use App\Rules\arabicLanguage;
use App\Rules\englishLanguage;
use App\Trait\ResponseJson;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'name_ar' =>[ 'required' , 'string' , new arabicLanguage],
            'name_en' => [ 'required' , 'string' , new englishLanguage ],
            'description_ar' => [ 'required' , 'string' , new arabicLanguage ],
            'description_en' => [ 'required' , 'string' , new englishLanguage ],
            'workshop' => 'required|boolean',
        ];
    }
}
