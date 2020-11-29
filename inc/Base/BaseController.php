<?php
/** 
 * Trigger this file on Plugin uninstall
 * 
* @package FST3_Lagerverwaltung
*/

defined('ABSPATH') or die('You cant access this File');

namespace Inc\Base;

class BaseController
{
    public $plugin_path;
    public $plugin_url;
    public $plugin_basename;

    public function __construct() {
        $this->plugin_path = plugin_dir_path( dirname(__FILE__, 2 ));
        $this->plugin_url = plugin_dir_url( dirname(__FILE__, 2 ));
        $this->plugin_basename = plugin_basename( dirname(__FILE__, 3 )) . '/FST3_Lagerverwaltung.php';
    }
}