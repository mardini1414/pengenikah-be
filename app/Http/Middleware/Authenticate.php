<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiResponse;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Exceptions\HttpResponseException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        throw new HttpResponseException(ApiResponse::withMessage('Unauthenticated.', 401));
        if (!$request->expectsJson()) {
            return route('login');
        }
    }
}
