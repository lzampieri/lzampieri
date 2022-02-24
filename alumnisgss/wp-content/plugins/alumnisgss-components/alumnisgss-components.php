<?php
    /*
    Plugin Name: Alumni SGSS components
    Plugin URI: 
    description: 
    Version: 0.1
    Author: Leonardo Zampieri
    Author URI: 
    License: 
    */

function alumnisgss_components_activation() {
    require_once plugin_dir_path( __FILE__ ) . 'main.php';
    alumnisgss_components_main\activate();

    require_once plugin_dir_path( __FILE__ ) . 'members-list.php';
    alumnisgss_components_members_list\activate();
}
register_activation_hook( __FILE__, 'alumnisgss_components_activation' );

function alumnisgss_components_deactivation() {
    require_once plugin_dir_path( __FILE__ ) . 'main.php';
    alumnisgss_components_main\deactivate();
    
    require_once plugin_dir_path( __FILE__ ) . 'members-list.php';
    alumnisgss_components_members_list\deactivate();
}
register_deactivation_hook( __FILE__, 'alumnisgss_components_deactivation' );

function alumnisgss_components_register_hooks() {
    require_once plugin_dir_path( __FILE__ ) . 'main.php';
    alumnisgss_components_main\register_hooks();
    
    require_once plugin_dir_path( __FILE__ ) . 'members-list.php';
    alumnisgss_components_members_list\register_hooks();
}
alumnisgss_components_register_hooks();