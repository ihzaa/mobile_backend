<?php

namespace Database\Seeders;

use App\Utils\PermissionHelper;
use Spatie\Permission\Models\Permission;

class createPermission
{
    public static function create($permission)
    {
        $actions = PermissionHelper::ACTIONS;

        $permissionName = [];
        foreach ($actions as $action) {
            $permissionName[] = $action . ' ' . $permission;
            Permission::create(['name' =>  $action . ' ' . $permission]);
        }
        return $permissionName;
    }
}
