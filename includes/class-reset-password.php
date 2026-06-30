<?php

defined( 'ABSPATH' ) || exit;

class AuthSpace_Reset_Password {

    public function __construct() {
        $this->init();
    }

    public function init() {
        add_shortcode( 'authspace_reset_password', [ __CLASS__, 'render' ]);
        add_action( 'rest_api_init', [ $this, 'register_routes' ]);
    }

    public static function render( $atts = [] ) {

        // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Password reset token is validated      
        $login = isset( $_GET['login'] ) ? sanitize_text_field( wp_unslash( $_GET['login'] ) ) : '';
        
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended      
        $key   = isset( $_GET['key'] ) ? sanitize_text_field( wp_unslash( $_GET['key'] ) ) : '';

        if ( empty( $login ) || empty( $key ) ) {
            wp_safe_redirect( home_url( '/reset-password' ) );
            exit;
        }
      
        wp_enqueue_script( 'auth-space' );
        wp_enqueue_style( 'auth-space' );

        ob_start();

        $template = get_stylesheet_directory() . '/auth-space/reset-password.php';

        if ( file_exists( $template ) ) {
            include $template;
        } else {
            include AUTHSPACE_ABSPATH . 'templates/reset-password.php';
        }

        return ob_get_clean();
    }

    public function register_routes() {
        register_rest_route(
            'auth-space/v1',
            '/reset-password',
            [
                'methods'  => 'POST',
                'callback' => [ $this, 'reset_password' ],
                'permission_callback' => '__return_true',
            ]
        );
    }


    public function reset_password( WP_REST_Request $request) {
        
        $login    = sanitize_text_field( $request->get_param( 'login' ));
        $key      = sanitize_text_field( $request->get_param( 'key' ));
        $password = $request->get_param( 'password');

        $user = check_password_reset_key( $key, $login );

        if ( is_wp_error( $user ) ) {
            return [
                'success' => false,
                'message' => __(
                    'The password reset link is invalid or has expired.',
                    'auth-space'
                ),
            ];
        }

        if ( strlen( $password ) < 6 ) {
            return [
                'success'   => false,
                'message' => __('Password must be at least 6 characters.', 'auth-space'),
            ];
        }

        reset_password( $user, $password );

        return [
            'success' => true,
            'message' => __(
                'Your password has been reset successfully.',
                'auth-space'
            ),
        ];
    }
}