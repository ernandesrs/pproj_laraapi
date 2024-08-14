<?php

namespace App\Http\Controllers;

use App\Enums\Roles\RolesEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserResource;
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
        $me = \Auth::user();
        $roles = $me->roles()->get();

        $roles->map(function ($role) {
            $role->permissions;
        });

        return response()->json([
            'success' => true,
            'me' => new UserResource($me),
            'roles' => $roles
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
            \Auth::user()->hasRole(RolesEnum::SUPER_ADMIN),
            new \App\Exceptions\UnauthorizedActionException()
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

    /**
     * Avatar delete
     * @return \Illuminate\Http\JsonResponse
     */
    function avatarDelete(): \Illuminate\Http\JsonResponse
    {
        UserService::deleteAvatar(\Auth::user());

        return response()->json([
            'success' => true
        ]);
    }
}
