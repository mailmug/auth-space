<?php

defined( 'ABSPATH' ) || exit;

class AuthSpace_Forgot_Password {

    public function __construct() {
        $this->init();
    }

    public function init() {
        add_shortcode('authspace_forgot_password', array( __CLASS__, 'render' ));
        add_action('rest_api_init', array( $this, 'register_routes' ));
    }

    public static function render( $atts = [] ) {

        wp_enqueue_script( 'auth-space' );
        wp_enqueue_style( 'auth-space' );

        ob_start();

        $template = get_stylesheet_directory() . '/auth-space/forgot-password.php';

        if ( file_exists( $template ) ) {
            include $template;
        } else {
            include AUTHSPACE_ABSPATH .
                'templates/forgot-password.php';
        }

        return ob_get_clean();
    }

    public function register_routes() {

        register_rest_route(
            'auth-space/v1',
            '/forgot-password',
            [
                'methods' => 'POST',
                'callback' => [ $this, 'forgot_password' ],
                'permission_callback' => '__return_true',
            ]
        );
    }

    public function forgot_password(
        WP_REST_Request $request
    ) {
        $email = sanitize_text_field(
            $request->get_param( 'email' )
        );

        if ( empty( $email ) ) {
            return [
                'success' => false,
                'message' => __( 'Email is required.', 'auth-space'),
            ];
        }

        $user = false;

        if ( is_email( $email ) ) {
            $user = get_user_by( 'email', $email );
        } 

        if ( ! $user ) {
            return [
                'success' => false,
                'message' => __( 'User not found.', 'auth-space'),
            ];
        }

        $key = get_password_reset_key( $user );

        if ( is_wp_error( $key ) ) {
            return [
                'success' => false,
                'message' => $key->get_error_message(),
            ];
        }

        $reset_url = apply_filters('auth_space_reset_password_url', home_url( '/reset-password/' ));
        $url = add_query_arg(
            [
                'action' => 'rp',
                'key'    => $key,
                'login'  => rawurlencode(
                    $user->user_login
                ),
            ],
            $reset_url 
        );

        wp_mail(
            $user->user_email,
            __( 'Password Reset', 'auth-space' ),
            sprintf(
                /* translators: %s: Password reset URL. */
                __(
                    'Click here to reset your password: %s',
                    'auth-space'
                ),
                $url
            )
        );

        do_action('auth_space_after_password_reset_email', $user->ID, $url);

        return [
            'success' => true,
            'message' => __('Please check your email for a password reset link.', 'auth-space'),
        ];
    }
 
}