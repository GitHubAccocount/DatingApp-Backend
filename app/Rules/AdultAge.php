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
        // Parse the birthday value into a Carbon instance
        $birthday = Carbon::parse($value);
        // Calculate the age of the user
        $userAge = $birthday->diffInYears(now());

        // If the user's age is less than 15, validation fails
        if ($userAge < 15) {
            // Invoke the $fail callback with a validation failure message
            $fail("You must be at least 15 years old.");
        }
    }
}
