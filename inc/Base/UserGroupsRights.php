<?php

/** 
 * Trigger this file on Plugin uninstall
 * 
* @package FST3_Lagerverwaltung
*/

defined('ABSPATH') or die('You cant access this File');

namespace Inc\Base;

use \Inc\Base\BaseController;

class UserGroupsRights extends BaseController {

    public function register() {
        $this->create_roles();
    }

    public function create_roles() {
        get_role( 'administrator' ) -> add_cap('lvmit', true);

        get_role( 'administrator' ) -> add_cap('lvmgmt', true);


        $mitarbeiter_role_set = get_role( 'shop_manager' )->capabilities;
 
        // Add a new capability.
        $role = 'lmitarb';
        $display_name = 'Lagermitarbeiter';
        add_role( $role, $display_name, $mitarbeiter_role_set );
        get_role( 'lmitarb' ) -> add_cap('lvmit', true);

        $mitarbeiter_role_set = get_role( 'shop_manager' )->capabilities;
        // Add a new capability.
        $role = 'lvmanagement';
        $display_name = 'Lagermanagement';
        add_role( $role, $display_name, $mitarbeiter_role_set );
        get_role( 'lvmanagement' ) -> add_cap('lvmgmt', true);
    }
}