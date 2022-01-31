<?php
/**
 * Plugin Name:       Alumni SGSS - Reserved area manager
 * Plugin URI:        https://github.com/lzampieri/lzampieri/tree/main/alumnisgss_reserved
 * Description:       Custom plugin to manage reserved area of Alumni SGSS website.
 * Version:           0.1
 * Requires at least: 5.8
 * Author:            Leonardo Zampieri
 * Author URI:        https://lzampieri.altervista.org/
 */

// Load class
require_once('ASGSSR.php');

// Activation and deactivation
function asgssr_activate() {
    ASGSSR::activate();
}
register_activation_hook( __FILE__, 'asgssr_activate' );

function asgssr_deactivate() {
    ASGSSR::deactivate();
}
register_deactivation_hook( __FILE__, 'asgssr_deactivate' );

function asgssr_uninstall() {
    ASGSSR::unistall();
}
register_uninstall_hook(__FILE__, 'asgssr_uninstall');

new ASGSSR();