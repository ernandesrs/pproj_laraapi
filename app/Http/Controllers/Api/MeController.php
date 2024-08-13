<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
}
