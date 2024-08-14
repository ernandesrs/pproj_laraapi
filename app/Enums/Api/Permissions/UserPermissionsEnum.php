<?php

namespace App\Enums\Api\Permissions;

enum UserPermissionsEnum: string
{
    case VIEW_ANY = 'view_any_users';
    case VIEW = 'view_user';
    case CREATE = 'create_user';
    case UPDATE = 'update_user';
    case DELETE = 'delete_user';
    case DELETE_MANY = 'delete_many_users';
    case EDIT_ROLE = 'edit_user_roles';
}
