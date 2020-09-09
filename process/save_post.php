<?php 

function ser_save_post_admin( $post_id, $post, $update ){
    
    if( $post->post_status === 'trash' ){
        return;
    }

    if( !($post->post_type === 'post' || $post->post_type === 'blog' || $post->post_type === 'revision' ) ){
        return;
    }
    
    $user_meta = get_userdata($post->post_author);

    // if ( $user_meta->roles[0] !== 'turista' || $user_meta->roles[0] === 'comerciante' ){
        // return;
    // } 

    if( isset($_POST['acf']) ){

        $data = [];
 
        foreach ($_POST['acf'] as $nombre => $valor) {

            array_push($data, $valor );
 
        }

        remove_action( 'save_post', 'ser_save_post_admin' );
        
        if($data[0] === 'RECHAZADO'){

            $causa   =   $data[1];
            
            if($causa === 'Otro'){
                $causa = $data[2];
            }
            
            enviar_email_rechazo($post_id, $causa);

            wp_update_post( array( 'ID' => $post_id, 'post_status' => 'trash' ) );
            

              
        }else if($data[0] === 'ACTIVO'){
                
            if( get_post_meta($post_id, 'es_activo', true) !== 1 ){
                enviar_email_confirm_post($post_id);
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

    if( get_user_by('email', $author->user_email)->roles[0] == 'administrador'){
        return;
    }

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
   
   // $email = 'brayan.bernalg@gmail.com';

    $mail_res = wp_mail( $email, _x('Publicación rechazada', 'asunto email', 'serlib') , $message, $headers );

    return $mail_res;
}

function notificacion_activacion_cuenta($user_id, $role, $old_roles){
    
    if( $role !== 'comerciante'){ 
        return;
    }

    $headers[] = 'From: Contacto <soporte@golfomorrosquillo.com>';

    $author = get_userdata($user_id);

    $email = $author->user_email;
    
    $text = 'Tu cuenta en el Golfo de Morrosquillo ha sido aprobada por el equipo del golfo de Morrosquillo';

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

    $mail_res = wp_mail( $email, 'Bienvenido a la comunidad del Golfo de Morrosquillo', $message, $headers );

}

/**PUBLICACION APROVADA */
function enviar_email_confirm_post($post_id){

    $headers[] = 'From: Contacto <soporte@golfomorrosquillo.com>';

    $post_c = get_post( $post_id );

    $author = get_userdata($post_c->post_author);

    if( get_user_by('email', $author->user_email)->roles[0] == 'administrador'){
        return;
    }

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
                            '.$author->user_email.'
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
   
    // $email = 'brayan.bernalg@gmail.com';

    $mail_res = wp_mail( $email, 'Publicación aprobada', $message, $headers );

    return $mail_res;

}

/**CREANDO POR EL ADMIN GOBERNACION ALCALDIA ALIADO */
function enviar_email_usuario_nuevo($user_id){

    $headers[]= 'From: Contacto <soporte@golfomorrosquillo.com>';

    $author = get_userdata($user_id);

    $username = base64_encode($author->data->user_login);
    $code = base64_encode(md5($author->data->user_login.$author->ID.$author->data->user_email.$author->data->user_pass));

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
                            <p style="text-align: center; color: #5e5e5e; font-family: Poppins; font-size: x-large;">Hemos creado un usuario para ser parte de nuestra comunidad del Golfo de Morrosquillo.</p>
                            <p style="font-weight: 600; font-size:17px;">
                                Usuario: '.$author->user_email.'<br><br>

                            </p>
                            <p style="font-weight: 600; font-size:17px;">
                                Para establecer tu contraseña visita el siguiente enlace:<br>

                            </p>
                            <p style="text-align: center; color: #5e5e5e; font-family: Poppins; font-size: x-large;">
                                
                                <a style="padding:5px 10px; text-decoration:none; color:#fff; background-color: #4c9ac1; border:2px solid #3d81a2;" href="https://golfodemorrosquillo.com/auth/recover-account?code='.$code.'&u='.$username.'" target="_blank">Haz click aquí</a>
                            
                            </p>
                            <br><br>
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
   
//    $email = 'brayan.bernalg@gmail.com';

    $mail_res = wp_mail( $email, 'Bienvenidos a la Comunidad del Golfo de Morrosquillo!', $message, $headers );

}

/**NUEVO USUARIO COMERCIANTE */
function enviar_email_usuario_nuevo_comerciante($user_id){

    $headers[]= 'From: Contacto <soporte@golfomorrosquillo.com>';

    $author = get_userdata($user_id);
    $email = $author->user_email;

    enviar_email_notificacione_staff('Nuevo comerciante por aprobar');

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
                            <p style="text-align: center; color: #5e5e5e; font-family: Poppins; font-size: x-large;">Haz creado un usuario para ser parte de nuestra comunidad del Golfo de Morrosquillo.</p>
                            <p style="font-weight: 600; font-size:17px;">
                                Usuario: '.$author->user_email.'<br><br>
                            </p>
                            <p style="font-weight: 600; font-size:17px;">
                                Recibirás un correo una vez  se verifique tu información y se haya activado tu usuario<br><br>
                                Gracias por querer unirte a la Comunidad Golfo de Morrosquillo
                            </p>
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

    $mail_res = wp_mail( $email, 'Bienvenidos a la Comunidad del Golfo de Morrosquillo!', $message, $headers );

}

/**NOTIFICACION AUTOR COMENTARIOS */
function enviar_email_notificaciones_author_post($post_id){

    $headers[]= 'From: Contacto <soporte@golfomorrosquillo.com>';

    $post_c = get_post( $post_id );

    if(get_current_user_id() == $post_c->post_author){
        return;
    }

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

    $mail_res = wp_mail( $email, 'Tienes una notificación pendiente del Golfo de Morrosquillo', $message, $headers );

}

/**NOTIFICACIONES STAFF ASUNTO DINAMICO */
function enviar_email_notificacione_staff($subject){

    $headers[]= 'From: Contacto <soporte@golfomorrosquillo.com>';

    $email = 'soporte@golfodemorrosquillo.com';

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
                            <p style="text-align: center; color: #5e5e5e; font-family: Poppins; font-size: x-large;">Ingresa a Golfo de Morrosquillo, tienes notificaciones pendientes por revisar.</p>
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

    $mail_res = wp_mail( $email, $subject, $message, $headers );

}

/**NOTIFICACIONES AUTOR DE COMENTARIO */
function enviar_email_notificaciones_author_comment($post_id, $user_id, $author_commenter){

    $headers[]= 'From: Contacto <soporte@golfomorrosquillo.com>';

    if(get_current_user_id() === $user_id){
        return;
    }

    $post_c = get_post( $post_id );

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
                            <p style="text-align: center; color: #5e5e5e; font-family: Poppins; font-size: x-large;">'.$author_commenter.', ha respondido tu comentario en la publicación '.$post_c->post_title.'.</p>
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

    $mail_res = wp_mail( $email, 'Tienes una notificación pendiente del Golfo de Morrosquillo', $message, $headers );

}

/**USUARIO TURISTA SIN CONFIRMAR */
function enviar_email_confirm($email, $username, $pass){

    $headers[]= 'From: Contacto <soporte@golfomorrosquillo.com>';

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
                            <p style="text-align: center; color: #5e5e5e; font-weight:600; font-family: Poppins; font-size: x-large;">
                            
                                Haz creado un usuario para ser parte de nuestra comunidad del Golfo de Morrosquillo.
                            </p>
                            
                        </div>

                        <div style="margin: auto; display: block; text-align: left;">
                        
                            <p style="text-align: center; color: #5e5e5e;  font-family: Poppins; font-size: x-large;">
                            
                        
                            '._x('Usuario', 'plantilla email', 'serlib').': '.$email.' <br><br>

                            </p>

                            <p style="font-weight: 600; font-size:17px;">
                                Haz click en este botón para activar la cuenta:<br><br>
                            </p>
                               
                        </div>
                        
                        <div style="margin: auto; display: block; text-align: left;">
                            <p style="text-align: center; color: #5e5e5e; font-family: Poppins; font-size: x-large;">
                            
                                <a style="padding:5px 10px; text-decoration:none; color:#fff; background-color: #4c9ac1; border:2px solid #3d81a2;" href="https://golfodemorrosquillo.com/auth?confirm='.$code.'&u='.$user.'" target="_blank">'._x('Activar cuenta','plantilla email', 'serlib').'</a>

                            </p>
                            
                        </div>
                        <div style="text-align: left;">
                            <br><br><p>Cordialmente,</p>
                            <img src="https://golfodemorrosquillo.com/wp-content/uploads/2020/08/a131e581-9844-44ea-bc79-d6385dbccee2.jpeg" width="250px">
                        </div>

                    </body>
                
                </html> '; 
            
          
       add_filter( 'wp_mail_content_type', 'tipo_de_contenido_html' );
   
    //$email = 'brayan.bernalg@gmail.com';

    $mail_res = wp_mail( $email, _x('Bienvenido a la comunidad del Golfo de morrosquillo', 'asunto email', 'serlib') , $message, $headers );

    return $mail_res;
}

/**CUANDO SE CREA USUARIO TURISTA CON REDES SOCIALES */
function enviar_email_usuario_nuevo_turista($user_id){

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
                            <p style="text-align: center; color: #5e5e5e; font-family: Poppins; font-size: x-large;">Haz creado un usuario para ser parte de nuestra comunidad del Golfo de Morrosquillo.</p>
                            <p style="font-weight: 600; font-size:17px;">
                                Usuario: '.$author->user_email.'<br><br>

                            </p>
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

    $mail_res = wp_mail( $email, 'Bienvenido a la Comunidad del Golfo de Morrosquillo!', $message, $headers );

}