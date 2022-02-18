<?php
if ( ! function_exists( 'myfirsttheme_setup' ) ) :

// Init
function alumnisgss_init() {
    add_theme_support('post-thumbnails');

    // Register "section" post type
    register_post_type('alumnisgss_sections',
        array(
            'labels'      => array(
                'name'          => __('Sezioni', 'textdomain'),
                'singular_name' => __('Sezione', 'textdomain'),
            ),
            'description' => 'Sezioni per le pagine del template',
            'public'      => true,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_in_nav_menus' => false,
            'show_in_rest' => false,
            'supports' => array( 'title', 'editor', 'thumbnail' )
        )
    );

    // Register menù
    register_nav_menus(
        array(
            'main-menu' => 'Menù principale',
            )
    );    
}
add_action( 'init', 'alumnisgss_init' );

// Add custom fields to sections post type
function alumnisgss_sections_addmetaboxes() {
    add_meta_box(
        'sections_metadata_itemtorefer',
        'Oggetto in cui comparire',
        'alumnisgss_sections_getmetaboxes_itemtorefer',
        'alumnisgss_sections', // act only on this post type
        'side',
        'high'
    );
    add_meta_box(
        'sections_metadata_catalog',
        '(Facoltativo) Catalogo da mostrare dopo la sezione:',
        'alumnisgss_sections_getmetaboxes_catalog',
        'alumnisgss_sections', // act only on this post type
        'side',
        'high'
    );
}
add_action( 'admin_init', 'alumnisgss_sections_addmetaboxes' );
// // Item to Refer
function alumnisgss_sections_getmetaboxes_itemtorefer() {
    $selected = get_post_custom()['item_to_refer'][0];
    $options = "";
    
    $addoption = function($key, $name) use (&$options, $selected) {
        $options .= "<option value=" . $key . ( $key == $selected ? " selected" : "" ) . ">" . $name . "</option>";
    };
    $addsection = function($name) use (&$options, $selected) {
        $options .= "<option disabled>" . $name . "</option>";
    };

    $addoption( "homepage", "Home page" );
    $addoption( "hidden", "Bozza" );

    // Pages
    $pages = get_pages();
    $addsection("-- Pagine --");
    foreach ( $pages as $page ) {
        $addoption( "page_" . $page->ID, $page->post_title );
    }

    // Categories
    $addsection("-- Categorie --");
    $cats = get_categories( array( 'hide_empty' => false ) );
    foreach ( $cats as $cat ) {
        $addoption( "cat_" . $cat->term_id, $cat->name );
    }

    // Posts
    $addsection("-- Articoli --");
    $posts = get_posts();
    foreach ( $posts as $post ) {
        $addoption( "post_" . $post->ID, $post->post_title );
    }
    
    echo <<<FIELD
    <select name="item_to_refer" id="item_to_refer">
        $options
    </select>
    FIELD;
}
function alumnisgss_sections_savemetaboxes_itemtorefer($post_id) {
    if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return;
    }
    update_post_meta(
        $post_id,
        'item_to_refer',
        array_key_exists( 'item_to_refer', $_POST ) ? $_POST['item_to_refer'] : 'hidden'
    );
}
add_action( 'save_post', 'alumnisgss_sections_savemetaboxes_itemtorefer');
// // Catalog
function alumnisgss_sections_getmetaboxes_catalog() {
    $selected = get_post_custom()['catalog'][0];
    $options = "";
    
    $addoption = function($key, $name) use (&$options, $selected) {
        $options .= "<option value=" . $key . ( $key == $selected ? " selected" : "" ) . ">" . $name . "</option>";
    };
    $addoption( "Nessuno", -1 );

    // Categories
    $cats = get_categories();
    foreach ( $cats as $cat ) {
        $addoption( $cat->term_id, $cat->name );
    }

    echo <<<FIELD
    <select name="catalog" id="catalog">
        $options
    </select>
    FIELD;
}
function alumnisgss_sections_savemetaboxes_catalog($post_id) {
    if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return;
    }
    update_post_meta(
        $post_id,
        'catalog',
        array_key_exists( 'catalog', $_POST ) ? $_POST['catalog'] : -1
    );
}
add_action( 'save_post', 'alumnisgss_sections_savemetaboxes_catalog');


// Css and Js
function add_theme_scripts() {
    wp_enqueue_style( 'app', get_template_directory_uri() . '/assets/app.css' );
    wp_enqueue_script( 'app', get_template_directory_uri() . '/assets/app.js' );
}
add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );

endif;