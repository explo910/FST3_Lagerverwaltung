<?php

/** 
* @package FST3_Lagerverwaltung
*/
/*
Plugin Name: GetYourCake Lagerverwaltung
Plugin URI: http://gidf.de
Description: Dies ist die custom Lagerverwaltung für GetYourCake
Version: 0.0.1
Author: Gruppe 2_1
Author URI: https://technikum-wien.at
License: GPLv3 or later
Text Domein: FST3_Lagerverwaltung
*/

/*
    This file is part of FST3_Lagerverwaltung.

    FST3_Lagerverwaltung is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    FST3_Lagerverwaltung is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*/

defined('ABSPATH') or die('You cant access this File');

if ( file_exists( dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

function activate_myplugin() {
    Inc\Base\Activate::activate();
}

function deactivate_myplugin() {
    Inc\Base\Deactivate::deactivate();
}

//activation
register_activation_hook( __FILE__, 'activate_myplugin');

//deactivation
register_deactivation_hook( __FILE__, 'deactivate_myplugin');

if ( class_exists('Inc\\Init')) {
    Inc\Init::register_services();
}