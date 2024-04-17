<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class arabicLanguage implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
          if(!preg_match('/(?=.*\p{Arabic})[A-Za-z\p{Arabic},\.\s\(\)-]+$/u' , $value))
          $fail(__('validation.language'));
    }
}
