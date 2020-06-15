<?php 

function serlib_admin_frontend_shortcode(){
   /**Obtenemos datos del usuario y lo pasamos como un objeto que es lo que se veria en la sidebar*/
    if( is_user_logged_in() ){  
        
        $user = new WP_User( get_current_user_id() );
        $file_document = '';
        if( $user->roles[0] === 'comerciante' ){
            $file_document = get_user_meta($user->ID, 'file_document', true );  
        }
       
        $user_photo = get_user_meta($user->ID, 'user_photo', true );
        
        $user_photo                = str_replace( 
            ['/home/brayan/Escritorio/FOVEA/', '/home/u135059516/domains/golfodemorrosquillo.com/public_html',
             '/home/u135059516/domains/golfodemorrosquillo.co/public_html', '/home/u135059516/domains/golfodemorrosquillo.com.co/public_html'], 
            '',
            $user_photo 
        );

        if(!$user_photo){
            $user_photo = '/wp-content/plugins/ser_lib/assets/img/avatar-default.jpg';
        }

        echo    '<script> var userinfo = { 
                          ID: "'.$user->data->ID.'",
                          rol: "'.$user->roles[0].'", 
                          first_name: "'.$user->user_firstname.'", 
                          last_name: "'.$user->user_lastname.'",
                          email: "'.$user->user_email.'",  
                          img_profile: "'.$user_photo.'",
                          file_document: "'.$file_document.'"
                     }; 
                </script>';
        
              
        $HTML = file_get_contents( 'templates/index.php', true );  
     
        return $HTML;

    }else{

        echo '<script> window.location = "/auth" </script>';

    }

}


function menu_top_user_shortcode(){

    if( is_user_logged_in() ){  

        $user = wp_get_current_user();

        $user_photo = get_user_meta($user->ID, 'user_photo', true );
       
        $user_photo                = str_replace( 
            '/home/brayan/Escritorio/FOVEA', 
            '',
            $user_photo 
        );

        if(!$user_photo){
            $user_photo = '/wp-content/plugins/ser_lib/assets/img/avatar-default.jpg';
        }
          
        return '<div class="row center-center menu_user_top">
                    <a  href="/mi-cuenta">
                        <img src="'.$user_photo.'" ></a>
                    <a  href="/mi-cuenta">
                    <p>'.__('Mi Cuenta', 'serlib').'</p></a>
                    <span class="separator">|</span>
                    <p>'.wp_loginout(home_url( '/') , false ).'</p>
                   
                </div>';
    }else{
        
        return '<div class="menu_user_top_login row center-center"> 
                    <a href="/auth"> <p>'.__('Ingresar').'</a> </p>
                    <span class="separator">|</span> 
                    <a href="/auth/register"><p> '.__('Registrarse').'</p></a>
                </div>';
    }

}