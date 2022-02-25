<?php
namespace alumnisgss_components_alias;

function activate () {
    register_alias_post_type();
    flush_rewrite_rules();
}

function deactivate () {
}

function register_hooks () {
    add_action( 'init', 'alumnisgss_components_alias\register_alias_post_type' );
    add_action( 'pre_get_posts', 'alumnisgss_components_alias\include_aliases_in_post_queries', 1 );
    add_filter( 'single_template', 'alumnisgss_components_alias\redirect_when_single' );
}

function register_alias_post_type() {
    register_post_type('alumnisgss_alias',
        array(
            'labels'      => array(
                'name' => 'Aliases',
                'singular_name' => 'Alias',
                'add_new_item' => 'Aggiungi nuovo alias'
            ),
            'description' => 'Articoli ospitati su altri indirizzi',
            'public'      => true,
            'supports' => array( 'title', 'editor' ),
            'taxonomies' => [ 'category' ]
        )
    );
}

function include_aliases_in_post_queries( $query ) {
    if( is_admin() ) return;
    if( $query -> get( 'post_type' ) == 'post' ) {
        $query -> set( 'post_type', array( 'post', 'alumnisgss_alias' ) );
    }
}
 
function redirect_when_single( $single_template ) {
    global $post;
 
    if ( $post->post_type == 'alumnisgss_alias' ) {
        wp_redirect( trim( strip_tags( $post->post_content ) ) );
        exit();
    }
 
    return $single_template;
}