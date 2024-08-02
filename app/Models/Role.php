<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;

class Role extends \Spatie\Permission\Models\Role
{
    use HasFactory;

    /**
     * Default roles
     * @return \Illuminate\Support\Collection
     */
    static function defaultRoles(): Collection
    {
        $roles = Collection::make([]);
        $namespaceBase = '\App\Enums\Api\Roles';
        $basePath = app_path('\Enums\Api\Roles');

        Collection::make(\File::allFiles($basePath))->map(function ($v, $k) use ($namespaceBase, &$roles) {
            $enumClass = $namespaceBase . (empty($v->getRelativePath()) ? '' : '\\') . $v->getRelativePath() . '\\' . $v->getFilenameWithoutExtension();
            $roles = $roles->merge($enumClass::cases());
        });

        return $roles;
    }
}
