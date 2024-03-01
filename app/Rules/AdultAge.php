<?php

namespace App\Rules;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AdultAge implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $birthday = Carbon::parse($value);
        $userAge = $birthday->diffInYears(now());

        if ($userAge < 15) {
            $fail("You must be at least 15 years old.");
        }
    }
}
