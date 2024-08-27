<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MediaUrlValidation implements ValidationRule
{

    const VALIDATION_ERR = "";
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail):void
    {
        if(!preg_match('/\.(mp4|mp3)$/', $value))
            $fail(self::VALIDATION_ERR);
    }
}
