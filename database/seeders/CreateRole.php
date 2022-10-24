<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CreateRole
{
    public static function createRole($guard, $name, array $permissions)
    {
        $role1 = Role::create(['guard_name' => $guard, 'name' => $name]);
        foreach($permissions as $permission){
            $role1->givePermissionTo($permission);
        }
        return $role1;
    }
}
