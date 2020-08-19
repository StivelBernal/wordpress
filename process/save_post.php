<?php 

function ser_save_post_admin( $post_id, $post, $update ){
    
    $data   =   get_post_meta( $post_id, 'activa', true );

    if($data === 'RECHAZADO'){
       
        remove_action( 'save_post_post', 'ser_save_post_admin' );
 
        wp_update_post( array( 'ID' => $post_id, 'post_status' => 'trash' ) );
       
        add_action( 'save_post_post', 'ser_save_post_admin' );

        enviar_email_rechazo($post_id);
       
    }
    
}

function enviar_email_rechazo($post_id){

    $headers[]= 'From: Contacto <contacto@golfomorrosquillo.com>';

    $code = md5($email);
    $user = base64_encode($username);
    $code  = base64_encode($code);
    
    $message = '<html>
                    <head>	
                    </head>
                    <body>
                        <div style="margin: auto; display: block; flex-direction: column; text-align: center;">
                            <a class="logo" href="https://golfodemorrosquillo.com">
                            <img src="https://golfodemorrosquillo.com/wp-content/uploads/2020/05/GDFRecurso-1MICOSCOLOR-e1588719554428.png" class="logo_main" width="300" >
                            </a>
                        </div>
                        <div style="margin: auto; display: block; text-align: left;">
                        
                            <p style="text-align: center; color: #5e5e5e;     font-family: Poppins; font-size: x-large;">
                            
                        
                            '._x('Correo', 'plantilla email', 'serlib').': '.$email.' <br>
                            '._x('Contraseña', 'plantilla email', 'serlib').': '.$pass.'<br>
                            

                            </p>
                            
                        </div>
                        <div style="margin: auto; display: block; text-align: left;">
                            <p style="text-align: center; color: #5e5e5e; font-family: Poppins; font-size: x-large;">
                            
                                <a style="padding:5px 10px; text-decoration:none; color:#fff; background-color: #4c9ac1; border:2px solid #3d81a2;" href="https://golfodemorrosquillo.com/auth?confirm='.$code.'&u='.$user.'" target="_blank">'._x('Activar cuenta','plantilla email', 'serlib').'</a>

                            </p>
                            
                        </div>
                    </body>
                
                </html> '; 
            
    /**
    *Funcion para enviar el mensaje
    */ 
    function tipo_de_contenido_html() {
         return 'text/html';
      }
      
       add_filter( 'wp_mail_content_type', 'tipo_de_contenido_html' );
   
    // $email = 'brayan.bernalg@gmail.com';

    $mail_res = wp_mail( $email, '[Golfo de Morrosquillo] '._x('Confirmación de cuenta', 'asunto email', 'serlib') , $message, $headers );

    return $mail_res;
}