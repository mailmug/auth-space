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

        register_rest_route(
            'auth-space/v1',
            '/register',
            [
                'methods'             => 'POST',
                'callback'            => [ $this, 'register_user' ],
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


    public function register_user( WP_REST_Request $request ) {

        $username = sanitize_user( $request->get_param('username') );
        $email    = sanitize_email( $request->get_param('email') );
        $password = (string) $request->get_param('password');

        $errors = [];

        // Username validation
        if ( empty($username) ) {
            $errors['username'] = 'Username is required.';
        } elseif ( strlen($username) < 3 ) {
            $errors['username'] = 'Username must be at least 3 characters.';
        } elseif ( username_exists($username) ) {
            $errors['username'] = 'Username already exists.';
        }

        // Email validation
        if ( empty($email) ) {
            $errors['email'] = 'Email is required.';
        } elseif ( ! is_email($email) ) {
            $errors['email'] = 'Invalid email address.';
        } elseif ( email_exists($email) ) {
            $errors['email'] = 'Email already exists.';
        }

        // Password validation
        if ( empty($password) ) {
            $errors['password'] = 'Password is required.';
        } elseif ( strlen($password) < 6 ) {
            $errors['password'] = 'Password must be at least 6 characters.';
        }

        // If errors exist, return early
        if ( ! empty($errors) ) {
            return new WP_REST_Response([
                'success' => false,
                'errors'  => $errors,
            ]);
        }

        // Create user
        $user_id = wp_create_user($username, $password, $email);

        if ( is_wp_error($user_id) ) {
            return new WP_REST_Response([
                'success' => false,
                'message' => $user_id->get_error_message(),
            ], 400);
        }

        return [
            'success'  => true,
            'message'  => 'Account created successfully.',
            'redirect' => home_url(),
        ];
    }


}