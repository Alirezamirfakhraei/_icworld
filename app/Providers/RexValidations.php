<?php

namespace App\Providers;
class RexValidations
{
    public function validateRegex($attribute, $value, $parameters): bool
    {
        if ($parameters != null) {
            return preg_match($parameters, $value);
        } else {
            return false;
        }
    }

    public function validateUserName($attribute, $value, $parameters): bool
    {
        $pattern = "/^[a-zA-Z0-9_]+$/u";
        if (count($parameters) == 1) {
            return preg_match($pattern, $value) || preg_match($parameters[1], $value);
        } else {
            return preg_match($pattern, $value);
        }
    }

    public function validateTrackerID($attribute, $value, $parameters): bool
    {
        $pattern = "/^(STR)[0-9]{7,9}$/u";
        if (count($parameters) == 1) {
            return preg_match($pattern, $value) || preg_match($parameters[1], $value);
        } else {
            return preg_match($pattern, $value);
        }
    }

    public function validatePassword($attribute, $value, $parameters): bool
    {
        $pattern = "/^[a-zA-Z0-9_@]+$/u";
        if (count($parameters) == 1) {
            return preg_match($pattern, $value) || preg_match($parameters[1], $value);
        } else {
            return preg_match($pattern, $value);
        }
    }

    public function validateEmail($attribute, $value, $parameters): bool
    {
        $pattern = '/^.+@gmail.com$/';
        return preg_match($pattern, $value);
    }

    public function validatePhoneNumber($attribute, $value, $parameters): bool
    {
        $pattern = '/^((98)|(\+98)|(0098)|0)*(9)[0-9]{9}$/';
        return preg_match($pattern, $value);
    }

    public function validateTelNumber($attribute, $value, $parameters): bool
    {
        $pattern = '/^(0[1-9]{2})[2-9][0-9]{7}$/';
        return preg_match($pattern, $value);
    }

    public function validatePointLocation($attribute, $value, $parameters): bool
    {
        $pattern = '/^[0-9]+(\.)[0-9]+$/';
        return preg_match($pattern, $value);
    }



    public function validateEnglishNumber($attribute, $value, $parameters): bool
    {
        $pattern = "/^[0-9]+$/u";
        if (count($parameters) == 1) {
            return preg_match($pattern, $value) || preg_match($parameters[1], $value);
        } else {
            return preg_match($pattern, $value);
        }
    }

    public function validateEnglishAlpha($attribute, $value, $parameters): bool
    {
        $pattern = "/^[a-zA-Z\s]+$/u";
        if (count($parameters) == 1) {
            return preg_match($pattern, $value) || preg_match($parameters[1], $value);
        } else {
            return preg_match($pattern, $value);
        }
    }

    public function validateEnglishAlphaNumber($attribute, $value, $parameters): bool
    {
        $pattern = "/^[0-9a-zA-Z\s]+$/u";
        if (count($parameters) == 1) {
            return preg_match($pattern, $value) || preg_match($parameters[1], $value);
        } else {
            return preg_match($pattern, $value);
        }
    }

    public function validateText($attribute, $value, $parameters): bool
    {
        $pattern = "/^[0-9a-zA-Z()\-_@\s\.]+$/u";
        if (count($parameters) == 1) {
            return preg_match($pattern, $value) || preg_match($parameters[1], $value);
        } else {
            return preg_match($pattern, $value);
        }
    }

}
