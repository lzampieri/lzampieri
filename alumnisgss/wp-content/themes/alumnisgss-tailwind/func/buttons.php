<?php

function alumnisgss_buttons_option ( $wp_customize ) {
    $wp_customize->add_setting(
        'alumnisgss_buttons_placeholder',
        array(
            'default' => '',
            'type' => 'option', // you can also use 'theme_mod'
            'capability' => 'edit_theme_options'
        ),
    );

    $wp_customize->add_control( new WP_Customize_Control(
        $wp_customize,
        'alumnisgss_buttons_infobox',
        array(
            'label'      => 'Pulsanti',
            'description' => 'Ricorda che puoi usare gli shortcode <code>[button href="..." title="..."]</code>, <code>[button-left href="..." title="..."]</code> e <code>[button-right href="..." title="..."]</code> per inserire pulsanti in articoli e sezioni.',
            'settings'   => 'alumnisgss_buttons_placeholder',
            'priority'   => 0,
            'section'    => 'title_tagline',
            'type'       => 'hidden',
        )
    ) );
}
add_action( 'customize_register', 'alumnisgss_buttons_option' );

function alumnisgss_buttons_register_shortcodes( ) {
    add_shortcode( 'button' , 'alumnisgss_buttons_button' );
    add_shortcode( 'button-left' , 'alumnisgss_buttons_button_left' );
    add_shortcode( 'button-right' , 'alumnisgss_buttons_button_right' );
}
add_action( 'init', 'alumnisgss_buttons_register_shortcodes' );

function alumnisgss_buttons_button( $attr ) {
    $btn = alumnisgss_buttons_thebutton( $attr );
    return <<<HTML
        <div class="w-full text-center py-4">$btn</div>
    HTML;
}

function alumnisgss_buttons_button_left( $attr ) {
    $btn = alumnisgss_buttons_thebutton( $attr );
    return <<<HTML
        <div class="w-full text-left py-4">$btn</div>
    HTML;
}

function alumnisgss_buttons_button_right( $attr ) {
    $btn = alumnisgss_buttons_thebutton( $attr );
    return <<<HTML
        <div class="w-full text-right py-4">$btn</div>
    HTML;
}

function alumnisgss_buttons_thebutton( $attr ) {
    $args = shortcode_atts( array(
        'href' => '#',
        'title' => 'Vai'
    ), $attr );
    return <<<HTML
        <a href="{$args['href']}" class="button">{$args['title']}</a>
    HTML;
}