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

    add_option( 'alumnisgss_components_users_mailconfirmmail_subject', "Registrazione Alumni Scuola Galileiana" );
    add_option( 'alumnisgss_components_users_mailconfirmmail_text', "Ciao!\nLa tua registrazione sul portale degli Alumni della Scuola Galileiana è in attesa di conferma.\nClicca # per confermare questo indirizzo mail.\nLo staff." );
    add_option( 'alumnisgss_components_users_adminconfirmmail_subject', "Registrazione Alumni Scuola Galileiana - Conferma identità" );
    add_option( 'alumnisgss_components_users_adminconfirmmail_text', "Ciao!\nLa registrazione di % (@) sul portale degli Alumni della Scuola Galileiana è in attesa di conferma.\nClicca # per confermare l'identità, dopo aver verificato il documento allegato.\nLo staff." );
    add_option( 'alumnisgss_components_users_useradminemail', "leo.nick98t@gmail.com" );

    register_urls();
    flush_rewrite_rules();
}

function deactivate () {
    delete_option( 'alumnisgss_components_users_mailconfirmmail_subject' );
    delete_option( 'alumnisgss_components_users_mailconfirmmail_text' );
    delete_option( 'alumnisgss_components_users_adminconfirmmail_subject' );
    delete_option( 'alumnisgss_components_users_adminconfirmmail_text' );
    delete_option( 'alumnisgss_components_users_useradminemail' );
}

