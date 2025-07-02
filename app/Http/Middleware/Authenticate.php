<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->expectsJson()) {
            return null;
            //            return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        if ($request->is('admin/*')) {
            return route('auth.login.show', ['guard' => 'admin']);
        }
        if ($request->is('user/*')) {
            return route('auth.login.show', ['guard' => 'user']);
        }

        return route('auth.login.show', ['guard' => 'user']);

    }
}
