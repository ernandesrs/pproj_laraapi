<?php

namespace App\Policies;

use App\Enums\Api\Permissions\UserPermissionsEnum;
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
        // Prevents edit of own account
        if ($user->id == $model->id) {
            return false;
        }

        // Check if the logged in user can edit this user

        return $this->update($user, $model);
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

        // Check if the logged in user can delete this user

        return parent::delete($user, $model);
    }
}
