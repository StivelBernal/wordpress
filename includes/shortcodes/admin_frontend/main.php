<?php 

function serlib_admin_frontend_shortcode(){
   /**Obtenemos datos del usuario y lo pasamos como un objeto que es lo que se veria en la sidebar*/
    if( is_user_logged_in() ){  
        
        $user = wp_get_current_user();
        $file_document = '';
        if( $user->roles[0] === 'comerciante' ){
            $file_document = get_user_meta($user->ID, 'file_document', true );  
        }

        $user_photo = get_user_meta($user->ID, 'user_photo', true );
        
        if(!$user_photo){
            $user_photo = '/wp-content/plugins/ser_lib/assets/img/avatar-default.jpg';
        }

        echo    '<script> var userinfo = { 
                          rol: "'.$user->roles[0].'", name: "'.$user->first_name.' '.$user->last_name.'", email: "'.$user->user_email.'",  
                          img_profile: "'.$user_photo.'", file_document: "'.$file_document.'"
                     }; 
                </script>';
        
              
        $HTML = file_get_contents( 'templates/index.php', true );  
     
        return $HTML;

    }else{

        echo '<script> window.location = "/auth" </script>';

    }

}