<?php

namespace App\Policies;

use App\Enums\Api\Permissions\RolePermissionsEnum;
use App\Enums\Api\Roles\RolesEnum;

class RolePolicy extends BasePolicy
{
    /**
     * Permissions enum class
     * @return string
     */
    function permissionsEnumClass(): string
    {
        return RolePermissionsEnum::class;
    }

    /**
     * Update
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    function update(\App\Models\User $user, \Illuminate\Database\Eloquent\Model $model): bool
    {
        // can't update super admin
        if ($model->name == RolesEnum::SUPER_ADMIN->value) {
            return false;
        }

        return parent::update($user, $model);
    }

    /**
     * Delete
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    function delete(\App\Models\User $user, \Illuminate\Database\Eloquent\Model $model): bool
    {
        // can't delete super admin or admin
        if (
            $model->name == RolesEnum::SUPER_ADMIN->value ||
            $model->name == RolesEnum::USER_ADMIN->value
        ) {
            return false;
        }

        return parent::delete($user, $model);
    }

    /**
     * Force delete
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    public function forceDelete(\App\Models\User $user, \Illuminate\Database\Eloquent\Model $model): bool
    {
        // can't force delete super admin or admin
        if (
            $model->name == RolesEnum::SUPER_ADMIN->value ||
            $model->name == RolesEnum::USER_ADMIN->value
        ) {
            return false;
        }

        return parent::forceDelete($user, $model);
    }
}
