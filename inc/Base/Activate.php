<?php

/** 
 * Trigger this file on Plugin uninstall
 * 
* @package FST3_Lagerverwaltung
*/

defined('ABSPATH') or die('You cant access this File');

namespace Inc\Base;

class Activate {

    public static function activate() {
        flush_rewrite_rules();
        Activate::initialize_internal_stock();
    }

    public static function initialize_internal_stock() {
        global $wpdb;
        $wpdb->query("update ".$wpdb->prefix."posts set post_type = 'product' where post_type = 'product'");
    }

}