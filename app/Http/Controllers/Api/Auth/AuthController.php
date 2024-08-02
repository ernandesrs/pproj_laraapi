<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Login
     * @param \App\Http\Requests\AuthFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    function login(\App\Http\Requests\AuthFormRequest $request): \Illuminate\Http\JsonResponse
    {
        $validatedCredentials = $request->validated();

        throw_if(!\Auth::attempt(
            ['email' => $validatedCredentials['email'], 'password' => $validatedCredentials['password']],
            $validatedCredentials['remember']
        ), \App\Exceptions\Api\Auth\LoginFailException::class);

        $token = $request->user()->createToken('api_token_auth')->plainTextToken;

        return response()->json([
            'success' => true,
            'auth' => [
                'token' => $token,
                'fullToken' => "Bearer {$token}",
                'expirationInMinutes' => config('sanctum.expiration')
            ]
        ]);
    }

    /**
     * Logout
     * @return \Illuminate\Http\JsonResponse
     */
    function logout(): \Illuminate\Http\JsonResponse
    {
        \Auth::user()->tokens()->delete();
        return response()->json([
            'success' => true
        ]);
    }
}
