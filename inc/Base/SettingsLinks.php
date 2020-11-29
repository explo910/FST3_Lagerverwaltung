<?php

/** 
 * Trigger this file on Plugin uninstall
 * 
* @package FST3_Lagerverwaltung
*/

defined('ABSPATH') or die('You cant access this File');

namespace Inc\Base;

use \Inc\Base\BaseController;

class SettingsLinks extends BaseController {

    public function register() {
        add_filter( 'plugin_action_links_' . $this->plugin_basename, array( $this, 'settings_link'));
    }

    public function settings_link( $links ) {
        $settings_link = '<a href="admin.php?page=gyc_lv">Settings</a>';
        array_push( $links, $settings_link);
        echo "TEST";
        return $links;
    }
}