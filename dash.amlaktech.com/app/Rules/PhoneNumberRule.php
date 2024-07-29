<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneNumberRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Remove any non-digit characters from the phone number
        $phoneNumber = preg_replace('/[^0-9]/', '', $value);
        $passes = false;

        // Regular expression patterns for each country
        $patterns = [
            'EG' => '/^(?:\+?2|002)?(010\d{8}|01[1-9]\d{8}|1\d{9})$/',
            'SA' => '/^(?:\+?966|00966)?(5\d{8}|05\d{8})$/',
        ];

        foreach ($patterns as $countryCode => $pattern) {
            if (preg_match($pattern, $phoneNumber, $matches)) {
                $numberWithoutCode = ltrim($matches[1], '0');

                if ($countryCode === 'EG') {
                    // Remove the leading "0" from Egyptian numbers
                    $numberWithoutCode = ltrim($numberWithoutCode, '0');
                }

                $passes = true;

                $this->countryCode = $countryCode;
                $this->numberWithoutCode = $numberWithoutCode;

            }
        }

        if (!$passes) {
            $fail('رقم الجوال رقم غير سعودي، برجاء التحقق.');
        }
    }
}
