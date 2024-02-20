<?php
/*
Plugin Name: Customer Feedback
Description: Tämä lisäosa mahdollistaa asiakaspalautteen kirjoittamisen ja tallentamisen hallintapaneelissa.
Version: 1.0
Author: Jonna Satta
*/

require_once('includes/customer-feedback-post-type.php');
require_once('includes/cfplugin-shortcodes.php');
 
function cfplugin_setup_menu() {
    add_menu_page('Customer Feedback', 'Feedback', 'manage_options', 'customer-feedback-plugin', 'cfplugin_display_admin_page');
}

function cfplugin_display_admin_page() {
    echo '<h1>Customer Feedback Plugin</h1>';
    echo '<p>Add a shortcode to an article or a page [customer-feedback-plugin] to show all feedback or 
    [customer-feedback-plugin category="Your category name"] to show from a specific category. </p>';
}

add_action('admin_menu', 'cfplugin_setup_menu');

function cfplugin_assets() {
    wp_enqueue_style('cfplugin-css', plugin_dir_url(__FILE__) . 'css/cfplugin.css');
}

add_action('wp_enqueue_scripts', 'cfplugin_assets');
?>
