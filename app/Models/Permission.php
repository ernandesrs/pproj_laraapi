<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;

class Permission extends \Spatie\Permission\Models\Permission
{
    use HasFactory;

    /**
     * Hidden fields
     * @var array
     */
    protected $hidden = [
        'guard_name',
        'pivot'
    ];

    /**
     * Avaiable permissions
     * @param bool $unnamedKey
     * @return \Illuminate\Support\Collection
     */
    static function avaiablePermissions(bool $unnamedKey = false): Collection
    {
        $permissions = Collection::make([]);
        $namespaceBase = '\App\Enums\Permissions';
        $basePath = app_path('\Enums\Permissions');

        Collection::make(\File::allFiles($basePath))->map(function ($v, $k) use ($namespaceBase, &$permissions, $unnamedKey) {
            $enumClass = $namespaceBase . (empty($v->getRelativePath()) ? '' : '\\') . $v->getRelativePath() . '\\' . $v->getFilenameWithoutExtension();
            if (!$unnamedKey) {
                $permissions->put($enumClass, $enumClass::cases());
            } else {
                $permissions->push($enumClass::cases());
            }
        });

        return $permissions;
    }

    /**
     * Allowed permissions
     * @param bool $unnamedKey
     * @return \Illuminate\Support\Collection
     * @deprecated Use the 'avaiablePermissions' method
     */
    static function allowedPermissions(bool $unnamedKey = false): Collection
    {
        return self::avaiablePermissions($unnamedKey);
    }
}
