<?php

/**
* @package FST3_Lagerverwaltung 
 */
/*
Plugin Name: FST3 Lagerverwaltung
Plugin URI: https://www.google.com
Description: Plugin für FST3
Version: 0.0.1   
Author: FST3Grup2_1
License: GPLv3
 */


 if ( ! defined( 'ABSPATH' )) {
     die;
 }


class FST3_LVClass {

	function __construct() {
		add_action( 'init', array( $this, 'add_admin_page' ) );
	}

    function register(){
        add_action( 'admin_menu', array( $this, 'add_admin_page' ));
    }

    public function add_admin_page() {
        //add_menu_page( 'FST3_LV', 'Lagerverwaltung', 'manage_options', 'FST3_Lagerverwaltung/FST3_LagerverwaltungPage.php', 'myplguin_admin_page', 'dashicons-buddicons-community', 110);
       add_menu_page('FST3_LV', 'Lagerverwaltung', 'manage_options', 'FST3_LV_Plugin', array( $this, 'admin_index' ), 'dashicons-buddicons-community', 110);
    }
    
    public function activate() {
        $this -> register();
        flush_rewrite_rules();
    }
    public function deactivate() {
        flush_rewrite_rules();
    }

    public function admin_index(){
        ?>
        <div class="wrap">
            <h2>Dies wird die Lagerverwaltung</h2>
        </div>
        <div class="wrap">
            <h3>Akuteller Status: Auslesen von Datenbank informationen und einfache Anzeige dieser</h3>
        <?php


        global $wpdb;
        // this adds the prefix which is set by the user upon instillation of wordpress
        $table_name = $wpdb->prefix . "posts";
        // this will get the data from your table
        $retrieve_data = $wpdb->get_results( "SELECT ID, post_title FROM $table_name where post_type = 'product' and post_status='publish'" );
        ?> <table style="width:400px">
        <tr>
            <th style="font-weight: bold;text-align: right">ProduktID</th>
            <th style="font-weight: bold;text-align: left">ProduktName</th>
        </tr>
        <?php 
        foreach ($retrieve_data as $retrieved_data){ ?>
        <tr>
        <td style="text-align: right"><?php echo $retrieved_data->ID;?></td>
        <td style="text-align: left"><?php echo $retrieved_data->post_title;?></td>
        </tr>
        <?php 
        }
        ?>
        </table> 
        <?php


    }


}

    if (class_exists("FST3_LVClass")) {
        $classobjecttemp = new FST3_LVClass();
    }

    register_activation_hook( __FILE__, array($classobjecttemp, 'activate'));
    register_deactivation_hook(__FILE__, array($classobjecttemp, 'deactivate'));
