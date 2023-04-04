<?php

namespace App\baseClasses;

use WP_Error;

class INAIActivate {

	public function __construct() {
        $this->addAdministratorPermission();
    }

    public static function activate(){

    }


    public function addAdministratorPermission () {
		$admin_permissions = INAIGetAdminPermissions()->pluck('name')->toArray();
		if (count($admin_permissions)) {
			$admin_role = get_role( 'administrator' );
            // echo "<pre>";
            // print_r($admin_role);
            // die();
			foreach ($admin_permissions as $permission) {
				$admin_role->add_cap( $permission, true );
			}
		}
	}

}