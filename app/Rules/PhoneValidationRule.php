<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneValidationRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        if (!preg_match('/^\d{9,13}$/', $value)) {
            $fail("The $attribute must be a valid phone number with at least 9 digits and maximum 13 digits.");
        }
    }
}
