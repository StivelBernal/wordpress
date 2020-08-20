<?php 

function ser_save_post_admin( $post_id, $post, $update ){
    
    $data   =   get_post_meta( $post_id, 'activa', true );

    if($data === 'RECHAZADO'){
        $causa   =   get_post_meta( $post_id, 'causa_rechazo', true );
        if($causa === 'Otro'){
            $causa = get_post_meta( $post_id, 'causa_otro', true );
        }
        remove_action( 'save_post_post', 'ser_save_post_admin' );
 
        wp_update_post( array( 'ID' => $post_id, 'post_status' => 'trash' ) );
       
        add_action( 'save_post_post', 'ser_save_post_admin' );

        enviar_email_rechazo($post_id, $causa);
       
    }
    
}

function enviar_email_rechazo($post_id, $causa){

    $headers[]= 'From: Contacto <contacto@golfomorrosquillo.com>';

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
                            <p style="text-align: center; color: #5e5e5e; font-family: Poppins; font-size: x-large;">Tu publicación '.$post_c->post_author.' en el Golfo de Morrosquillo ha sido rechazada por el equipo de Golfo de Morrosquillo</p>
                            <p style="font-weight: 600; font-size:17px;">
                                Accede a tu cuenta y crea una publicación que cumpla con los requisitos establecidos para nuestra Comunidad del Golfo de Morrosquillo
                            </p>
                            <a target="blank" href="https://golfodemorrosquillo.com/auth/">
                                https://golfodemorrosquillo.com/auth/
                            </a>
                        </div>
                        <div style="text-align: left;">
                            <br><br><p>Cordialmente,</p>
                            <img src="https://golfodemorrosquillo.com/wp-content/uploads/2020/08/a131e581-9844-44ea-bc79-d6385dbccee2.jpeg" width="120px">
                        </div>
                        <div style="margin: auto; display: block; text-align: left;">
                            '.$email.$causa.'    
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
   
     $email = 'brayan.bernalg@gmail.com';

    $mail_res = wp_mail( $email, '[Golfo de Morrosquillo] '._x('Confirmación de cuenta', 'asunto email', 'serlib') , $message, $headers );

    return $mail_res;
}