<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class RexServiceProvider extends ServiceProvider
{
    private array $validatorsList = [
        'rex' => 'Regex',
        'rex_phone' => 'PhoneNumber',
        'rex_email' => 'Email',
        'rex_tel' => 'TelNumber',
        'rex_point' => 'PointLocation',
        'rex_username' => 'UserName',
        'rex_password' => 'Password',
        'rex_nationalCode' => 'NationalCode',
        'rex_tracker' => 'TrackerID',
        'rex_address' => 'Address',
        'rex_identifier' => 'Identifier',
        'rex_code' => 'Code',
        'rex_repairID' => 'RepairID',
        'rex_carID' => 'CarID',
        'rex_plate' => 'Plate',
        'rex_category' => 'Category',
        'rex_year' => 'year',
        'rex_kmCurrent' => 'KmCurrent',
        'rex_third' => 'ThirdInsurance',
        'rex_accessToken' => 'AccessToken',
        'rex_chassisNumber' => 'ChassisNumber',
        'rex_EngineNumber' => 'EngineNumber',
        'rex_reference' => 'Reference',
        'rex_persian_n' => 'PersianNumber',
        'rex_persian_a' => 'PersianAlpha',
        'rex_persian_na' => 'PersianAlphaNumber',
        'rex_english_n' => 'EnglishNumber',
        'rex_english_a' => 'EnglishAlpha',
        'rex_english_na' => 'EnglishAlphaNumber',
        'rex_number' => 'Number',
        'rex_alpha' => 'Alpha',
        'rex_numberAlpha' => 'AlphaNumber',
        'rex_text' => 'Text',
        'rex_persian_text' => 'PersianText',
        'rex_persian_english_na' => 'EnglishAndPersianAlphaNumber',
        'rex_model' => 'ModelCars',
        'rex_illogical' => 'Illogical',
        'rex_pieceName' => 'PieceName',
        'rex_generalText' => 'GeneralText',
    ];
    public function boot(): void
    {
        foreach ($this->validatorsList as $mode => $method) {
            Validator::extend(
                $mode,
                rexValidations::class . "@validate{$method}",
                ':attribute=:input'
            );
        }
    }

    public function register(): void
    {

    }
}
