<?php

/** 
 * Trigger this file on Plugin uninstall
 * 
* @package FST3_Lagerverwaltung
*/

defined('WP_UNINSTALL_PLUGIN') or die('You cant access this File');

//Clear DB Stored Date
//$books = get_posts( array('post_type' => 'book', 'numberofposts' => -1));
/**
 * foreach($books as $book) {
 * wp_delete_post($book->ID, true);
 * }
 */
/*
global $wpdb;
$wpdb->query("DELETE FROM wp_posts WHERE post_type = 'book'");

$wpdb->query("DELETE FROM wp_postmeta WHERE post_id NOT IN ( SELECT id FROM wp_posts)");
$wpdb->query("DELETE FROM wp_term_relationsships WHERE object_id NOT IN ( SELECT id FROM wp_posts)");
 */
