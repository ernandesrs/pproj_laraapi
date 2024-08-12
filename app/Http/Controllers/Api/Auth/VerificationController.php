<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /**
     * Verify email
     * @param \App\Http\Requests\AuthFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    function verify(Request $request)
    {
        $validator = \Validator::make($request->only(['email', 'token']), [
            'email' => ['required', 'email', 'exists:users,email'],
            'token' => ['required', 'string']
        ]);

        throw_if($validator->fails(), new \App\Exceptions\Api\InvalidDataException());

        $validated = $validator->validated();
        $userToVerify = User::where('email', '=', $validated['email'])
            ->where('verification_token', '=', \Str::fromBase64($validated['token']))
            ->first();

        throw_if(!$userToVerify, new \App\Exceptions\Api\Auth\InvalidVerificationToken());

        $userToVerify->email_verified_at = now();
        $userToVerify->verification_token = null;
        $userToVerify->save();

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Resend verification email
     * @param \App\Http\Requests\AuthFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    function resend(Request $request)
    {
        return response()->json([
            'success' => true
        ]);
    }
}
