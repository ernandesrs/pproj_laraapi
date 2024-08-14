<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\WithFilter;
use App\Http\Controllers\Controller;
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
            'roles' => RoleResource::collection($roles),
            'available_permissions' => Permission::avaiablePermissions(true)
        ]);
    }
}
