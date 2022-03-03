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
    add_option( 'alumnisgss_components_users_adminconfirmmail', "Ciao!\nLa registrazione di % (@) sul portale degli Alumni della Scuola Galileiana è in attesa di conferma.\nClicca # per confermare questo indirizzo mail.\nLo staff." );
    add_option( 'alumnisgss_components_users_useradminemail', "leo.nick98t@gmail.com" );

    register_urls();
    flush_rewrite_rules();
}

function deactivate () {
    delete_option( 'alumnisgss_components_users_mailconfirmmail' );
    delete_option( 'alumnisgss_components_users_adminconfirmmail' );
    delete_option( 'alumnisgss_components_users_useradminemail' );
}

function register_hooks () {
    add_action( 'admin_menu', 'alumnisgss_components_users\add_admin_page' );

    add_action('init','alumnisgss_components_users\register_shortcodes');
    add_action('init','alumnisgss_components_users\register_urls');
    add_filter( 'authenticate', 'alumnisgss_components_users\authenticate',  20, 3 );


    add_action('template_redirect','alumnisgss_components_users\login_query');
    add_action('template_redirect','alumnisgss_components_users\register_query');
    add_action('template_redirect','alumnisgss_components_users\logout_query');
    
    add_action('template_redirect','alumnisgss_components_users\verify_mail');
    add_action('template_redirect','alumnisgss_components_users\verify_identity');
    add_filter( 'query_vars', 'alumnisgss_components_users\register_query_vars' );
}

function register_shortcodes () {
    add_shortcode( 'alumnisgss_users_login', 'alumnisgss_components_users\login_page' );
    add_shortcode( 'alumnisgss_users_registration', 'alumnisgss_components_users\registration_page' );
    add_shortcode( 'alumnisgss_users_logout', 'alumnisgss_components_users\logout_page' );
}

function register_urls() {
    add_rewrite_rule(
        '^alumnisgss_components_users/verify_email/(\d+)$',
        'index.php?plugin=alumnisgss_components_users&action=verify-mail&uid=$matches[1]',
        'top' );
    
    add_rewrite_rule(
        '^alumnisgss_components_users/verify_identity/(\d+)$',
        'index.php?plugin=alumnisgss_components_users&action=verify-identity&uid=$matches[1]',
        'top' );
}

$reg_output = "";

function registration_page () {
    global $reg_output;
    return <<<HTML
    <form method="post" action='' enctype="multipart/form-data">
        $reg_output
        <label for="reg_thename">Nome e cognome</label>
        <input type="text" placeholder="Inserisci nome e cognome..." name="reg_thename" id="reg_thename" autocomplete="name" required>
        <label for="reg_email">Email</label>
        <input type="text" placeholder="Inserisci email..." name="reg_email" id="reg_email" autocomplete="email" required>
        <label for="reg_password">Password</label>
        <input type="password" placeholder="Scegli una password..." name="reg_password" id="reg_password" autocomplete="new-password" required>
        <label for="reg_rpt_password">Ripeti password</label>
        <input type="password" placeholder="Ripeti password..." name="reg_rpt_password" id="reg_rpt_password" autocomplete="new-password" required>
        <label for="reg_document">Documento d'identità</label>
        <input type="file" placeholder="Scegli un file pdf, jpg, png, gif o eps" name="reg_document" id="reg_document" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps" required>
        <input type="submit" value="Registrati">
    </form>
    HTML;
}

function register_query() {
    global $reg_output;

    if( !array_key_exists( 'reg_email', $_POST) ) return;
    $email = $_POST['reg_email'];
    if( !is_email( $email ) ) {
        $reg_output = "<output>Email non valida.</output>";
        return;
    }
    
    if( !array_key_exists('reg_thename', $_POST) ) return;
    $thename = $_POST['reg_thename'];

    if( !array_key_exists('reg_password', $_POST) ) return;
    $pass = $_POST['reg_password'];
    if( strlen($pass) < 5 ) {
        $reg_output = "<output>La password deve avere almeno 5 caratteri.</output>";
    }
    
    if( !array_key_exists('reg_rpt_password', $_POST) ) return;
    if( $pass != $_POST['reg_rpt_password'] ) {
        $reg_output = "<output>Le due password non coincidono.</output>";
        return;
    }

    if( !array_key_exists('reg_document',$_FILES) ) return;
    if( empty( $_FILES['reg_document']['name'] ) ) return;
    $allowTypes = array('pdf', 'jpg', 'png', 'gif', 'eps');
    if( !in_array( pathinfo( strtolower($_FILES['reg_document']['name']), PATHINFO_EXTENSION ), $allowTypes ) ) {
        $reg_output = "<output>Il tipo di file caricato non è permesso.</output>";
        return;
    }
    $document = dirname($_FILES['reg_document']['tmp_name']) . '/' . $_FILES['reg_document']['name'];
    $moved = move_uploaded_file( $_FILES['reg_document']['tmp_name'], $document );
    if( !$moved ) {
        $reg_output = "<output>C'è stato un problema nel caricamento del file. Per cortesia, riprova.</output>";
        return;
    }

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
        $reg_output = "<output>C'è stato un errore nella creazione dell'utente. $errormessage</output>";
        return;
    }

    wp_mail(
        $email,
        'Registrazione Alumni Scuola Galileiana',
        str_replace(
            '#',
            '<a href="' . get_site_url( null, '/alumnisgss_components_users/verify_email/' ) . $user_id . '">qui</a>',
            get_option( 'alumnisgss_components_users_mailconfirmmail' )
        ),
        array('Content-type: text/html','From: ' . get_option( 'alumnisgss_components_users_useradminemail' ) )
    );
    
    wp_mail(
        get_option( 'alumnisgss_components_users_useradminemail' ),
        'Registrazione Alumni Scuola Galileiana',
        str_replace(
            '#',
            '<a href="' . get_site_url( null, '/alumnisgss_components_users/verify_identity/' ) . $user_id . '">qui</a>',
        str_replace(
            '@',
            $email,
        str_replace(
            '%',
            $thename,
            get_option( 'alumnisgss_components_users_adminconfirmmail' )
        ),
        ),
        ),
        array('Content-type: text/html','From: ' . get_option( 'alumnisgss_components_users_useradminemail' ) ),
        $document
    );

    $reg_output = "<output>Ti è stata inviata una mail di conferma.</output>";
}

