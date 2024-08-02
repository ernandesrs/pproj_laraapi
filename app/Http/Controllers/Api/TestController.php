<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Test
     * @return \Illuminate\Http\JsonResponse
     */
    function test(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true,
        ]);
    }
}
