<?php

namespace App\Rules;

use Illuminate\Support\Str;
use App\Models\specialty;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class uniqueJsonContent implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
      $specialities = specialty::all();
      foreach ($specialities as $speciality){
        $specialityName = json_decode($speciality->getRawOriginal('specialty_name'), TRUE);
         if($specialityName[Str::afterLast($attribute, '_')] == $value){
            $fail(__('validation.unique_specialty'));
         }
      }
    }
}