$log_output = "";

function login_page () {
    global $log_output;
    return <<<HTML
    <form method="post" action=''>
        $log_output
        <label for="lgn_email">Email</label>
        <input type="text" placeholder="Inserisci email..." name="lgn_email" id="lgn_email" autocomplete="email" required />
        <label for="lgn_password">Password</label>
        <input type="password" placeholder="Inserisci la password..." name="lgn_password" id="lgn_password" autocomplete="current-password" required />
        <label for="lgn_remember">Ricordami</label>
        <input type="checkbox" placeholder="Inserisci la password..." name="lgn_remember" id="lgn_remember" />
        <input type="submit" value="Login" />
    </form>
    HTML;
}

function login_query () {
    global $log_output;

    if( !array_key_exists( 'lgn_email', $_POST) ) return;
    if( !array_key_exists( 'lgn_password', $_POST) ) return;

    $output = wp_signon( array(
        'user_login'    => $_POST['lgn_email'],
        'user_password' => $_POST['lgn_password'],
        'remember'      => array_key_exists( 'lgn_remember', $_POST) && $_POST['lgn_remember'] == 'on'
    ));

    if ( is_wp_error( $output ) ) {
        $message = $output->get_error_message();
        $log_output = "<output>Errore di login. $message.</output>";
        return;
    }

    wp_redirect( get_home_url() );
    exit();
}

function logout_page () {
    return <<<HTML
    <form method="post" action=''>
        <input type="hidden" name="lgo_hidden" id="lgo_hidden" value="logout" />
        <input type="submit" value="Logout" />
    </form>
    HTML;
}

function logout_query () {
    if( !array_key_exists( 'lgo_hidden', $_POST) ) return;
    if( !( $_POST['lgo_hidden'] == 'logout' ) ) return;

    wp_logout();
    wp_redirect( get_home_url() );
}

function authenticate( $user, $username, $password ) {
    if( $user == NULL or is_wp_error( $user ) ) return $user;

    if( in_array( 'alumnus', $user->roles ) ) {
        $email_verified = get_user_meta( $user->ID, 'alumnisgss_email_verified', true );        
        $identity_verified = get_user_meta( $user->ID, 'alumnisgss_identity_verified', true );

        if( $email_verified != 'ok' )
            return new WP_Error( 'validation_failed', "L'indirizzo mail non risulta ancora verificato" );

        if( $identity_verified != 'ok' )
            return new WP_Error( 'validation_failed', "L'identità non risulta ancora verificata. Attendi verifica da parte della segreteria." );
    }
    
    return $user;    
}

function register_query_vars ( $vars ) {
    $vars[] = "plugin";
    $vars[] = "action";
    $vars[] = "uid";
    return $vars;    
}

function verify_mail () {
    if( get_query_var('plugin') != 'alumnisgss_components_users' ) return;
    if( get_query_var('action') != 'verify-mail' ) return;
    
    update_user_meta( get_query_var('uid'), 'alumnisgss_email_verified', 'ok' );   

    wp_register_script( 'dummy-handle-footer', '', [], '', true );
    wp_enqueue_script( 'dummy-handle-footer'  );
    wp_add_inline_script( 'dummy-handle-footer', 'alert("Email verificata");' );
    
}

function verify_identity () {
    if( get_query_var('plugin') != 'alumnisgss_components_users' ) return;
    if( get_query_var('action') != 'verify-identity' ) return;
        
    if( !current_user_can('promote_users') ) {
        if( is_user_logged_in() ) {
            wp_logout();
        }
        auth_redirect();
    }
    
    update_user_meta( get_query_var('uid'), 'alumnisgss_identity_verified', 'ok' );
    
    wp_register_script( 'dummy-handle-footer', '', [], '', true );
    wp_enqueue_script( 'dummy-handle-footer'  );
    wp_add_inline_script( 'dummy-handle-footer', 'alert("Identità verificata");' );
}

function add_admin_page() {
    add_submenu_page(
        'alumnisgss_components_admin',
        'Opzioni degli utenti',
        'Utenti',
        'manage_options',
        'users',
        'alumnisgss_components_users\admin_page_content'
    );
}

function admin_page_content() {

?>
    <h1>Todo</h1>
<?php

}