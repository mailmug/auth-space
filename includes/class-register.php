<?php

defined( 'ABSPATH' ) || exit;

class AuthSpace_Register{

    public function __construct(){
        $this->init();
    }

    public function init() {
        add_shortcode( 'authspace_login', array( __CLASS__, 'render' ) );
    }


    public static function render( $atts = array() ) {

        wp_enqueue_script( 'auth-space' );
        wp_enqueue_style( 'auth-space' );

        ob_start();
        $template = get_stylesheet_directory() . '/auth-space/register.php';

        if ( file_exists( $template ) ) {
            include $template;
        } else {
            include AUTHSPACE_ABSPATH . 'templates/register.php';
        }

        return ob_get_clean();
    }


}