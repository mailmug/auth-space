<?php

defined( 'ABSPATH' ) || exit;

class AuthSpace_Plugin_Activator {

    const OPTION_NAME = 'authspace_settings';

    public static function activate() {

        $defaults = [
            'login_page_id'           => self::create_page(
                'Login',
                'login',
                '[authspace_login]'
            ),
            'register_page_id'        => self::create_page(
                'Register',
                'register',
                '[authspace_register]'
            ),
            'forgot_password_page_id' => self::create_page(
                'Forgot Password',
                'forgot-password',
                '[authspace_forgot_password]'
            ),
            'reset_password_page_id'  => self::create_page(
                'Reset Password',
                'reset-password',
                '[authspace_reset_password]'
            ),
        ];

        add_option( self::OPTION_NAME, $defaults );
    }

    private static function create_page(
        string $title,
        string $slug,
        string $shortcode
    ): int {

        return wp_insert_post(
            [
                'post_title'   => $title,
                'post_name'    => $slug,
                'post_content' => $shortcode,
                'post_status'  => 'publish',
                'post_type'    => 'page',
            ]
        );
    }
}