<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserToken;
use App\Services\UserService;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    /**
     * Send a link to reset password
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    function sendLink(Request $request)
    {
        $validator = \Validator::make($request->only(['email']), [
            'email' => ['required', 'email', 'exists:users,email']
        ]);

        throw_if($validator->fails(), new \App\Exceptions\Api\InvalidDataException());

        $userToSendLink = User::where('email', '=', $validator->validated()['email'])->firstOrFail();

        $userToken = $userToSendLink
            ->userTokens()
            ->where('to', '=', 'password_reset')
            ->first();

        $minMinutesToResend = 5;
        if ($userToken) {
            throw_if(
                $userToken->created_at >= now()->subMinutes($minMinutesToResend),
                new \App\Exceptions\Api\Auth\PasswordResetEmailHasBeenSentException()
            );

            $userToken->delete();
        }

        $userToSendLink = UserService::sendPasswordResetLink($userToSendLink);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Reset password
     * @param \App\Http\Requests\PasswordResetRequest $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    function reset(\App\Http\Requests\PasswordResetRequest $request)
    {
        $validated = $request->validated();

        $userToken = UserToken::where('to', 'password_reset')
            ->where('token', \Str::fromBase64($validated['token']))
            ->first();

        throw_if(!$userToken, new \App\Exceptions\Api\Auth\InvalidTokenException());

        $user = $userToken->user()->firstOrFail();
        $user->password = $validated['password'];
        $user->save();

        $userToken->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
