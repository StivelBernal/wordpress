<?php 
/*
Plugin Name: Ser Library
Plugin URI: https://sersoluciones.com/wordpress
Description: Plugin con funciones para Fovea
Author: Sersoluciones
Author URI: https://sersoluciones.com
Version: 0.4
Text Domain: serlib
*/

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

// Setup
define( 'SER_PLUGIN_URL', __FILE__ );

// Includes
include( 'includes/activate.php' );
include( 'includes/init.php' );
include( 'process/save_post.php' );
include( 'process/filter_content.php' );
include( 'includes/frontend/enqueue.php' );
include( 'process/frontend/auth.php' );
include( 'process/rate_destino.php' );
include( 'process/entries.php' );
include( 'process/admin/options.php' );
include( 'includes/admin/init.php' );
include( 'includes/admin/menus.php' );
include( 'includes/shortcodes/auth.php' );
include( 'process/upload-media.php' );
include( 'includes/shortcodes/carrusel.php' );
include( 'includes/shortcodes/search.php' );
include( 'includes/shortcodes/admin_frontend/main.php' );
include( 'process/frontend/user_info.php' );
include( 'process/frontend/references.php' );

// Hooks
register_activation_hook( __FILE__ , 'serlib_activate_plugin' );
add_action( 'init', 'serlib_fovea_init' ); 
add_action( 'save_post_destino', 'ser_save_post_admin', 10, 3 ); 
add_filter( 'the_content', 'serlib_filter_destino_content' );
add_action( 'wp_enqueue_scripts', 'serlib_enqueue_scripts', 100 );

/**solo superuser admin */
add_action( 'wp_ajax_serlib_options_handler', 'serlib_options_handler' );

/**usuarios registrados */
add_action( 'wp_ajax_serlib_rate_destino', 'serlib_rate_destino' );

/**publicos login*/
add_action( 'wp_ajax_nopriv_serlib_entries', 'serlib_entries' );
add_action( 'wp_ajax_serlib_entries', 'serlib_entries' );
add_action( 'wp_ajax_nopriv_serlib_auth_handler', 'serlib_auth_handler' );
add_action( 'wp_ajax_nopriv_serlib_uploader', 'serlib_uploader' );

/**obtener post desde la vista frontal */
add_action( 'wp_ajax_serlib_users_info', 'serlib_users_info' );
add_action( 'wp_ajax_serlib_uploader', 'serlib_uploader' );
add_action( 'wp_ajax_serlib_references', 'serlib_references');
add_action( 'wp_ajax_nopriv_serlib_references', 'serlib_references');

add_action( 'admin_init', 'serlib_admin_init' );
add_action( 'admin_menu', 'serlib_admin_menus' );
add_action ('wp_loaded', 'login_redirect');

// Shortcodes
add_shortcode( 'serlib_login_form', 'serlib_login_form_shortcode' );
add_shortcode( 'serlib_register_form', 'serlib_register_form_shortcode' );
add_shortcode( 'serlib_recover_account', 'serlib_recover_account_shortcode' );
add_shortcode( 'serlib_gracias', 'serlib_register_gracias_shortcode' );
add_shortcode( 'serlib_carrusel_destinos', 'serlib_carrusel_destinos_shortcode' );
add_shortcode( 'serlib_buscador_home_input', 'serlib_buscador_home_input_shortcode' );


add_shortcode( 'serlib_buscador_home_results', 'serlib_buscador_home_results_shortcode' );
add_shortcode( 'serlib_buscador_home_results_blog', 'serlib_buscador_home_results_blog_shortcode' );
// Admin frontend 
add_shortcode( 'serlib_admin_frontend', 'serlib_admin_frontend_shortcode' );
add_shortcode( 'menu_top_user', 'menu_top_user_shortcode' );

// Modificaciones funciones de wordpress}

/* Desactivar emails a admins de restablecimiento de contraseñas */
if ( !function_exists( 'wp_password_change_notification' ) ) {
    function wp_password_change_notification() {}
}