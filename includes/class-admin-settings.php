<?php

defined( 'ABSPATH' ) || exit;

class AuthSpace_Admin_Settings {

    const OPTION_NAME = 'authspace_settings';

    public function __construct() {
        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
        add_action( 'admin_init', [ $this, 'register_settings' ] );
    }

    public function admin_menu() {

        add_menu_page(
            __( 'Auth Space', 'authspace' ),
            __( 'Auth Space', 'authspace' ),
            'manage_options',
            'authspace',
            [ $this, 'render_page' ],
            'dashicons-lock',
            58
        );
    }

    public function register_settings() {
        register_setting( 'authspace_settings_group', self::OPTION_NAME
        );
    }

    public function render_page() {
        $settings = get_option( self::OPTION_NAME, [] );
        ?>
        <div class="wrap">
            <h1><?php esc_html_e( 'Auth Space Settings', 'authspace' ); ?></h1>

            <form method="post" action="options.php">
                <?php settings_fields( 'authspace_settings_group' ); ?>

                <table class="form-table">
                    <tr>
                        <th><?php esc_html_e( 'Login Page', 'authspace' ); ?></th>
                        <td>
                            <?php
                            wp_dropdown_pages( [
                                'name'     => self::OPTION_NAME . '[login_page_id]',
                                'selected' => $settings['login_page_id'] ?? 0,
                            ] );
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <th><?php esc_html_e( 'Register Page', 'authspace' ); ?></th>
                        <td>
                            <?php
                            wp_dropdown_pages( [
                                'name'     => self::OPTION_NAME . '[register_page_id]',
                                'selected' => $settings['register_page_id'] ?? 0,
                            ] );
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <th><?php esc_html_e( 'Forgot Password Page', 'authspace' ); ?></th>
                        <td>
                            <?php
                            wp_dropdown_pages( [
                                'name'     => self::OPTION_NAME . '[forgot_password_page_id]',
                                'selected' => $settings['forgot_password_page_id'] ?? 0,
                            ] );
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <th><?php esc_html_e( 'Reset Password Page', 'authspace' ); ?></th>
                        <td>
                            <?php
                            wp_dropdown_pages( [
                                'name'     => self::OPTION_NAME . '[reset_password_page_id]',
                                'selected' => $settings['reset_password_page_id'] ?? 0,
                            ] );
                            ?>
                        </td>
                    </tr>
                </table>

                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}