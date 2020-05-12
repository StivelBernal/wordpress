<?php 

function serlib_enqueue_scripts(){
    wp_register_style( 'serlib_frontend', plugins_url( '/assets/css/frontend.css', SER_PLUGIN_URL ) );
    wp_enqueue_style( 'serlib_frontend' );
    
    wp_register_style( 'ser_lib_css', plugins_url( '/assets/css/app.min.css', SER_PLUGIN_URL ) );
    wp_enqueue_style( 'ser_lib_css' );

    wp_register_script( 
        'serlib_rateit', 
        plugins_url( '/assets/rateit/jquery.rateit.min.js', SER_PLUGIN_URL ), 
        ['jquery'], 
        '1.0.0', 
        true 
    );

    wp_register_script( 
        'ser_lib_js', 
        plugins_url( '/assets/js/app.min.js', SER_PLUGIN_URL ), 
        [], 
        '1.0.0', 
        true 
    );
  
    wp_register_script( 
        'serlib_main', plugins_url( '/assets/js/main.js', SER_PLUGIN_URL ), ['ser_lib_js'], time(), true 
    );

    wp_localize_script( 'serlib_main', 'front_obj', [
        'ajax_url'      =>  admin_url( 'admin-ajax.php' )
    ]);
    
    wp_enqueue_script( 'serlib_rateit' );
    wp_enqueue_script( 'ser_lib_js' );
    wp_enqueue_script( 'serlib_main' );
}


