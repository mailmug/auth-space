<?php

defined( 'ABSPATH' ) || exit;

class AuthSpace_Register{

    public function __construct(){
        $this->init();
    }

    public function init() {
        add_shortcode( 'authspace_login', array( __CLASS__, 'render' ) );
        add_action( 'rest_api_init', [ $this, 'register_routes' ] );
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

    public function register_routes() {
        register_rest_route(
            'auth-space/v1',
            '/register/validate',
            [
                'methods'             => 'POST',
                'callback'            => [ $this, 'validate' ],
                'permission_callback' => '__return_true',
            ]
        );
    }

    public function validate( WP_REST_Request $request ) {
        $field = sanitize_key( $request->get_param( 'field' ) );
        $value = $request->get_param( 'value' );

        switch ( $field ) {
            case 'username':
                $value = sanitize_user( $value );

                if ( strlen( $value ) < 3 ) {
                    return [
                        'valid'   => false,
                        'message' => 'Username must be at least 3 characters.',
                    ];
                }

                if ( username_exists( $value ) ) {
                    return [
                        'valid'   => false,
                        'message' => 'Username already exists.',
                    ];
                }

                break;

            case 'email':
                $value = sanitize_email( $value );

                if ( ! is_email( $value ) ) {
                    return [
                        'valid'   => false,
                        'message' => 'Invalid email address.',
                    ];
                }

                if ( email_exists( $value ) ) {
                    return [
                        'valid'   => false,
                        'message' => 'Email already exists.',
                    ];
                }

                break;

            case 'password':
                if ( strlen( $value ) < 6 ) {
                    return [
                        'valid'   => false,
                        'message' => 'Password must be at least 6 characters.',
                    ];
                }

                break;

            case 'confirm_password':
                $password = $request->get_param( 'password' );
                $confirm_password = $request->get_param( 'confirm_password' );

                if ( $confirm_password !== $password ) {
                    return [
                        'valid'   => false,
                        'message' => 'Passwords do not match.',
                    ];
                }

                break;

            default:
                return new WP_Error(
                    'invalid_field',
                    'Invalid field.',
                    [ 'status' => 400 ]
                );
        }

        return [
            'valid'   => true,
            'message' => '',
        ];
    }


}