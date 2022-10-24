<?php

namespace App\Utils;

class PermissionHelper
{
    const SPECIAL_PERMISSIONS = [
        // name => description
        'Super-Admin' => 'Bypass all permissions, for Administrators only',
    ];

    const ACTIONS = [
        'view', 'create', 'update', 'delete', 'restore'
    ];

    const PERMISSIONS = [
        'Pengaturan_User' => [
            'Pengaturan_User_Perizinan',
            'Pengaturan_User_User',
        ],
    ];
}
