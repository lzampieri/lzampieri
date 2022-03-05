<?php

function alumnisgss_socials_register_option( $wp_customize ) {
    
    $socials_list = array('facebook', 'instagram', 'twitter', 'linkedin', 'telegram', 'tiktok', 'whatsapp', 'youtube');
    update_option( 'alumnisgss_socials_list', implode( ', ', $socials_list ) );

    foreach( $socials_list as $s ) {
        $wp_customize->add_setting(
            'alumnisgss_socials_link_' . $s,
            array(
                'default' => '',
                'type' => 'option',
                'capability' => 'edit_theme_options'
            ),
        );
    }

    $wp_customize->add_section( new WP_Customize_Section(
        $wp_customize,
        'alumnisgss_socials',
        array(
            'title'     => 'Social',
            'description' => ''
        )
    ));

    foreach( $socials_list as $s ) {
        $wp_customize->add_control( new WP_Customize_Control(
            $wp_customize,
            'alumnisgss_socials_link_' . $s,
            array(
                'label'      => 'Link per ' . $s,
                'description' => '',
                'settings'   => 'alumnisgss_socials_link_' . $s,
                'priority'   => 0,
                'section'    => 'alumnisgss_socials',
                'type'       => 'text',
            )
        ) );
    }
}
add_action( 'customize_register', 'alumnisgss_socials_register_option' );
