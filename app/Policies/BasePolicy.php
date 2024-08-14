<?php

namespace App\Policies;

use App\Enums\Roles\RolesEnum;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\Model;

abstract class BasePolicy
{
    /**
     * Permissions enum class
     * @return string
     */
    abstract function permissionsEnumClass(): string;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($this->isSuperUser($user)) {
            return true;
        }

        return $user->hasPermissionTo($this->permissionsEnumClass()::VIEW_ANY);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Model $model): bool
    {
        if ($this->isSuperUser($user)) {
            return true;
        }

        return $user->hasPermissionTo($this->permissionsEnumClass()::VIEW);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($this->isSuperUser($user)) {
            return true;
        }

        return $user->hasPermissionTo($this->permissionsEnumClass()::CREATE);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Model $model): bool
    {
        if ($this->isSuperUser($user)) {
            return true;
        }

        return $user->hasPermissionTo($this->permissionsEnumClass()::UPDATE);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Model $model): bool
    {
        if ($this->isSuperUser($user)) {
            return true;
        }

        return $user->hasPermissionTo($this->permissionsEnumClass()::DELETE);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Model $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Model $model): bool
    {
        return false;
    }

    /**
     * Check if user is super user
     * @param \App\Models\User $user
     * @return bool
     */
    protected function isSuperUser(User $user)
    {
        return $user->hasRole(RolesEnum::SUPER_ADMIN);
    }
}
