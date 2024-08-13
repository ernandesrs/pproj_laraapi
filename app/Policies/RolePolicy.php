<?php

namespace App\Policies;

use App\Enums\Api\Permissions\RolePermissionsEnum;


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
}
