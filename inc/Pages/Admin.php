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

        #Subpages with Right for new Groups
        add_submenu_page('gyc_lv', 'Lagerstand', 'Lagerstand','lvmit', 'gyc_lstand', array( $this, 'admin_lstand' ));
        add_submenu_page('gyc_lv', 'Lagertransaktionen', 'Lagertransaktionen', 'lvmgmt', 'gyc_ltrans', array( $this, 'admin_ltrans' ));
        add_submenu_page('null', 'Lageraktualisierung', 'Lageraktualisierung', 'lvmit', 'gyc_lakt', array( $this, 'admin_lakt' ));
    }

    public function admin_index() {
        require_once $this->plugin_path . 'templates/admin_index.php';
    }

    public function admin_lstand() {
        require_once $this->plugin_path . 'templates/admin_lstand.php';
    }

    public function admin_ltrans() {
        require_once $this->plugin_path . 'templates/admin_ltrans.php';
    }

    public function admin_lakt() {
        require_once $this->plugin_path . 'templates/admin_lakt.php';
    }

}