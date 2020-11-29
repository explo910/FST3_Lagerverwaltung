<?php

/** 
 * Trigger this file on Plugin uninstall
 * 
* @package FST3_Lagerverwaltung
*/

defined('ABSPATH') or die('You cant access this File');

namespace Inc\Pages;

use \Inc\Base\BaseController;


class Admin extends BaseController
{
    function __constuct() {

    }

    function register() {
        add_action('admin_menu', array( $this, 'add_admin_pages'));
    }

    public function add_admin_pages() {
        add_menu_page('FST3_Lagerverwaltung', 'Lagerverwaltung', 'manage_options', 'gyc_lv', array( $this, 'admin_index' ), 'dashicons-buddicons-community', 110);
    }

    public function admin_index() {
        require_once $this->plugin_path . 'templates/admin_index.php';
    }

}