<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class MeController extends Controller
{
    /**
     * Me
     * @return \Illuminate\Http\JsonResponse
     */
    function me(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true,
            'me' => \Auth::user()
        ]);
    }

    /**
     * Me update
     * @param \App\Http\Requests\MeUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    function update(\App\Http\Requests\MeUpdateRequest $request): \Illuminate\Http\JsonResponse
    {
        $updatedMe = UserService::update(\Auth::user(), $request->validated());

        return response()->json([
            'success' => true,
            'me' => $updatedMe
        ]);
    }

    /**
     * Delete user
     * @return \Illuminate\Http\JsonResponse
     */
    function delete(): \Illuminate\Http\JsonResponse
    {
        throw_if(
            \Auth::user()->hasRole(\App\Enums\Api\Roles\RolesEnum::SUPER_ADMIN),
            new \App\Exceptions\Api\UnauthorizedActionException()
        );

        UserService::delete(\Auth::user());

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Avatar upload
     * @param \App\Http\Requests\AvatarRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    function avatarUpload(\App\Http\Requests\AvatarRequest $request): \Illuminate\Http\JsonResponse
    {
        $path = UserService::updateAvatar(\Auth::user(), $request->validated());

        return response()->json([
            'success' => true,
            'avatar_url' => \Storage::url($path)
        ]);
    }
}
