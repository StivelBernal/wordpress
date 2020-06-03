<?php 


function serlib_admin_frontend_shortcode(){
   
    if( is_user_logged_in() ){  
      
        $user = wp_get_current_user();

        $HTML = file_get_contents( 'templates/index.php', true );  
        
        return $HTML;

    }else{

        echo '<script> window.location = "/auth" </script>';

    }

}