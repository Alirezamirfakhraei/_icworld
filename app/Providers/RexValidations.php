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
        return preg_match($pattern, $value);
    }

    public function validateTrackerID($attribute, $value, $parameters): bool
    {
        $pattern = "/^(STR)[0-9]{7,9}$/u";
        return preg_match($pattern, $value);
    }

    public function validatePassword($attribute, $value, $parameters): bool
    {
        $pattern = "/^[a-zA-Z0-9_@]+$/u";
        return preg_match($pattern, $value);
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
        $pattern = "/^[0-9]+$/";
        return preg_match($pattern, $value);
    }

    public function validateEnglishAlpha($attribute, $value, $parameters): bool
    {
        $pattern = "/^[a-zA-Z\s]+$/";
        return preg_match($pattern, $value);
    }

    public function validateEnglishAlphaNumber($attribute, $value, $parameters): bool
    {
        $pattern = "/^[0-9a-zA-Z\s]+$/";
        return preg_match($pattern, $value);
    }

    public function validateText($attribute, $value, $parameters): bool
    {
        $pattern = "/^[0-9a-zA-Z()\-_@\s\.]+$/";
        return preg_match($pattern, $value);
    }

    public function validateVersion($attribute, $value, $parameters): bool
    {
        $pattern = "/^[0-9]*(\.)?[0-9]+(\.)?[0-9]*$/";
        return preg_match($pattern, $value);
    }

    public function validateIdProducts($attribute, $value, $parameters): bool
    {
        $pattern = '/^[a-zA-Z0-9_-]+$/';
        return preg_match($pattern, $value);
    }
}
