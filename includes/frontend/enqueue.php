<?php 

function serlib_enqueue_scripts(){
    wp_register_style( 'serlib_frontend', plugins_url( '/assets/css/frontend.css', SER_PLUGIN_URL ) );
    wp_enqueue_style( 'serlib_frontend' );
    
    wp_register_style( 'ser_lib_css', plugins_url( '/assets/css/app.min.css', SER_PLUGIN_URL ) );
    wp_enqueue_style( 'ser_lib_css' );
 
    wp_register_style( 'swiper_css', plugins_url( '/assets/css/swiper.min.css', SER_PLUGIN_URL ) );
    wp_enqueue_style( 'swiper_css' );

  
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

    if(is_user_logged_in()){
       
        wp_register_style( 'sumernote_css', plugins_url( '/assets/libs/summernote/summernote-lite.min.css', SER_PLUGIN_URL ) );
        wp_enqueue_style( 'sumernote_css' );
    
        wp_register_script( 
            'sumernote_js', 
            plugins_url( '/assets/libs/summernote/summernote-lite.min.js', SER_PLUGIN_URL ), 
            ['ser_lib_js'], 
            '1.0.0', 
            true 
        );

      wp_enqueue_script( 'sumernote_js' );
    }

    wp_register_script( 
        'swiper_js', 
        plugins_url( '/assets/js/swiper.min.js', SER_PLUGIN_URL ), 
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
  
    wp_enqueue_script( 'swiper_js' );
    wp_enqueue_script( 'serlib_rateit' );
    wp_enqueue_script( 'ser_lib_js' );
    wp_enqueue_script( 'serlib_main' );
    
}