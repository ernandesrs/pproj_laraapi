<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
            ->tokens()
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
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    function reset(Request $request)
    {
        return response()->json([
            'success' => true
        ]);
    }
}
