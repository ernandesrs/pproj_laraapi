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
}
