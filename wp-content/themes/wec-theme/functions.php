<?php
function wec_assets() {
    wp_enqueue_style( 'wec-style', get_stylesheet_uri(), [], '1.0' );
}
add_action( 'wp_enqueue_scripts', 'wec_assets' );

// Deshabilitar barra de administración en frontend
add_filter( 'show_admin_bar', '__return_false' );
