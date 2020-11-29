<?php

/** 
 * Trigger this file on Plugin uninstall
 * 
* @package FST3_Lagerverwaltung
*/

defined('ABSPATH') or die('You cant access this File');

namespace Inc\Base;

use \Inc\Base\BaseController;

class UserGroupRights extends BaseController {

    public function register() {
        create_roles();
    }

    public function create_roles() {
        $mitarbeiter_role_set = get_role( 'mitarbeiter' )->capabilities;
 
        // Add a new capability.
        $role = 'lmitarb';
        $display_name = 'Lagermitarbeiter';
        $role -> add_cap('lvmit', true);
        add_role( $role, $display_name, $mitarbeiter_role_set );


        $mitarbeiter_role_set = get_role( 'mitarbeiter' )->capabilities;
        // Add a new capability.
        $role = 'lvmanagement';
        $display_name = 'Lagermanagement';
        $role -> add_cap('lvmgmt', true);
        add_role( $role, $display_name, $mitarbeiter_role_set );
        
    }
}