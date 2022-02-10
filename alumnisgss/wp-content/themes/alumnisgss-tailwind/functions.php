<?php
if ( ! function_exists( 'myfirsttheme_setup' ) ) :

// Init

function alumnisgss_init() {

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
            'supports' => array( 'title', 'editor' )
        )
    );
}
add_action( 'init', 'alumnisgss_init' );


// Add custom fields to sections post type
function alumnisgss_sections_addmetaboxes() {
    add_meta_box(
        'sections_metadata_pagetorefer',
        'Pagina in cui comparire',
        'alumnisgss_sections_getmetaboxes_pagetorefer',
        'alumnisgss_sections', // act only on this post type
        'side',
        'high'
    );
}
function alumnisgss_sections_getmetaboxes_pagetorefer() {
    $selected = get_post_custom()['page_to_refer'][0];
    $pages = get_pages();
    $options = "";
    $selected_attribute = " selected ";
    foreach ( $pages as $page ) {
        $options .= "<option value=" . $page->ID;
        if( $page->ID == $selected ) {
            $options .= $selected_attribute;
            $selected_attribute = "";
        }
        $options .= ">" . $page->post_title . "</option>";
    }
    echo <<<FIELD
    <select name="page_to_refer" id="page_to_refer">
        <option value="-1" $selected_attribute>Seleziona...</option>
        $options
    </select>
    FIELD;
}
function alumnisgss_sections_savemetaboxes_pagetorefer($post_id) {
    if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
        return;
    }
    update_post_meta(
        $post_id,
        'page_to_refer',
        array_key_exists( 'page_to_refer', $_POST ) ? $_POST['page_to_refer'] : "Seleziona..."
    );
}
add_action( 'admin_init', 'alumnisgss_sections_addmetaboxes' );
add_action( 'save_post', 'alumnisgss_sections_savemetaboxes_pagetorefer');

endif;