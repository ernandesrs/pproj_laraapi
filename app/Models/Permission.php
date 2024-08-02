<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HasFactory;

    /**
     * Allowed permissions
     * @return \Illuminate\Support\Collection
     */
    static function allowedPermissions(): Collection
    {
        $permissions = Collection::make([]);
        $namespaceBase = '\App\Enums\Api\Permissions';
        $basePath = app_path('\Enums\Api\Permissions');

        Collection::make(\File::allFiles($basePath))->map(function ($v, $k) use ($namespaceBase, &$permissions) {
            $enumClass = $namespaceBase . (empty($v->getRelativePath()) ? '' : '\\') . $v->getRelativePath() . '\\' . $v->getFilenameWithoutExtension();
            $permissions->put($enumClass, $enumClass::cases());
        });

        return $permissions;
    }
}
