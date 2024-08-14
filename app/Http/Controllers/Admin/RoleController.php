<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\InvalidDataException;
use App\Http\Controllers\WithFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GiveOrRevokePemissionRequest;
use App\Http\Resources\Admin\RoleResource;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use WithFilter;

    /**
     * Index
     * @return \Illuminate\Http\JsonResponse
     */
    function index(): \Illuminate\Http\JsonResponse
    {
        $this->authorize('viewAny', Role::class);

        $filterData = $this->getValidatedFilterInputs([
            'limit' => ['nullable', 'integer', 'min:1', 'max:50'],
            'search' => ['nullable', 'string', 'max:25']
        ], \Request::only(['search', 'limit']));

        $roles = $this->applyFilter(Role::class, $filterData, ['name']);

        return response()->json([
            'success' => true,
            'roles' => RoleResource::collection($roles)->response()->getData(),
            'available_permissions' => Permission::avaiablePermissions(true)
        ]);
    }

    /**
     * Store a role
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->authorize('create', Role::class);

        $validator = \Validator::make($request->only(['name']), [
            'name' => ['required', 'string', 'unique:roles,name']
        ]);

        if ($validator->fails()) {
            session()->flash("validator_errors", $validator->errors());
            throw new InvalidDataException();
        }

        $created = Role::create([
            ...$validator->validate(),
            'guard_name' => 'web'
        ]);

        return response()->json([
            'success' => true,
            'role' => new RoleResource($created)
        ]);
    }

    /**
     * Show
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    function show(Role $role): \Illuminate\Http\JsonResponse
    {
        $this->authorize('view', $role);

        return response()->json([
            'success' => true,
            'role' => new RoleResource($role),
            'avaiable_permissions' => Permission::avaiablePermissions(true)
        ]);
    }

    /**
     *
     * Give permissions
     * @param \App\Http\Requests\Admin\GiveOrRevokePemissionRequest $request
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    function givePermissions(GiveOrRevokePemissionRequest $request, Role $role): \Illuminate\Http\JsonResponse
    {
        $this->authorize('update', $role);

        $validated = $request->validated();

        $role->givePermissionTo($validated['permissions']);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Revoke permissions
     * @param \App\Http\Requests\Admin\GiveOrRevokePemissionRequest $request
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    function revokePermissions(GiveOrRevokePemissionRequest $request, Role $role): \Illuminate\Http\JsonResponse
    {
        $this->authorize('update', $role);

        $validated = $request->validated();

        /**
         * @var \Illuminate\Support\Collection $permissionsToRevoke
         */
        $permissionsToRevoke = $validated['permissions'];
        $permissionsToRevoke->map(fn($permissionToRevoke) => $role->revokePermissionTo($permissionToRevoke));

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Destroy a role
     * @param \App\Models\Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    function destroy(Role $role): \Illuminate\Http\JsonResponse
    {
        $this->authorize('delete', $role);

        $role->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
