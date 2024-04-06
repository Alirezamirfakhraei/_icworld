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
        'rex_point' => 'PointLocation',
        'rex_username' => 'UserName',
        'rex_password' => 'Password',
        'rex_english_n' => 'EnglishNumber',
        'rex_english_a' => 'EnglishAlpha',
        'rex_english_na' => 'EnglishAlphaNumber',
        'rex_number' => 'Number',
        'rex_alpha' => 'Alpha',
        'rex_numberAlpha' => 'AlphaNumber',
        'rex_text' => 'Text',
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
