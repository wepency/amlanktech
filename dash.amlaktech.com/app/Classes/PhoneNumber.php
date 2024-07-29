<?php

namespace App\Classes;

class PhoneNumber
{
    public static function clean($phoneNumber)
    {
        return preg_replace('/[^0-9]/', '', $phoneNumber);
    }

    public static function validateEG($phoneNumber)
    {
        $pattern = '/^(?:\+?2|002)?(010\d{8}|01[1-9]\d{8}|1\d{9})$/';

        if (preg_match($pattern, $phoneNumber, $matches)) {
            $numberWithoutCode = ltrim($matches[1], '0');
            $numberWithoutCode = ltrim($numberWithoutCode, '0');

            return [
                'key' => 'EG',
                'number' => $numberWithoutCode,
            ];
        }

        return false;
    }

    public static function validateSA($phoneNumber)
    {
        $pattern = '/^(?:\+?966|00966)?(5\d{8}|05\d{8})$/';

        if (preg_match($pattern, $phoneNumber, $matches)) {
            $numberWithoutCode = ltrim($matches[1], '0');

            return [
                'key' => 'SA',
                'number' => $numberWithoutCode,
            ];
        }

        return false;
    }

    public static function validateKW($phoneNumber)
    {
//        $pattern = '/^(?:\+?965|00965)?\d{7,8}$/';
        $pattern = '/^(?:\+?965|00965)?(\d{3})(\d{7})$/';

        if (preg_match($pattern, $phoneNumber, $matches)) {
            $numberWithoutCode = ltrim($matches[2], '0');

            return [
                'key' => 'KW',
                'number' => $numberWithoutCode,
            ];
        }

        return false;
    }

    public static function validateAE($phoneNumber)
    {
        $pattern = '/^(?:\+?971|00971)?(5\d{8}|05\d{8})$/';

        return self::validateCountry($phoneNumber, $pattern, 'AE');
    }

    public static function validateQA($phoneNumber)
    {
        $pattern = '/^(?:\+?974|00974)?(5\d{7}|6\d{7})$/';

        return self::validateCountry($phoneNumber, $pattern, 'QA');
    }

    public static function validateBH($phoneNumber)
    {
        $pattern = '/^(?:\+?973|00973)?(3\d{7}|6\d{7})$/';

        return self::validateCountry($phoneNumber, $pattern, 'BH');
    }

    public static function validateOM($phoneNumber)
    {
        $pattern = '/^(?:\+?968|00968)?(9\d{7})$/';

        return self::validateCountry($phoneNumber, $pattern, 'OM');
    }

    public static function validateLB($phoneNumber)
    {
        $pattern = '/^(?:\+?961|00961)?(3\d{7}|7\d{7})$/';

        return self::validateCountry($phoneNumber, $pattern, 'LB');
    }

    private static function validateCountry($phoneNumber, $pattern, $countryCode)
    {
        if (preg_match($pattern, $phoneNumber, $matches)) {
            $numberWithoutCode = ltrim($matches[1], '0');

            return [
                'key' => $countryCode,
                'number' => $numberWithoutCode,
            ];
        }

        return false;
    }

    public static function validatePhoneNumber($phoneNumber)
    {
        $phoneNumber = self::clean($phoneNumber);

        $validators = [
            'EG' => 'validateEG',
            'SA' => 'validateSA',
            'KW' => 'validateKW',
//            'OM' => 'validateOM',
//            'BH' => 'validateBH',
//            'QA' => 'validateQA',
//            'AE' => 'validateAE',
//            'LB' => 'validateLB'
        ];

        foreach ($validators as $countryCode => $validator) {
            $result = self::$validator($phoneNumber);

            if ($result !== false) {
                return $result;
            }
        }

        return false;
    }
}
