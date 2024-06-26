<?php

namespace App\Http\Requests\course;

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
            'name_ar' =>[ 'required' , 'string' , new arabicLanguage ],
            'name_en' => [ 'required' , 'string' , new englishLanguage ],
            'description_ar' => [ 'nullable' ,'required_with:description_en' ,'string' , new arabicLanguage ],
            'description_en' => [ 'nullable' , 'required_with:description_ar' ,'string' , new englishLanguage ],
            'workshop' => 'required|boolean',
            'specialty_id' => 'required|exists:specialties,id',
            'photo.*' => 'nullable|image|max:2048', 
        ];

    }

     public function messages()
     {
        return [
           'photo.max' => __('validation.max.file')
        ];
     }
}
