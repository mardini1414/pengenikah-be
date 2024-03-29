<?php

namespace App\Services\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthService
{
    public function generateToken(LoginRequest $request)
    {
        $auth = auth()->attempt(['username' => $request->username, 'password' => $request->password]);
        if ($auth) {
            $token = auth()->user()->createToken('auth');
            return $token->plainTextToken;
        } else {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    'message' => 'username or password wrong'
                ]
            ], 401));
        }
    }
}
