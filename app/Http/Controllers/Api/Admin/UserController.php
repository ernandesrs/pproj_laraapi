<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\WithFilter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use WithFilter;

    /**
     * Users
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        $filterData = $this->getValidatedFilterInputs([
            'limit' => ['nullable', 'integer', 'min:1', 'max:50'],
            'search' => ['nullable', 'string', 'max:25']
        ], \Request::only(['search', 'limit']));

        return response()->json([
            'success' => true,
            'users' => $this->applyFilter(\App\Models\User::class, $filterData, ['first_name'])
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
