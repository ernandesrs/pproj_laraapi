<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\WithFilter;
use App\Http\Controllers\Controller;
use App\Services\UserService;
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
            'users' => \App\Http\Resources\Admin\UserResource::collection(
                $this->applyFilter(\App\Models\User::class, $filterData, ['first_name'])
            )->response()->getData()
        ]);
    }

    /**
     * Store a user
     * @param \App\Http\Requests\Admin\UserFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(\App\Http\Requests\Admin\UserFormRequest $request): \Illuminate\Http\JsonResponse
    {
        $created = UserService::create($request->validated());

        return response()->json([
            'success' => true,
            'user' => $created
        ]);
    }

    /**
     * Show a user
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(\App\Models\User $user): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true,
            'user' => new \App\Http\Resources\Admin\UserResource($user)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Destroy a user
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(\App\Models\User $user)
    {
        return response()->json([
            'success' => $user->delete()
        ]);
    }
}
