<?php 

function ser_save_post_admin( $post_id, $post, $update ){
    
    if( $post->post_status === 'trash' ){
        return;
    }

    if( !($post->post_type === 'post' || $post->post_type === 'blog' || $post->post_type === 'revision' ) ){
        return;
    }
    
    $user_meta = get_userdata($post->post_author);

    if( $user_meta->roles[0] !== 'turista' || $user_meta->roles[0] === 'comerciante' ){
        //return;
    } 

    if( isset($_POST['acf']) ){

        $data = [];
 
        foreach ($_POST['acf'] as $nombre => $valor) {

            array_push($data, $valor );
 
        }

        
        
        if($data[0] === 'RECHAZADO'){

            $causa   =   $data[1];
            
            if($causa === 'Otro'){
                $causa = $data[2];
            }
            
            remove_action( 'save_post', 'ser_save_post_admin', 6, 3 );
            
            //enviar_email_rechazo($post_id, $causa);
            wp_update_post( array( 'ID' => $post_id, 'post_status' => 'trash' ) );
            

              
        }else if($data[0] === 'ACTIVO'){
                
            if( get_post_meta($post_id, 'es_activo', true) !== 1 ){
               // enviar_email_confirm_post($post_id);
                update_post_meta($post_id, 'es_activo', 1);
            }

        }

    }
    
}

function tipo_de_contenido_html() {
    return 'text/html';
}

function enviar_email_rechazo($post_id, $causa){

    $headers[]= 'From: Contacto <soporte@golfomorrosquillo.com>';

    $post_c = get_post( $post_id );

    $author = get_userdata($post_c->post_author);

    $email = $author->user_email;

    $message = '<html>
                    <head>	
                    </head>
                    <body>
                        <div style="margin: auto; display: block; flex-direction: column; text-align: center;">
                            <a class="logo" href="https://golfodemorrosquillo.com" target="blank">
                            <img src="https://golfodemorrosquillo.com/wp-content/uploads/2020/05/GDFRecurso-1MICOSCOLOR-e1588719554428.png" class="logo_main" width="300" >
                            </a>
                        </div>
                        <div style="margin: auto; display: block; text-align: left;">
                            <p style="text-align: center; color: #5e5e5e; font-family: Poppins; font-size: x-large;">Tu publicación '.$post_c->post_title.' en el Golfo de Morrosquillo ha sido rechazada a causa de '.$causa.' por el equipo de Golfo de Morrosquillo</p>
                            <p style="font-weight: 600; font-size:17px;">
                                Accede a tu cuenta y crea una publicación que cumpla con los requisitos establecidos para nuestra Comunidad del Golfo de Morrosquillo.
                            </p>
                            <a target="blank" href="https://golfodemorrosquillo.com/auth/">
                                https://golfodemorrosquillo.com/auth/
                            </a>
                        </div>
                        <div style="text-align: left;">
                            <br><br><p>Cordialmente,</p>
                            <img src="https://golfodemorrosquillo.com/wp-content/uploads/2020/08/a131e581-9844-44ea-bc79-d6385dbccee2.jpeg" width="250px">
                        </div>
                    
                    </body>
                </html> '; 
    
      
       add_filter( 'wp_mail_content_type', 'tipo_de_contenido_html' );
   
    $email = 'brayan.bernalg@gmail.com';

    $mail_res = wp_mail( $email, '[Golfo de Morrosquillo] '._x('Publicación rechazada', 'asunto email', 'serlib') , $message, $headers );

    return $mail_res;
}

