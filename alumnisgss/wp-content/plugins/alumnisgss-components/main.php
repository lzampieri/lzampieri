<?php
namespace alumnisgss_components_main;

function activate () {

}

function deactivate () {

}

function register_hooks () {
    add_action( 'admin_menu', 'alumnisgss_components_main\add_admin_page' );

    // Add filter to show private stuff in menu creator
    add_filter( 'nav_menu_meta_box_object', 'alumnisgss_components_main\show_private_stuff_menu_creator' );
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

function show_private_stuff_menu_creator( $args ){
	if( $args->name == 'post' ) {
		$args->_default_query['post_status'] = array('publish','private');
	}
	return $args;
}