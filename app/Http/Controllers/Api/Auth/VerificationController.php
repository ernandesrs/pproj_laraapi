<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
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
        $userToVerify = User::where('email', '=', $validated['email'])->firstOrFail();
        $userToken = $userToVerify
            ->userTokens()
            ->where('to', '=', 'email_verification')
            ->where('token', '=', \Str::fromBase64($validated['token']))->first();

        throw_if(!$userToken, new \App\Exceptions\Api\Auth\InvalidTokenException());

        $userToVerify->email_verified_at = now();
        if ($userToVerify->save()) {
            $userToken->delete();
        }

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
        $validator = \Validator::make($request->only(['email']), [
            'email' => ['required', 'email', 'exists:users,email']
        ]);

        throw_if($validator->fails(), new \App\Exceptions\Api\InvalidDataException());

        $validated = $validator->validated();
        $userToResend = User::where('email', '=', $validated['email'])
            ->whereNull('email_verified_at')
            ->first();

        throw_if(!$userToResend, new \App\Exceptions\Api\Auth\EmailHasAlreadyBeenVerifiedException());

        $userToken = $userToResend
            ->userTokens()
            ->where('to', '=', 'email_verification')
            ->first();

        $minMinutesToResend = 5;
        if ($userToken) {
            throw_if($userToken->created_at >= now()->subMinutes($minMinutesToResend), new \App\Exceptions\Api\Auth\VerificationEmailHasBeenSentException());

            $userToken->delete();
        }

        $userToResend = UserService::sendVerificationEmail($userToResend);

        return response()->json([
            'success' => true
        ]);
    }
}
