<?php
namespace alumnisgss_components_users;

use WP_Error;

function activate () {
    add_role(
        'alumnus',
        'Alumno',
        array(
            'read_private_posts' => true,
            'read_private_pages' => true,
        )
    );

    add_option( 'alumnisgss_components_users_mailconfirmmail', "Ciao!\nLa tua registrazione sul portale degli Alumni della Scuola Galileiana è in attesa di conferma.\nClicca # per confermare questo indirizzo mail.\nLo staff." );

    register_urls();
    flush_rewrite_rules();
}

function deactivate () {
    delete_option( 'alumnisgss_components_users_mailconfirmmail' );

}

function register_hooks () {
    add_action('init','alumnisgss_components_users\register_shortcodes');
    add_action('init','alumnisgss_components_users\register_urls');
    add_filter( 'authenticate', 'alumnisgss_components_users\authenticate',  20, 3 );
}

function register_shortcodes () {
    add_shortcode( 'alumnisgss_users_login', 'alumnisgss_components_users\login_page' );
    add_shortcode( 'alumnisgss_users_registration', 'alumnisgss_components_users\registration_page' );
}

function register_urls() {
    add_rewrite_rule(
        '^alumnisgss-components-users/([^/]+)?',
        'index.php?plugin=alumnisgss-components-users',
        'top' );
}

function login_page () {
    return "Area di login";
}

function registration_page () {
    $outcome = register_user();

    return <<<HTML
    <form method="post" action=''>
        $outcome
        <label for="thename">Nome e cognome</label>
        <input type="text" placeholder="Inserisci nome e cognome..." name="thename" id="thename" autocomplete="name" required>
        <label for="email">Email</label>
        <input type="text" placeholder="Inserisci email..." name="email" id="email" autocomplete="email" required>
        <label for="password">Password</label>
        <input type="password" placeholder="Scegli una password..." name="password" id="password" autocomplete="new-password" required>
        <label for="rpt_password">Ripeti password</label>
        <input type="password" placeholder="Ripeti password..." name="rpt_password" id="rpt_password" autocomplete="new-password" required>
        <input type="submit" value="Registrati">
    </form>
    HTML;
}

function register_user() {
    if( !array_key_exists( 'email', $_POST) ) return "";
    $email = $_POST['email'];
    if( !is_email( $email ) )
        return "<output>Email non valida.</output>";
    
    if( !array_key_exists('thename', $_POST) ) return "";
    $thename = $_POST['thename'];

    if( !array_key_exists('password', $_POST) ) return "";
    $pass = $_POST['password'];
    if( strlen($pass) < 5 )
        return "<output>La password deve avere almeno 5 caratteri.</output>";
    
    if( !array_key_exists('rpt_password', $_POST) ) return "";
    if( $pass != $_POST['rpt_password'] )
        return "<output>Le due password non coincidono.</output>";

    $user_id = wp_insert_user( array(
        'first_name'   => $thename,
        'display_name' => $thename,
        'user_login'   => $email,
        'user_email'   => $email,
        'user_pass'    => $pass,
        'role'         => 'alumnus'
    ) );
 
    if ( is_wp_error( $user_id ) ) {
        $errormessage = $user_id->get_error_message();
        return "<output>C'è stato un errore nella creazione dell'utente. $errormessage</output>";
    }

    wp_mail(
        $email,
        'Registrazione Alumni Scuola Galileiana',
        str_replace(
            '#',
            '<a href="url">qui</a>',
            get_option( 'alumnisgss_components_users_mailconfirmmail' )
        )
    );

    return "<output>Ti è stata inviata una mail di conferma.</output>";
}

function authenticate( $user, $username, $password ) {
    if( $user == NULL or is_wp_error( $user ) ) return $user;

    if( in_array( 'alumnus', $user->roles ) ) {
        $email_verified = get_user_meta( $user->ID, 'alumnisgss_email_verified', true );        
        $identity_verified = get_user_meta( $user->ID, 'alumnisgss_identity_verified', true );

        if( $email_verified != 'ok' )
            return new WP_Error( 'validation_failed', "L'indirizzo mail non risulta ancora verificato" );

        if( $identity_verified != 'ok' )
            return new WP_Error( 'validation_failed', "L'identità mail non risulta ancora verificata" );
    }
    
    return $user;    
}