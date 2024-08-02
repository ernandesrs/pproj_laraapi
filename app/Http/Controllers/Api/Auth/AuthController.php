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

        dump($validatedCredentials);

        return response()->json([
            'success' => true,
            'auth' => [
                'token' => '',
                'expiration' => ''
            ]
        ]);
    }
}
