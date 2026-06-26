<?php

defined( 'ABSPATH' ) || exit;

class AuthSpace {

    protected static $instance = null;

    public static function instance() {

        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    private function __construct() {

        $this->includes();

        add_action( 'init', array( $this, 'init' ) );
    }


    private function includes() {
    
        include_once AUTHSPACE_ABSPATH . 'includes/class-login.php';
        include_once AUTHSPACE_ABSPATH . 'includes/class-register.php';
        include_once AUTHSPACE_ABSPATH . 'includes/class-assets.php';

    }

    private function get_features() {
        return [
            AuthSpace_Login::class,
            AuthSpace_Register::class,
            AuthSpace_Assets::class,
        ];
    }


    public function init() {

        $classes = $this->get_features();

        foreach ($classes as $feature) {
            $instance = new $feature();
        }

    }
}