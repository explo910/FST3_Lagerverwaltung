<?php

/** 
 * Trigger this file on Plugin uninstall
 * 
* @package FST3_Lagerverwaltung
*/

defined('ABSPATH') or die('You cant access this File');

namespace Inc\Base;

use \Inc\Base\BaseController;

class ManipulateWooCommerce extends BaseController {

    public function register() {
        $this->HideCategoriesFromDropdown();
    }

    public function HideCategoriesFromDropdown() {
        add_filter( 'widget_categories_dropdown_args', 'exclude_widget_categories', 10, 1);
    }

//Hide categories from WordPress category widget
function exclude_widget_categories($args){
    $exclude = "1,2,3,4,5,6,7,8"; // Category IDs to be excluded
    $args["exclude"] = $exclude;
    return $args;
}
//add_filter("widget_categories_args","exclude_widget_categories");
    //add_filter( 'woocommerce_product_categories_widget_dropdown_args', 'exclude_woocommerce_widget_product_categories');
    //add_filter( 'woocommerce_product_categories_widget_args', 'exclude_woocommerce_widget_product_categories');
}