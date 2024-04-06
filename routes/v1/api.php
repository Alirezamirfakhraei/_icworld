<?php

use Illuminate\Support\Facades\Route;
use Modules\ContactUs\App\Http\Controllers\ContactUsController;

Route::middleware(['throttle:30,1'])->prefix('v1')->group(function () {
    // ----------> Users
    Route::controller(ContactUsController::class)->group(function () {
        Route::post('message/set', 'setMessage');
    });

});


