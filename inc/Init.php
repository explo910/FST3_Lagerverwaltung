<?php
/** 
 * Trigger this file on Plugin uninstall
 * 
* @package FST3_Lagerverwaltung
*/

defined('ABSPATH') or die('You cant access this File');

namespace Inc;

final class Init {

    //Store Classes here to initialize them
    public static function get_services() {
        return [
            Pages\Admin::class,
            Base\Enqueue::class,
            Base\SettingsLinks::class
        ];
    }

    public static function register_services() {
        foreach ( self::get_services() as $class) {
            $service = self::instantiate ( $class );
            if ( method_exists($service, 'register') ) {
                $service->register();
            }
        }
    }

    private static function instantiate( $class ) {
        $service = new $class();
        return $service;
    }
}


         

//         protected function create_post_type() {
//             add_action( 'init', array ( $this, 'custom_post_type'));
//         }

//         function custom_post_type() {
//             register_post_type( 'book', ['public' => true, 'label' => 'Books']);
//         }
