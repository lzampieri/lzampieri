<?php
require_once( 'ASGSSR_Users.php' );
require_once( 'ASGSSR_PagesRights.php' );

class ASGSSR {

    public $user_manager;
    public $pages_manager;

    public function __construct()
    {
        add_filter( 'wp_list_pages', [$this, 'pages_list_filter' ], 10, 3 );
        $this->user_manager = new ASGSSR_Users();
        $this->pages_manager = new ASGSSR_PagesRights();
    }

    public static function activate() {
        ASGSSR_Users::activate();
    }

    public static function deactivate() {
        ASGSSR_Users::deactivate();
    }

    public static function unistall() {

    }

    public function pages_list_filter( $output, $r, $pages ) {
        // Implementare la filtrazione della lista delle pagine 
        // Vedere anche wp_list_pages_excludes
        return $output;
    }
}