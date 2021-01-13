<?php

namespace App\Exceptions;

use Dotenv\Exception\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Mockery\Exception;
use Throwable;
use Laravel\Passport\Exceptions\MissingScopeException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if($e instanceof MissingScopeException) {
            return response()->json([
               "message" => "You are not authorized to do this"
            ]);
        }

        if($e instanceof ValidationException) {
            return response([
               'errors' => $e->errors()
            ], 400);
        }

        return response(['error' => $e->errors()], $e->getCode() ?: 400);

//        return parent::render($request, $e);
    }
}