function register_hooks () {
    add_action( 'admin_menu', 'alumnisgss_components_users\add_admin_page' );

    add_action('init','alumnisgss_components_users\register_shortcodes');
    add_action('init','alumnisgss_components_users\register_urls');
    add_action('init','alumnisgss_components_users\register_css');
    add_filter( 'authenticate', 'alumnisgss_components_users\authenticate',  20, 3 );


    add_action('template_redirect','alumnisgss_components_users\login_query');
    add_action('template_redirect','alumnisgss_components_users\register_query');
    add_action('template_redirect','alumnisgss_components_users\logout_query');
    
    add_action('template_redirect','alumnisgss_components_users\verify_mail');
    add_action('template_redirect','alumnisgss_components_users\verify_identity');
    add_filter( 'query_vars', 'alumnisgss_components_users\register_query_vars' );
    
    add_action('admin_init','alumnisgss_components_users\verify_mail');
    add_action('admin_init','alumnisgss_components_users\verify_identity');
    add_action('admin_init','alumnisgss_components_users\deverify_mail');
    add_action('admin_init','alumnisgss_components_users\deverify_identity');
    add_action('admin_init','alumnisgss_components_users\resend_verification_mail');

    add_filter( 'manage_users_columns', 'alumnisgss_components_users\add_registration_column' );
    add_filter( 'manage_users_custom_column', 'alumnisgss_components_users\get_registration_column', 10, 3 );
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

function register_css() {
    wp_register_style( 'dummy-handle-style', false );
    wp_enqueue_style( 'dummy-handle-style' );
    wp_add_inline_style( 'dummy-handle-style', <<<HTML
        .alumnisgss-components-bullet {
            display: inline-block!important;
            width: 1em!important;
            height: 1em!important;
            border-radius: 50%!important;
        }
        .alumnisgss-components-bullet.ok {
            background-color: #7ad03a
        }
        .alumnisgss-components-bullet.not {
            background-color: #dc3232
        }
    HTML);

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
        get_option( 'alumnisgss_components_users_mailconfirmmail_subject' ),
        str_replace(
            '#',
            '<a href="' . get_site_url( null, '/alumnisgss_components_users/verify_email/' ) . $user_id . '">qui</a>',
        str_replace(
            '@',
            $email,
        str_replace(
            '%',
            $thename,
            stripslashes( get_option( 'alumnisgss_components_users_mailconfirmmail_text' ) )
        ),
        ),
        ),
        array('Content-type: text/html','From: ' . get_option( 'alumnisgss_components_users_useradminemail' ) ),
        $document
    );

    wp_mail(
        get_option( 'alumnisgss_components_users_useradminemail' ),
        get_option( 'alumnisgss_components_users_adminconfirmmail_subject' ),
        str_replace(
            '#',
            '<a href="' . get_site_url( null, '/alumnisgss_components_users/verify_identity/' ) . $user_id . '">qui</a>',
        str_replace(
            '@',
            $email,
        str_replace(
            '%',
            $thename,
            stripslashes( get_option( 'alumnisgss_components_users_adminconfirmmail_text' ) )
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

function get_or_queryvar( $key ) {
    if( array_key_exists( $key, $_GET ) )
        return $_GET[$key];
    return get_query_var( $key );
}

function verify_mail () {
    if( get_or_queryvar('plugin') != 'alumnisgss_components_users' ) return;
    if( get_or_queryvar('action') != 'verify-mail' ) return;
    
    update_user_meta( get_or_queryvar('uid'), 'alumnisgss_email_verified', 'ok' );  
    
    if( is_admin() ) return;
    wp_register_script( 'dummy-handle-footer', '', [], '', true );
    wp_enqueue_script( 'dummy-handle-footer'  );
    wp_add_inline_script( 'dummy-handle-footer', 'alert("Email verificata");' );
    
}

function verify_identity () {
    if( get_or_queryvar('plugin') != 'alumnisgss_components_users' ) return;
    if( get_or_queryvar('action') != 'verify-identity' ) return;
        
    if( !current_user_can('promote_users') ) {
        if( is_user_logged_in() ) {
            wp_logout();
        }
        auth_redirect();
    }
    
    update_user_meta( get_or_queryvar('uid'), 'alumnisgss_identity_verified', 'ok' );
    
    if( is_admin() ) return;
    wp_register_script( 'dummy-handle-footer', '', [], '', true );
    wp_enqueue_script( 'dummy-handle-footer'  );
    wp_add_inline_script( 'dummy-handle-footer', 'alert("Identità verificata");' );
}

function deverify_mail () {
    if( get_or_queryvar('plugin') != 'alumnisgss_components_users' ) return;
    if( get_or_queryvar('action') != 'deverify-mail' ) return;
    
    update_user_meta( get_or_queryvar('uid'), 'alumnisgss_email_verified', 'no' ); 
    
    if( is_admin() ) return;
    wp_register_script( 'dummy-handle-footer', '', [], '', true );
    wp_enqueue_script( 'dummy-handle-footer'  );
    wp_add_inline_script( 'dummy-handle-footer', 'alert("Verifica della mail annullata");' );
    
}

function deverify_identity () {
    if( get_or_queryvar('plugin') != 'alumnisgss_components_users' ) return;
    if( get_or_queryvar('action') != 'deverify-identity' ) return;
        
    if( !current_user_can('promote_users') ) {
        if( is_user_logged_in() ) {
            wp_logout();
        }
        auth_redirect();
    }
    
    update_user_meta( get_or_queryvar('uid'), 'alumnisgss_identity_verified', 'no' );
    
    if( is_admin() ) return;
    wp_register_script( 'dummy-handle-footer', '', [], '', true );
    wp_enqueue_script( 'dummy-handle-footer'  );
    wp_add_inline_script( 'dummy-handle-footer', 'alert("Verifica dell\'identità annullata");' );
}

function resend_verification_mail( ) {
    if( get_or_queryvar('plugin') != 'alumnisgss_components_users' ) return;
    if( get_or_queryvar('action') != 'resend-verification-mail' ) return;
    
    $uid = get_or_queryvar('uid');
    $userdata = get_userdata( $uid );
    $email = $userdata->user_email;
    $thename = $userdata->display_name;
    wp_mail(
        $email,
        get_option( 'alumnisgss_components_users_mailconfirmmail_subject' ),
        str_replace(
            '#',
            '<a href="' . get_site_url( null, '/alumnisgss_components_users/verify_email/' ) . $uid . '">qui</a>',
        str_replace(
            '@',
            $email,
        str_replace(
            '%',
            $thename,
            stripslashes( get_option( 'alumnisgss_components_users_mailconfirmmail_text' ) )
        ),
        ),
        ),
        array('Content-type: text/html','From: ' . get_option( 'alumnisgss_components_users_useradminemail' ) )
    );
        
    if( is_admin() ) return;
    wp_register_script( 'dummy-handle-footer', '', [], '', true );
    wp_enqueue_script( 'dummy-handle-footer'  );
    wp_add_inline_script( 'dummy-handle-footer', 'alert("Mail ri-mandata");' );
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
    if( array_key_exists('useradminmail',$_POST) )
        update_option( 'alumnisgss_components_users_useradminemail', $_POST['useradminmail'] );

    if( array_key_exists('mailconfirmmail_subject',$_POST) )
        update_option( 'alumnisgss_components_users_mailconfirmmail_subject', $_POST['mailconfirmmail_subject'] );

    if( array_key_exists('mailconfirmmail_text',$_POST) )
        update_option( 'alumnisgss_components_users_mailconfirmmail_text', $_POST['mailconfirmmail_text'] );

    if( array_key_exists('adminconfirmmail_subject',$_POST) )
        update_option( 'alumnisgss_components_users_adminconfirmmail_subject', $_POST['adminconfirmmail_subject'] );

    if( array_key_exists('adminconfirmmail_text',$_POST) )
        update_option( 'alumnisgss_components_users_adminconfirmmail_text', $_POST['adminconfirmmail_text'] );
?>
    <h1>Shortcode disponibili:</h1>

    <code>[alumnisgss_users_login]</code>

    <code>[alumnisgss_users_registration]</code>

    <code>[alumnisgss_users_logout]</code>

    <h2>Per la gestione diretta degli utenti, si veda <a href="users.php">la sezione dedicata</a></h2>

    <h2>Gestione delle opzioni</h2>

    <form action="" method="POST">
        <label for="useradminmail">Indirizzo mail amministratore</label><br/>
        <input type="text" value="<?php echo get_option( 'alumnisgss_components_users_useradminemail' ); ?>" name="useradminmail" id="useradminmail" style="width: 60%" /><br/>
        <small>Questa mail apparirà come mittente in tutte le mail automatiche.</small><br/>
        <br/>
        <label for="mailconfirmmail_subject">Oggetto e testo email per conferma indirizzo mail</label><br/>
        <input type="text" value="<?php echo get_option( 'alumnisgss_components_users_mailconfirmmail_subject' ); ?>" name="mailconfirmmail_subject" id="mailconfirmmail_subject" style="width: 60%" /><br/>
        <textarea id="mailconfirmmail_text" name="mailconfirmmail_text" rows="10" style="width: 60%" ><?php echo stripslashes( get_option( 'alumnisgss_components_users_mailconfirmmail_text' ) ); ?></textarea><br/>
        <small>Il simbolo <code>#</code> verrà sostituito dal link per la conferma, il simbolo <code>%</code> dal nome dell'utente appena registrato e il simbolo <code>@</code> dal suo indirizzo mail. Questa mail sarà inviata all'indirizzo dell'utente.</small><br/>
        <br />
        <label for="adminconfirmmail">Oggetto e testo email per conferma identità</label><br/>
        <input type="text" value="<?php echo get_option( 'alumnisgss_components_users_adminconfirmmail_subject' ); ?>" name="adminconfirmmail_subject" id="adminconfirmmail_subject" style="width: 60%" /><br/>
        <textarea id="adminconfirmmail_text" name="adminconfirmmail_text" rows="10" style="width: 60%" ><?php echo stripslashes( get_option( 'alumnisgss_components_users_adminconfirmmail_text' ) ); ?></textarea><br/>
        <small>Il simbolo <code>#</code> verrà sostituito dal link per la conferma, il simbolo <code>%</code> dal nome dell'utente appena registrato e il simbolo <code>@</code> dal suo indirizzo mail. Questa mail sarà inviata all'indirizzo dell'amministratore.</small><br/>
        <br/>
        <input type="submit" value="Salva" />
    </form>
<?php

}

function add_registration_column( $columns ) {
    $columns['verifications'] = 'Verifiche';
    return $columns;
}

function get_registration_column( $val, $column_name, $user_id ) {
    if( $column_name == 'verifications' ) {
        if( in_array( 'alumnus', get_userdata($user_id)->roles ) ) {
            $email_verified = get_user_meta( $user_id, 'alumnisgss_email_verified', true ) == 'ok' ? 'ok' : 'not';        
            $identity_verified = get_user_meta( $user_id, 'alumnisgss_identity_verified', true ) == 'ok' ? 'ok' : 'not';

            $email_link = 
                $email_verified == 'ok' ? 
                "users.php?plugin=alumnisgss_components_users&action=deverify-mail&uid=$user_id" :
                "users.php?plugin=alumnisgss_components_users&action=verify-mail&uid=$user_id";
            $resend_email_link = 
                $email_verified == 'ok' ? 
                '' :
                "<br/><br/><a href=\"users.php?plugin=alumnisgss_components_users&action=resend-verification-mail&uid=$user_id\">Rimanda mail di verifica</a>";
            $identity_link = 
                $identity_verified == 'ok' ? 
                "users.php?plugin=alumnisgss_components_users&action=deverify-identity&uid=$user_id" :
                "users.php?plugin=alumnisgss_components_users&action=verify-identity&uid=$user_id";

            $val  = "Email: <span class=\"alumnisgss-components-bullet $email_verified\"></span> ";
            $val .= "<a href=\"$email_link\">Cambia</a>";
            $val .= "<br/>";
            $val .= "Identità: <span class=\"alumnisgss-components-bullet $identity_verified\"></span> ";
            $val .= "<a href=\"$identity_link\">Cambia</a>";
            $val .= $resend_email_link;
        }
    }
    return $val;
}
add_filter( 'manage_users_columns', 'alumnisgss_components_users\add_registration_column' );
add_filter( 'manage_users_custom_column', 'alumnisgss_components_users\get_registration_column', 10, 3 );
