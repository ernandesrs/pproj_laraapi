<?php

namespace App\Enums\Permissions;

enum RolePermissionsEnum: string
{
    case VIEW_ANY = 'view_any_roles';
    case VIEW = 'view_role';
    case CREATE = 'create_role';
    case UPDATE = 'update_role';
    case DELETE = 'delete_role';
    case DELETE_MANY = 'delete_many_roles';
}
