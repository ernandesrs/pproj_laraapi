<?php

namespace App\Enums\Api\Roles;

enum RolesEnum: string
{
    case SUPER_ADMIN = 'super';
    case USER_ADMIN = 'admin';
}
