<?php

/** 
 * Trigger this file on Plugin uninstall
 * 
* @package FST3_Lagerverwaltung
*/

defined('ABSPATH') or die('You cant access this File');

namespace Inc\Base;

class Deactivate {

    public static function deactivate() {
        flush_rewrite_rules();
    }

}