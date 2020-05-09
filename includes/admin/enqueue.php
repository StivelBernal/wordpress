<?php

function serlib_admin_enqueue(){
  if( !isset($_GET['page']) || ($_GET['page'] !== "serlib_plugin_opts" && $_GET['page'] != "serlib_cities" && $_GET['page'] != "serlib_states") ){
    return;
  }

  wp_register_style( 'ser_lib_css', plugins_url( '/assets/css/app.min.css', SER_PLUGIN_URL ) );
  wp_enqueue_style( 'ser_lib_css' );


  wp_register_script( 
      'ser_lib_js', 
      plugins_url( '/assets/js/app.min.js', SER_PLUGIN_URL ), 
      [], 
      '1.0.0', 
      true 
  );

  wp_register_script( 
      'serlib_options', plugins_url( '/assets/js/options.js', SER_PLUGIN_URL ), [], time(), true 
  );

  wp_localize_script( 'serlib_options', 'back_obj', [
      'ajax_url'      =>  admin_url( 'admin-ajax.php' )
  ]);
  
  wp_enqueue_script( 'ser_lib_js' );
  wp_enqueue_script( 'serlib_options' );
  
}