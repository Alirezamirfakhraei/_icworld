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

    public function validateAddress($attribute, $value, $parameters): bool
    {
        $pattern = '/^[0-9()\-_@\s\.\/\x{200C}\x{060C}\x{06F0}-\x{06F9}\x{0660}-\x{0669}\x{0621}-\x{0628}\x{062A}-\x{063A}\x{0641}-\x{0642}\x{0644}-\x{0649}\x{064E}-\x{0651}\x{0654}\x{067E}\x{0686}\x{0698}\x{06A9}\x{06AF}\x{06BE}\x{06CC}\x{06D5}\x{0643}\x{064A}\x{0629}]+$/u';
        return preg_match($pattern, $value);
    }

    public function validateIdentifier($attribute, $value, $parameters): bool
    {
        $pattern = '/^(sp)[a-zA-Z0-9]{5,10}$/';
        return preg_match($pattern, $value);
    }

    public function validateCode($attribute, $value, $parameters): bool
    {
        $pattern = '/^[0-9]{3,7}$/';
        return preg_match($pattern, $value);
    }


    public function validateCarID($attribute, $value, $parameters): bool
    {
        $pattern = '/^[IRir0-9]{9}$/';
        return preg_match($pattern, $value);
    }

    public function validatePlate($attribute, $value, $parameters): bool
    {
        $pattern = '/^[0-9]{9}$/';
        return preg_match($pattern, $value);
    }

    public function validateCategory($attribute, $value, $parameters): bool
    {
        $pattern = '/^[0-9]{0,5}$/';
        return preg_match($pattern, $value);
    }

    public function validateYear($attribute, $value, $parameters): bool
    {
        $pattern = '/^[0-9]{4}$/';
        return preg_match($pattern, $value);
    }

    public function validateKmCurrent($attribute, $value, $parameters): bool
    {
        $pattern = '/^[0-9]{0,9}$/';
        return preg_match($pattern, $value);
    }

    public function validateThirdInsurance($attribute, $value, $parameters): bool
    {
        $pattern = '/^[0-9\-]{0,10}$/';
        return preg_match($pattern, $value);
    }

    public function validateAccessToken($attribute, $value, $parameters): bool
    {
        $pattern = '/^[a-zA-Z0-9](' . Car::QR . ')[a-zA-Z0-9]$/u';
        return preg_match($pattern, $value);
    }

    public function validateChassisNumber($attribute, $value, $parameters): bool
    {
        $pattern = '/^[a-zA-Z0-9]{17}$/u';
        return preg_match($pattern, $value);
    }

    public function validateEngineNumber($attribute, $value, $parameters): bool
    {
        $pattern = '/^[a-zA-Z0-9]{17}$/u';
        return preg_match($pattern, $value);
    }

    public function validateRepairID($attribute, $value, $parameters): bool
    {
        $pattern = '/^[AS0-9]{10}$/u';
        return preg_match($pattern, $value);
    }

    public function validateReference($attribute, $value, $parameters): bool
    {
        $pattern = '/^[0-9- ]{0,10}[0-9]{0,5}$/';
        return preg_match($pattern, $value);
    }


    public function validateEnglishAndPersianAlphaNumber($attribute, $value, $parameters): bool
    {
        $pattern = "/^[\.()\-a-zA-Z0-9\x{200C}\x{06F0}-\x{06F9}\x{0660}-\x{0669}\x{0621}-\x{0628}\x{062A}-\x{063A}\x{0641}-\x{0642}\x{0644}-\x{0649}\x{064E}-\x{0651}\x{0654}\x{067E}\x{0686}\x{0698}\x{06A9}\x{06AF}\x{06BE}\x{06CC}\x{06D5}\x{0643}\x{064A}\x{0629}\s]+$/u";
        if (count($parameters) == 1) {
            return preg_match($pattern, $value) || preg_match($parameters[1], $value);
        } else {
            return preg_match($pattern, $value);
        }
    }


    public function validateModelCars($attribute, $value, $parameters): bool
    {
        $pattern = "/^[\.()\-a-zA-Z0-9\x{200C}\x{06F0}-\x{06F9}\x{0660}-\x{0669}\x{0621}-\x{0628}\x{062A}-\x{063A}\x{0641}-\x{0642}\x{0644}-\x{0649}\x{064E}-\x{0651}\x{0654}\x{067E}\x{0686}\x{0698}\x{06A9}\x{06AF}\x{06BE}\x{06CC}\x{06D5}\x{0643}\x{064A}\x{0629}\s]+$/u";
        if (count($parameters) == 1) {
            return preg_match($pattern, $value) || preg_match($parameters[1], $value);
        } else {
            return preg_match($pattern, $value);
        }
    }

    public function validateNationalCode($attribute, $value, $parameters): bool
    {
        // if (!preg_match('/^\d{8,10}$/', $value) || preg_match('/^0{10}|1{10}|2{10}|3{10}|4{10}|5{10}|6{10}|7{10}|8{10}|9{10}$/', $value)) {
        //     return false;
        // }
        // $sub = 0;
        // $value = str_pad($value, 10, '0', STR_PAD_LEFT);
        // for ($i = 0; $i <= 8; $i++) {
        //     $sub = $sub + ( $value[$i] * ( 10 - $i ) );
        // }
        // if (( $sub % 11 ) < 2) {
        //     $control = ( $sub % 11 );
        // } else {
        //     $control = 11 - ( $sub % 11 );
        // }
        // return (int) $value[9] === $control;

        $pattern = '/^[0-9]{10}$/';
        return preg_match($pattern, $value);
    }

    public function validatePersianNumber($attribute, $value, $parameters): bool
    {
        $pattern = "/^[\x{06F0}-\x{06F9}\x{0660}-\x{0669}]+$/u";
        if (count($parameters) == 1) {
            return preg_match($pattern, $value) || preg_match($parameters[1], $value);
        } else {
            return preg_match($pattern, $value);
        }
    }

    public function validatePersianAlpha($attribute, $value, $parameters): bool
    {
        $pattern = "/^[\x{200C}\x{0621}-\x{0628}\x{062A}-\x{063A}\x{0641}-\x{0642}\x{0644}-\x{0649}\x{064E}-\x{0651}\x{0654}\x{067E}\x{0686}\x{0698}\x{06A9}\x{06AF}\x{06BE}\x{06CC}\x{06D5}\x{0643}\x{064A}\x{0629}\s]+$/u";
        if (count($parameters) == 1) {
            return preg_match($pattern, $value) || preg_match($parameters[1], $value);
        } else {
            return preg_match($pattern, $value);
        }
    }

    public function validatePersianAlphaNumber($attribute, $value, $parameters): bool
    {
        $pattern = "/^[\x{200C}\x{06F0}-\x{06F9}\x{0660}-\x{0669}\x{0621}-\x{0628}\x{062A}-\x{063A}\x{0641}-\x{0642}\x{0644}-\x{0649}\x{064E}-\x{0651}\x{0654}\x{067E}\x{0686}\x{0698}\x{06A9}\x{06AF}\x{06BE}\x{06CC}\x{06D5}\x{0643}\x{064A}\x{0629}\s]+$/u";
        if (count($parameters) == 1) {
            return preg_match($pattern, $value) || preg_match($parameters[1], $value);
        } else {
            return preg_match($pattern, $value);
        }
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

    public function validateNumber($attribute, $value, $parameters): bool
    {
        $pattern = "/^[0-9\x{06F0}-\x{06F9}\x{0660}-\x{0669}]+$/u";
        if (count($parameters) == 1) {
            return preg_match($pattern, $value) || preg_match($parameters[1], $value);
        } else {
            return preg_match($pattern, $value);
        }
    }

    public function validateAlpha($attribute, $value, $parameters): bool
    {
        $pattern = "/^[a-zA-Z\x{200C}\x{0621}-\x{0628}\x{062A}-\x{063A}\x{0641}-\x{0642}\x{0644}-\x{0649}\x{064E}-\x{0651}\x{0654}\x{067E}\x{0686}\x{0698}\x{06A9}\x{06AF}\x{06BE}\x{06CC}\x{06D5}\x{0643}\x{064A}\x{0629}\s]+$/u";
        if (count($parameters) == 1) {
            return preg_match($pattern, $value) || preg_match($parameters[1], $value);
        } else {
            return preg_match($pattern, $value);
        }
    }

    public function validateAlphaNumber($attribute, $value, $parameters): bool
    {
        $pattern = "/^[0-9a-zA-Z\x{200C}\x{06F0}-\x{06F9}\x{0660}-\x{0669}\x{0621}-\x{0628}\x{062A}-\x{063A}\x{0641}-\x{0642}\x{0644}-\x{0649}\x{064E}-\x{0651}\x{0654}\x{067E}\x{0686}\x{0698}\x{06A9}\x{06AF}\x{06BE}\x{06CC}\x{06D5}\x{0643}\x{064A}\x{0629}\s]+$/u";
        if (count($parameters) == 1) {
            return preg_match($pattern, $value) || preg_match($parameters[1], $value);
        } else {
            return preg_match($pattern, $value);
        }
    }

    public function validateText($attribute, $value, $parameters): bool
    {
        $pattern = "/^[0-9a-zA-Z()\-_@\s\.]+$";
        if (count($parameters) == 1) {
            return preg_match($pattern, $value) || preg_match($parameters[1], $value);
        } else {
            return preg_match($pattern, $value);
        }
    }

    public function validatePersianText($attribute, $value, $parameters): bool
    {
        $pattern = "/^[0-9()\-_@\s\.\x{200C}\x{060C}\x{06F0}-\x{06F9}\x{0660}-\x{0669}\x{0621}-\x{0628}\x{062A}-\x{063A}\x{0641}-\x{0642}\x{0644}-\x{0649}\x{064E}-\x{0651}\x{0654}\x{067E}\x{0686}\x{0698}\x{06A9}\x{06AF}\x{06BE}\x{06CC}\x{06D5}\x{0643}\x{064A}\x{0629}]+$/u";
        if (count($parameters) == 1) {
            return preg_match($pattern, $value) || preg_match($parameters[1], $value);
        } else {
            return preg_match($pattern, $value);
        }
    }

    public function validateIllogical($attribute, $value, $parameters): bool
    {
        $pattern = '/^[^!#$%^&*\-+=|?<>{}\[\],\"\'~`;÷]+$/';
        return preg_match($pattern, $value);
    }

     public function validatePieceName($attribute, $value, $parameters): bool
    {
        $pattern = '/^[a-zA-z\-]+$/';
        return preg_match($pattern, $value);
    }

    public function validatePrice($attribute, $value, $parameters): bool
    {
        $pattern = '/^[0-9]{1,10}$/';
        return preg_match($pattern, $value);
    }

    public function validateGeneralText($attribute, $value, $parameters): bool
    {
        $pattern = '/^[!:?.a-zA-Z0-9()\-_@\s\.\\x{060C}\x{061B}\x{061F}\x{0640}\x{066B}\x{200C}\x{060C}\x{06F0}-\x{06F9}\x{0660}-\x{0669}\x{0621}-\x{0628}\x{062A}-\x{063A}\x{0641}-\x{0642}\x{0644}-\x{0649}\x{064E}-\x{0651}\x{0654}\x{067E}\x{0686}\x{0698}\x{06A9}\x{06AF}\x{06BE}\x{06CC}\x{06D5}\x{0643}\x{064A}\x{0629}]+$/u';
        return preg_match($pattern, $value);
    }
}
