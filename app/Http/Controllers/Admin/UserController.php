<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\WithFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\RoleResource;
use App\Http\Resources\Admin\UserResource;
use App\Models\Role;
use App\Models\User;
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
        $this->authorize('viewAny', User::class);

        $filterData = $this->getValidatedFilterInputs([
            'limit' => ['nullable', 'integer', 'min:1', 'max:50'],
            'search' => ['nullable', 'string', 'max:25']
        ], \Request::only(['search', 'limit']));

        return response()->json([
            'success' => true,
            'users' => UserResource::collection(
                $this->applyFilter(User::class, $filterData, ['first_name'])
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
        $this->authorize('create', User::class);

        $created = UserService::create($request->validated());

        return response()->json([
            'success' => true,
            'user' => new UserResource($created)
        ]);
    }

    /**
     * Show a user
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user): \Illuminate\Http\JsonResponse
    {
        $this->authorize('create', $user);

        return response()->json([
            'success' => true,
            'user' => new UserResource($user)
        ]);
    }

    /**
     * Update a user
     * @param \App\Http\Requests\Admin\UserFormRequest $request
     * @param \App\Models\User $user
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function update(\App\Http\Requests\Admin\UserFormRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $updated = UserService::update($user, $request->validated());

        return response()->json([
            'success' => true,
            'updated' => new UserResource($updated)
        ]);
    }

    /**
     * Destroy a user
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user): \Illuminate\Http\JsonResponse
    {
        $this->authorize('delete', $user);

        return response()->json([
            'success' => $user->delete()
        ]);
    }

    /**
     * Assign role to user
     * @param \App\Models\User $user
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function assignRole(User $user, Role $role): \Illuminate\Http\JsonResponse
    {
        $this->authorize('editRole', $user);

        $user->assignRole($role);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Remove role to user
     * @param \App\Models\User $user
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeRole(User $user, Role $role): \Illuminate\Http\JsonResponse
    {
        $this->authorize('editRole', $user);

        $user->removeRole($role);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * User roles
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function roles(User $user): \Illuminate\Http\JsonResponse
    {
        $this->authorize('view', $user);

        return response()->json([
            'success' => true,
            'roles' => RoleResource::collection($user->roles()->get())
        ]);
    }
}
