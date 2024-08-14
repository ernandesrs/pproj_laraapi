<?php

namespace App\Policies;

use App\Enums\Permissions\UserPermissionsEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserPolicy extends BasePolicy
{
    /**
     * Permissions enum class
     * @return string
     */
    function permissionsEnumClass(): string
    {
        return UserPermissionsEnum::class;
    }

    /**
     * Update user authorization check
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    function update(User $user, Model $model): bool
    {
        // Prevents edition of own account
        if ($user->id == $model->id) {
            return false;
        }

        if ($this->isSuperUser($user)) {
            return true;
        }

        if (!$user->hasPermissionTo($this->permissionsEnumClass()::UPDATE)) {
            return false;
        }

        return true;
    }

    /**
     * Delete user authorization check
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    function delete(User $user, Model $model): bool
    {
        // Prevents deletion of own account
        if ($user->id == $model->id) {
            return false;
        }

        if ($this->isSuperUser($user)) {
            return true;
        }

        if (!$user->hasPermissionTo($this->permissionsEnumClass()::DELETE)) {
            return false;
        }

        return true;
    }

    /**
     * User role edit authorization check
     * @param \App\Models\User $user
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
     */
    function editRole(User $user, Model $model): bool
    {
        // Prevents role edit of own account
        if ($user->id == $model->id) {
            return false;
        }

        if ($this->isSuperUser($user)) {
            return true;
        }

        return $user->hasPermissionTo(UserPermissionsEnum::EDIT_ROLE);
    }
}
