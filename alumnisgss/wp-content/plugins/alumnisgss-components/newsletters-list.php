<?php
namespace alumnisgss_components_newsletters_list;

function activate () {
}

function deactivate () {
}

function register_hooks () {
    add_action('init','alumnisgss_components_newsletters_list\register_shortcode');
    add_action( 'wp_enqueue_scripts', 'alumnisgss_components_newsletters_list\enqueue_scripts' );
}

function enqueue_scripts () {
    wp_enqueue_script('jquery');
}

function register_shortcode() {
    add_shortcode( 'alumnisgss_newsletters', 'alumnisgss_components_newsletters_list\parse_shortcode' );
}

function parse_shortcode( $atts ) {
    if ( !filter_var( $atts[0], FILTER_VALIDATE_URL ) ) {
        return "L'indirizzo " . $atts[0] . " non risulta essere valido.";
    }
    return <<<HTML
        <div id="newsletter_content">Caricando...</div>
        <script type="text/javascript">
            async function test() {
                let mails = await jQuery.get( "{$atts[0]}" ); MERDA I CORS
                console.log( mails );
            }
            jQuery( window ).load( test );
        </script>
    HTML;
}