<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            // لو الطلب من api/.. أو متوقع json
            return response()->json(['message' => 'User not authenticated'], 401);
        }
        if ($request->is('admin/*')) {
            return redirect()->guest(route('auth.login.show', ['guard' => 'admin']));
        }else{
            return redirect()->guest(route('auth.login.show', ['guard' => 'user']));
        }

    }


    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
