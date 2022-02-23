<?php
namespace alumnisgss_components_main;

function activate () {

}

function deactivate () {

}

function register_hooks () {
    add_action( 'admin_menu', 'alumnisgss_components_main\add_admin_page' );
}

function add_admin_page() {
    add_menu_page(
        'Impostazioni del plugin AlumniSGSS',
        'Alumni',
        'manage_options',
        'alumnisgss_components_admin',
        'alumnisgss_components_main\admin_page_content',
        '',
        7
    );
}

function admin_page_content() {
?>
    <h1>Usa il menù a sinistra per navigare fra le opzioni disponibili.</h1>
<?php
}