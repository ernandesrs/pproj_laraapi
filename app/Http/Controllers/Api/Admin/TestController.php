<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Admin access test
     * @return \Illuminate\Http\JsonResponse
     */
    function test(): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true
        ]);
    }
}
