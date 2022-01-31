<?php
class ASGSSR_Users {

    public function __construct()
    {
        add_action( 'profile_update', [$this, 'create_user_info'] );
    }

    public static function activate() {
        add_role( 'ordinary', 'Socio', array( 'read' => true ) );
        add_role( 'reserved', 'Socio con accesso alle pagine riservate', array( 'read' => true, 'read_reserved' => true ) );
        update_option('default_role', 'ordinary');
    }

    public static function deactivate() {
        remove_role( 'ordinary' );
        remove_role( 'reserved' );
        update_option('default_role', 'subscriber');
    }

    public function create_user_info( $user_id ) {
        update_user_meta( $user_id, 'ASGSSR_email_confirmed', false );
        update_user_meta( $user_id, 'ASGSSR_identity_confirmed', false );
    }

}