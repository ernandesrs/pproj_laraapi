<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Login
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function login(Request $request): \Illuminate\Http\JsonResponse
    {
        $validatedCredentials = $request->validate([
            'email' => ['email', 'exists:users,email'],
            'password' => ['string'],
            'remember' => ['nullable', 'boolean']
        ]);

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
