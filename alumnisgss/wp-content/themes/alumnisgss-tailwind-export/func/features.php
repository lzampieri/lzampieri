<?php

function alumnisgss_features_register() {
    add_theme_support('post-thumbnails');
}
add_action( 'init', 'alumnisgss_features_register' );

function alumnisgss_features_register_register_footer_tagline( $wp_customize ) {
    $wp_customize->add_setting(
        'alumnisgss_footer_tagline',
        array(
            'default' => '',
            'type' => 'option', // you can also use 'theme_mod'
            'capability' => 'edit_theme_options'
        ),
    );

    $wp_customize->add_control( new WP_Customize_Control(
        $wp_customize,
        'alumnisgss_footer_tagline',
        array(
            'label'      => 'Nota a fondo pagina',
            'description' => '',
            'settings'   => 'alumnisgss_footer_tagline',
            'priority'   => 0,
            'section'    => 'title_tagline',
            'type'       => 'text',
        )
    ) );
}
add_action( 'customize_register', 'alumnisgss_features_register_register_footer_tagline' );
