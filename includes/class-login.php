<?php

defined( 'ABSPATH' ) || exit;

class AuthSpace_Login {

    public function __construct() {
        $this->init();
    }

    public function init() {
        add_shortcode( 'authspace_login', [ __CLASS__, 'render' ] );
        add_action( 'rest_api_init', [ $this, 'register_routes' ] );
    }

    public static function render( $atts = [] ) {

        wp_enqueue_script( 'auth-space' );
        wp_enqueue_style( 'auth-space' );

        ob_start();

        $template = get_stylesheet_directory() . '/auth-space/login.php';

        if ( file_exists( $template ) ) {
            include $template;
        } else {
            include AUTHSPACE_ABSPATH . 'templates/login.php';
        }

        return ob_get_clean();
    }

    public function register_routes() {
        register_rest_route(
            'auth-space/v1',
            '/login',
            [
                'methods'             => 'POST',
                'callback'            => [ $this, 'login_user' ],
                'permission_callback' => '__return_true',
            ]
        );
    }

    public function login_user( WP_REST_Request $request ) {

        $username = sanitize_text_field( $request->get_param( 'username' ));
        $password = (string) $request->get_param( 'password' );
        $remember = (bool) $request->get_param( 'remember' );

        $errors = [];

        if ( empty( $username ) ) {
            $errors['username'] = __( 'Username or email is required.', 'auth-space' );
        }

        if ( empty( $password ) ) {
            $errors['password'] = __( 'Password is required.', 'auth-space' );
        }

        if ( ! empty( $errors ) ) {
            return new WP_REST_Response(
                [
                    'success' => false,
                    'errors'  => $errors,
                ]
            );
        }

        // Allow login via email.
        if ( is_email( $username ) ) {
            $user = get_user_by( 'email', $username );

            if ( $user ) {
                $username = $user->user_login;
            }
        }

        do_action( 'auth_space_before_login', $username );

        $credentials = [
            'user_login'    => $username,
            'user_password' => $password,
            'remember'      => $remember,
        ];

        $user = wp_signon( $credentials, is_ssl() );

        if ( is_wp_error( $user ) ) {
            return new WP_REST_Response(
                [
                    'success' => false,
                    'message' => __( 'Invalid username or password.', 'auth-space' ),
                ],
            );
        }

        do_action( 'auth_space_after_login', $user->ID, $user );

        return new WP_REST_Response(
            [
                'success'  => true,
                'message'  => __( 'Login successful.', 'auth-space' ),
                'redirect' => home_url(),
                'user_id'  => $user->ID,
            ]
        );
    }
}