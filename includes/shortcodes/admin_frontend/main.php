<?php 


function serlib_admin_frontend_shortcode(){
   /**Obtenemos datos del usuario y lo pasamos como un objeto que es lo que se veria en la sidebar*/
    if( is_user_logged_in() ){  
      
        $user = json_encode(wp_get_current_user(), true);

        echo '<script> var userinfo = '.$user.' </script>';

        $HTML = file_get_contents( 'templates/index.php', true );  
        
        return $HTML;

    }else{

        echo '<script> window.location = "/auth" </script>';

    }

}