<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Validation\ValidationException;
use Logs;
use Responses;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if (env("APP_DEBUG")) {
            return parent::render($request, $e);
        } else {
            if ($e instanceof ThrottleRequestsException) {
                Logs::error($request,
                    'Too Many Attempts (' . $e->getMessage() . ') for This Route is Not Allowed!',
                    __CLASS__ . ' -> line:' . __LINE__
                );
                return response()->json(['Mode' => 'badRequest', 'message' => 'لطفا بعد از چند لحظه دوباره مجددا امتحان کنید'], 400);
            }
            if ($e instanceof ValidationException) {
                Logs::error($request,
                    'Validation Regex (' . $e->getMessage() . ') is Not Allowed!',
                    __CLASS__ . ' -> line:' . __LINE__
                );
                return response()->json([
                    'Mode' => 'badRequest'
                ], 400);
            } else if ($e instanceof MethodNotAllowedHttpException) {
                Logs::error($request,
                    'Method (' . $request->method() . ') Not Allowed Request!',
                    __CLASS__ . ' -> line:' . __LINE__
                );
                return response()->json([
                    'Mode' => 'badRequest'
                ], 400);
            } else {
                Logs::error($request,
                    'Exception [Error] ' . $e->getMessage(),
                    __CLASS__ . ' -> line:' . __LINE__
                );
                return response()->json([
                    'Mode' => 'badRequest'
                ], 400);
            }
        }
    }
}
