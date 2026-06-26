
<?php

defined( 'ABSPATH' ) || exit;

class AuthSpace_Assets {

    public function __construct()
    {
        
        add_action( 'wp_enqueue_scripts', array( __CLASS__, 'load_scripts' ) );
    }

    public static function load_scripts() {

        $asset = require AUTHSPACE_ABSPATH . 'assets/build/index.asset.php';
    
        wp_register_script(
            'auth-space',
            AUTHSPACE_URL . 'assets/build/index.js',
            $asset['dependencies'],
            $asset['version'],
            ['in_footer' => true]
        );

        wp_register_style(
            'auth-space',
            AUTHSPACE_URL . 'assets/build/style-index.css',
            array(),
            $asset['version']
        );

        wp_localize_script(
            'auth-space',
            'authSpace',
            [
                'restUrl' => rest_url(),
                'nonce'   => wp_create_nonce( 'wp_rest' ),
            ]
        );

        do_action('authspace_after_enqueue_scripts', $asset);
         
    }

}