function notificacion_activacion_cuenta($user_id, $role, $old_roles){
    
    if( $role !== 'comerciante'){ 
        return;
    }

    $headers[] = 'From: Contacto <soporte@golfomorrosquillo.com>';

    $author = get_userdata($user_id);

    $email = $author->user_email;
    
    $text = 'Su cuenta en el Golfo de Morrosquillo ha sido aprobada por el equipo del golfo de Morrosquillo';

    $message = '<html>
                    <head>	
                    </head>
                    <body>
                      
                        <div style="margin: auto; display: block; flex-direction: column; text-align: center;">
                            <a class="logo" href="https://golfodemorrosquillo.com" target="blank">
                            <img src="https://golfodemorrosquillo.com/wp-content/uploads/2020/05/GDFRecurso-1MICOSCOLOR-e1588719554428.png" class="logo_main" width="300" >
                            </a>
                        </div>
                        <div style="margin: auto; display: block; text-align: left;">
                            <p style="text-align: center; color: #5e5e5e; font-family: Poppins; font-size: x-large;">'.$text.'</p>
                            
                            <p style="font-weight: 600; font-size:17px;">
                                <br><br>Correo: '.$email.'<br><br>
                            </p>
                            <p style="font-weight: 600; font-size:17px;">
                                Accede a tu cuenta en el siguiente enlace:.
                            </p>
                            <a target="blank" href="https://golfodemorrosquillo.com/auth/">
                                https://golfodemorrosquillo.com/auth/
                            </a>
                        </div>
                        <div style="text-align: left;">
                            <br><br><p>Cordialmente,</p>
                            <img src="https://golfodemorrosquillo.com/wp-content/uploads/2020/08/a131e581-9844-44ea-bc79-d6385dbccee2.jpeg" width="250px">
                        </div>
                    
                    </body>
                </html> '; 
            
    /**
    *Funcion para enviar el mensaje
    */ 
   
      
    add_filter( 'wp_mail_content_type', 'tipo_de_contenido_html' );
   
        //$email = 'brayan.bernalg@gmail.com';

    $mail_res = wp_mail( $email, '[Golfo de Morrosquillo] Cuenta aprobada', $message, $headers );

}

function enviar_email_confirm_post($post_id){

    $headers[] = 'From: Contacto <soporte@golfomorrosquillo.com>';

    $post_c = get_post( $post_id );

    $author = get_userdata($post_c->post_author);

    $email = $author->user_email;

    $message = '<html>
                    <head>	
                    </head>
                    <body>
                        <div style="margin: auto; display: block; flex-direction: column; text-align: center;">
                            <a class="logo" href="https://golfodemorrosquillo.com" target="blank">
                            <img src="https://golfodemorrosquillo.com/wp-content/uploads/2020/05/GDFRecurso-1MICOSCOLOR-e1588719554428.png" class="logo_main" width="300" >
                            </a>
                        </div>
                        <div style="margin: auto; display: block; text-align: left;">
                            <p style="text-align: center; color: #5e5e5e; font-family: Poppins; font-size: x-large;">Tu publicación '.$post_c->post_title.' en el Golfo de Morrosquillo ha sido aprobada por el equipo del golfo de Morrosquillo</p>
                            <p style="font-weight: 600; font-size:17px;">
                                Accede a tu cuenta en el siguiente enlace:.
                            </p>
                            <a target="blank" href="https://golfodemorrosquillo.com/auth/">
                                https://golfodemorrosquillo.com/auth/
                            </a>
                        </div>
                        <div style="text-align: left;">
                            <br><br><p>Cordialmente,</p>
                            <img src="https://golfodemorrosquillo.com/wp-content/uploads/2020/08/a131e581-9844-44ea-bc79-d6385dbccee2.jpeg" width="250px">
                        </div>
                    
                    </body>
                </html> '; 
            
    /**
    *Funcion para enviar el mensaje
    */ 
   
      
    add_filter( 'wp_mail_content_type', 'tipo_de_contenido_html' );
   
        $email = 'brayan.bernalg@gmail.com';

    $mail_res = wp_mail( $email, '[Golfo de Morrosquillo] Publicación aprobada', $message, $headers );

    return $mail_res;

}

