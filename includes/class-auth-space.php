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

        register_activation_hook( AUTHSPACE_FILE, [ 'AuthSpace_Plugin_Activator', 'activate' ]);

    }


    private function includes() {
        
        include_once AUTHSPACE_ABSPATH . 'includes/class-assets.php';
        include_once AUTHSPACE_ABSPATH . 'includes/class-login.php';
        include_once AUTHSPACE_ABSPATH . 'includes/class-register.php';
        include_once AUTHSPACE_ABSPATH . 'includes/class-forgot-password.php';
        include_once AUTHSPACE_ABSPATH . 'includes/class-reset-password.php';
        include_once AUTHSPACE_ABSPATH . 'includes/class-plugin-activator.php';
        include_once AUTHSPACE_ABSPATH . 'includes/class-admin-settings.php';
    }

    private function get_features() {
        return [
            AuthSpace_Login::class,
            AuthSpace_Register::class,
            AuthSpace_Assets::class,
            AuthSpace_Forgot_Password::class,
            AuthSpace_Reset_Password::class,
            AuthSpace_Admin_Settings::class,
        ];
    }


    public function init() {

        $classes = $this->get_features();

        foreach ($classes as $feature) {
            $instance = new $feature();
        }

    }
}