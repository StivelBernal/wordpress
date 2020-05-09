<?php 

function serlib_enqueue_scripts(){
    wp_register_style( 'serlib_rateit', plugins_url( '/assets/rateit/rateit.css', SER_PLUGIN_URL ) );
    wp_enqueue_style( 'serlib_rateit' );

    wp_register_script( 
        'serlib_rateit', 
        plugins_url( '/assets/rateit/jquery.rateit.min.js', SER_PLUGIN_URL ), 
        ['jquery'], 
        '1.0.0', 
        true 
    );
    wp_register_script( 
        'serlib_destino_main', plugins_url( '/assets/js/main.js', SER_PLUGIN_URL ), ['jquery'], '1.0.0', true 
    );

    wp_localize_script( 'serlib_destino_main', 'destino_obj', [
        'ajax_url'      =>  admin_url( 'admin-ajax.php' )
    ]);
    
    wp_enqueue_script( 'serlib_rateit' );
    wp_enqueue_script( 'serlib_destino_main' );
}