function enviar_email_usuario_nuevo($user_id){

    $headers[]= 'From: Contacto <soporte@golfomorrosquillo.com>';

    $author = get_userdata($user_id);

    $email = $author->user_email;

    $message = '<html>
                    <head>	
                    </head>
                    <body>
                        <div style="margin: auto; display: block; flex-direction: column; text-align: center;">
                            <a class="logo" href="https://golfodemorrosquillo.com" target="blank">
                            <img src="https://golfodemorrosquillo.com/wp-content/uploads/2020/05/GDFRecurso-1MICOSCOLOR-e1588719554428.png" class="logo_main" width="300" >
                            </a>
                        </div>
                        <div style="margin: auto; display: block; text-align: left;">
                            <p style="text-align: center; color: #5e5e5e; font-family: Poppins; font-size: x-large;">Hemos creado un usuario para que hagas parte de nuestra comunidad del Golfo de Morrosquillo.</p>
                            <p style="font-weight: 600; font-size:17px;">
                                Usuario: '.$author->user_email.'<br><br>

                            </p>
                            <p style="font-weight: 600; font-size:17px;">
                                Para establecer tu contraseña visita el siguiente enlace:<br>

                            </p>
                            <a target="blank" href="https://golfodemorrosquillo.com/auth/recover">
                                https://golfodemorrosquillo.com/auth/recover-account/
                            </a><br><br>
                            <p style="font-weight: 600; font-size:17px;">
                                Guarda nuestro link en la pestaña de favoritos:<br>
                            </p>
                            <a target="blank" href="https://golfodemorrosquillo.com/auth/">
                                https://golfodemorrosquillo.com/auth/
                            </a>
                        </div>
                        <div style="text-align: left;"> 
                            <br><br><p>Cordialmente,</p>
                            <img src="https://golfodemorrosquillo.com/wp-content/uploads/2020/08/a131e581-9844-44ea-bc79-d6385dbccee2.jpeg" width="250px">
                        </div>
                    
                    </body>
                </html> '; 
            
    /**
    *Funcion para enviar el mensaje
    */ 
   
      
    add_filter( 'wp_mail_content_type', 'tipo_de_contenido_html' );
   
    //$email = 'brayan.bernalg@gmail.com';

    $mail_res = wp_mail( $email, '[Golfo de Morrosquillo] Bienvenidos a la Comunidad del Golfo de Morrosquillo!', $message, $headers );

}


function enviar_email_notificaciones($post_id){

    $headers[]= 'From: Contacto <soporte@golfomorrosquillo.com>';

    $post_c = get_post( $post_id );

    $author = get_userdata($post_c->post_author);

    $email = $author->user_email;

    $message = '<html>
                    <head>	
                    </head>
                    <body>
                        <div style="margin: auto; display: block; flex-direction: column; text-align: center;">
                            <a class="logo" href="https://golfodemorrosquillo.com" target="blank">
                            <img src="https://golfodemorrosquillo.com/wp-content/uploads/2020/05/GDFRecurso-1MICOSCOLOR-e1588719554428.png" class="logo_main" width="300" >
                            </a>
                        </div>
                        
                        <div style="margin: auto; display: block; text-align: left;">
                            <p style="text-align: center; color: #5e5e5e; font-family: Poppins; font-size: x-large;">Ingresa a tu cuenta del Golfo de Morrosquillo, tienes notificaciones pendientes por revisar en tu publicación '.$post_c->post_title.'.</p>
                            <p style="font-weight: 600; font-size:17px;">
                                Acceder
                            </p>
                            <a target="blank" href="https://golfodemorrosquillo.com/auth/">
                                https://golfodemorrosquillo.com/auth/
                            </a>
                        </div>

                        <div style="text-align: left;"> 
                            <br><br><p>Cordialmente,</p>
                            <img src="https://golfodemorrosquillo.com/wp-content/uploads/2020/08/a131e581-9844-44ea-bc79-d6385dbccee2.jpeg" width="250px">
                        </div>
                        
                    </body>
                </html> '; 
            
    /**
    *Funcion para enviar el mensaje
    */ 
   
      
    add_filter( 'wp_mail_content_type', 'tipo_de_contenido_html' );
   
    //$email = 'brayan.bernalg@gmail.com';

    $mail_res = wp_mail( $email, '[Golfo de Morrosquillo] Tienes una notificación pendiente del Golfo de Morrosquillo', $message, $headers );

}