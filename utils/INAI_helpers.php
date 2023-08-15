<?php

/****************
 * function to get admin premission array
 */
function INAIGetAdminPermissions(){

    $prefix = INAI_PREFIX;

    return collect([

	    'read' => ['name' => 'read', 'status' => 1],
        'dashboard' => ['name' => $prefix . 'dashboard', 'status' => 1]

    ]);
}

function INAIGetPermission($permission_name)
{
    $permissions = INAIGetAdminPermissions()->toArray();

    return $permissions[$permission_name]['name'];
}