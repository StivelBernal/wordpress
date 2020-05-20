<?php

function serlib_auth_handler(){
    
    function enviar_email_confirm($email, $username, $pass){

        $headers[]= 'From: Contacto <contact@golfomorrosquillo.com>';

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
                    }
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

    global $wpdb;


    if( $_SERVER['REQUEST_METHOD'] === 'GET' ){
        
        $query = "SELECT * FROM ".$wpdb->prefix."states;";
        $query2 = "SELECT * FROM ".$wpdb->prefix."cities WHERE is_active = 1;";

        $results['states'] = $wpdb->get_results( $query );
        $results['cities_active'] = $wpdb->get_results( $query2 );
        
        for($i = 0; $i < count($results['states']); $i++ ){
            $results['states'][$i]->cities = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."cities WHERE state_id = ".$results['states'][$i]->ID.";");
        }
        wp_send_json($results);

    }

    if( $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['create'])){

        $objDatos   =     json_decode(file_get_contents("php://input"));
        
        function validateIsset($var){
            return isset($var) ? sanitize_text_field($var): '';
        }
        
        $output     =     [ 'status' => 400 ];

        $nonce      =     isset($objDatos->_wpnonce) ? $objDatos->_wpnonce : '';
        
        if( !wp_verify_nonce( $nonce, 'serlib_auth' ) ){
            wp_send_json($output);
        }

        //GENERAMOS UN NOMBRE DE USUARIO
        $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890aAS";
        $user_random = "";
        for($i=0;$i<2;$i++) {
            //obtenemos un caracter aleatorio escogido de la cadena de caracteres
            $user_random .= substr($str,rand(0,62),1);
        }
        
        $first_name             =   validateIsset($objDatos->nombre);
        $last_name              =   validateIsset($objDatos->apellido); 
        $username               =   validateIsset($objDatos->nombre);
        $email                  =   sanitize_email($objDatos->email);
        $role                   =   validateIsset($objDatos->rol) ;
        $telefono               =   validateIsset($objDatos->telefono);
        $birthdate              =   validateIsset($objDatos->birthday);
        $modo                   =   validateIsset($objDatos->modo);
        $intereses              =   validateIsset($objDatos->intereses);
        $ciudad_visitar         =   validateIsset($objDatos->city_active);
        $city_id                =   validateIsset($objDatos->city_id);
        $state_id               =   validateIsset($objDatos->state_id);
        $conocimiento_pagina    =   validateIsset($objDatos->conocimiento_pagina);
        if ( $conocimiento_pagina === 'Otro' ) $conocimiento_pagina = validateIsset( $objDatos->conocimiento_pagina_otro ) ;
        $city_id                =   validateIsset( $objDatos->city_id );
        $state_id               =   validateIsset( $objDatos->state_id );
        $conocimiento_pagina    =   validateIsset( $objDatos->conocimiento_pagina );
        $document_type = validateIsset( $objDatos->numero_documento );
        $document_number = validateIsset( $objDatos->tipo_documento );
        $photo = validateIsset( $objDatos->photo_url );
       
        if( username_exists($username) ){
            $username = $username.$user_random;
        }

        if( email_exists($email) || !is_email($email) ){
            
            $output  =  [ 'error' => 'email en uso' ];
                
            wp_send_json($output);

            return;

        }

        if($modo === 'directo'){
            
            $pass                   =   validateIsset($objDatos->password);
            $confirm_pass           =   validateIsset($objDatos->password_confirm);
            if($pass !==  $confirm_pass){
                $output  =  [ 'error' => 'las contraseñas no son iguales' ];
                wp_send_json($output);
                return;
            } 
          
            $user_id                =   wp_insert_user([
                'user_login'            =>  $username,
                'first_name'            =>  $first_name,
                'last_name'             =>  $last_name,
                'user_pass'             =>  $pass,
                'user_email'            =>  $email,
                'user_nicename'         =>  $first_name,
                'role'                  =>  'pendiente',
                'show_admin_bar_front'  =>  false 
            ]);

        }else if($modo === 'instagram' || $modo === 'facebook' ||  $modo === 'google' ){
            
            $pass = md5('ser'.$email);

            $user_id                =   wp_insert_user([
                'user_login'            =>  $username,
                'first_name'            =>  $first_name,
                'last_name'             =>  $last_name,
                'user_pass'             =>  $pass,
                'user_email'            =>  $email,
                'user_nicename'         =>  $first_name,
                'role'                  =>  $role,
                'show_admin_bar_front'  =>  false 
            ]);
            
        }
        
        if( is_wp_error($user_id) ){
            $output  =  [ 'error' => 'error register' ];
            wp_send_json($output);
            return;    
        }

        $output  =  [ 'success' => $user_id ];

        update_user_meta( $user_id, 'user_telefono', $telefono );
        update_user_meta( $user_id, 'user_role', $role );
        update_user_meta( $user_id, 'user_birthdate', $birthdate );
        update_user_meta( $user_id, 'user_modo', $modo );
        
        update_user_meta( $user_id, 'user_ciudad_visitar', $ciudad_visitar );
        update_user_meta( $user_id, 'user_conocimiento_pagina', $conocimiento_pagina );
        update_user_meta( $user_id, 'user_photo', $photo );    

        if($role === 'turista'){
            update_user_meta( $user_id, 'user_city_id', $city_id );
            update_user_meta( $user_id, 'user_state_id', $state_id );
            update_user_meta( $user_id, 'user_intereses', $intereses );
        }
        if($role === 'comerciante'){
            update_user_meta( $user_id, 'document_type', $document_type );
            update_user_meta( $user_id, 'document_number', $document_number );
        }
        
        
        if( $modo === 'directo' || $role === 'comerciante'){
            
            if( $role === 'turista'){
 
               enviar_email_confirm( $email, $username, $pass );
           
            }

            wp_send_json($output);
        
        }else if($modo === 'instagram' || $modo === 'facebook' ||  $modo === 'google' ){
            
            //esto seria para dejarlo loguiado en caso de registro con redes sociales
            $user   =   get_user_by( 'id', $user_id );
            wp_set_current_user( $user_id, $user->user_login );
            wp_set_auth_cookie( $user_id );
            do_action( 'wp_login', $user->user_login, $user );
        
            wp_send_json($output);
        }
        
    }

    if( $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['login'])){
        
        $objDatos   =     json_decode(file_get_contents("php://input"));
        
        $output     =     [ 'error' => __('Usuario no encontrado', 'serlib'),
                            'code' => 401];

        $nonce      =     isset($objDatos->_wpnonce) ? $objDatos->_wpnonce : '';
        
        if( !wp_verify_nonce( $nonce, 'serlib_auth' ) ){
           
            wp_send_json($output);
            die();
        }
        
        if( !isset( $objDatos->email, $objDatos->password ) ){
             
            wp_send_json($output);
            die();
        }

        
        $userActive = get_user_by('email', $objDatos->email);
       
        $isActive = true;

        for($i = 0; $i < count( $userActive->roles); $i++){
            if($userActive->roles[$i] === 'pendiente' ) $isActive = false;  
        }       

        if( !$isActive ){ 
            
            $output     =     [ 'error' => __('Su cuenta aún no esta activada', 'serlib'),
                            'code' => 401];
            wp_send_json($output);

            die();
        }
        

        $creds = null;

        switch ($objDatos->modo) {
            case 'directo':
                
                $creds                   =   [
                    'user_login'          =>  sanitize_text_field($objDatos->email),
                    'user_password'       =>  sanitize_text_field($objDatos->password),
                    'remember'            =>  boolval($objDatos->remembermme)
                  ];

                break;
            case 'facebook':
            case 'google':   
                $creds                   =  [
                    'user_login'          =>  sanitize_text_field($objDatos->email),
                    'user_password'       =>  sanitize_text_field('ser'+$objDatos->email),
                    'remember'            =>  true
                  ];

                break;

            case 'instagram':
                
                $query2 = "SELECT * FROM ".$wpdb->prefix."usermeta WHERE meta_key = '.$objDatos->username.$objDatos->id.';";

                $datos = $wpdb->get_results( $query );
                
                if(isset($datos)){
                    $creds                   =  [
                        'user_login'          =>  sanitize_text_field($datos->email),
                        'user_password'       =>  sanitize_text_field( md5('ser'+$datos->email) ),
                        'remember'            =>  true
                  ];
                }else{
                    wp_send_json($output);
                    die();
                }

                break;
        }

        
        if($creds !== null){

            $user   =   wp_signon( $creds, is_ssl());
           
            if( is_wp_error($user) ){
                wp_send_json($output);
            }
                    
            $output['success']       =   $user;
            wp_send_json($output);

        }

    }

    if( $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['reset_pass'])){
       
        $objDatos   =     json_decode(file_get_contents("php://input"));
       
        $nonce      =     isset($objDatos->_wpnonce) ? $objDatos->_wpnonce : '';
        
        if( !wp_verify_nonce( $nonce, 'serlib_auth' ) ){
           
            wp_send_json($output);
            die();
        }
          
        if( !isset( $objDatos->u, $objDatos->code) ){
             
            wp_send_json($output);
            die();
        }
        
        $user = get_user_by( 'login', base64_decode($objDatos->u) );

        $codeU = $user->data->user_login.$user->ID.$user->data->user_email.$user->data->user_pass;
      
        if(md5($codeU) === $objDatos->code ){
            $u = new WP_User( $user->ID );
            reset_password($u, $objDatos->password);
            
            $creds                   =  [
                'user_login'          =>  sanitize_text_field($user->user_email),
                'user_password'       =>  sanitize_text_field($objDatos->password ),
                'remember'            =>  false
            ];
          $user   =   wp_signon( $creds, is_ssl());
         
          $output     =     [ 'success' => 'gf',
          'code' => 200];

           wp_send_json($output);
        }
   
    }

    if( $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['recover'])){
               
        $objDatos   =     json_decode(file_get_contents("php://input"));
        
        $output     =     [ 'error' => __('Usuario no encontrado', 'serlib'),
                            'code' => 401];

        $nonce      =     isset($objDatos->_wpnonce) ? $objDatos->_wpnonce : '';
        
        if( !wp_verify_nonce( $nonce, 'serlib_auth' ) ){
           
            wp_send_json($output);
            die();
        }
        
        if( !isset( $objDatos->email ) ){
             
            wp_send_json($output);
            die();
        }
        
        
        $user = get_user_by( 'email', $objDatos->email );
       
        
        if( !$user )  die();

         /**Obtener meta para verificar la forma como se accedio si es diferente a directo*/
        $user_modo = get_user_meta( $user->ID, 'user_modo', true );
        
        if($user_modo && $user_modo !== 'directo' ){
            $output     =     [ 'error' => __('La cuenta esta vinculada a ', 'serlib'),
            'code' => 401];
            wp_send_json($output);
            die();
        } 

        

        for($i = 0; $i < count( $user->roles); $i++){
        
            if( $user->roles[$i] === 'pendiente' ){
                die();
            }
        
        }
        
        $username = base64_encode($user->data->user_login);
        $code = base64_encode(md5($user->data->user_login.$user->ID.$user->data->user_email.$user->data->user_pass));
        
        $headers[]= 'From: Contacto <contact@golfomorrosquillo.com>';

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
                                
                            
                                '._x('Correo', 'plantilla email recuperar cuenta', 'serlib').': '.$objDatos->email.' <br>
                                

                                </p>
                                
                            </div>
                            <div style="margin: auto; display: block; text-align: left;">
                                <p style="text-align: center; color: #5e5e5e; font-family: Poppins; font-size: x-large;">
                                
                                    <a style="padding:5px 10px; text-decoration:none; color:#fff; background-color: #4c9ac1; border:2px solid #3d81a2;" href="https://golfodemorrosquillo.com/auth/recover-account?code='.$code.'&u='.$username.'" target="_blank">'._x('Recuperar cuenta',  'plantilla email recuperar cuenta', 'serlib').'</a>

                                </p>
                                
                            </div>
                        </body>
                    }
                    </html> '; 



        /**
        *Funcion para enviar el mensaje
        */ 
        function tipo_de_contenido_html() {
        return 'text/html';
        }

        add_filter( 'wp_mail_content_type', 'tipo_de_contenido_html' );
       
        $mail_res = wp_mail( $objDatos->email, '[Golfo de Morrosquillo] '._x('Recuperación de cuenta', 'asunto email', 'serlib'), $message, $headers );

        if($mail_res){
            $output     =     [ 'success' => $mail_res,
            'code' => 200];
        }

        wp_send_json($output);
    }


    die();
}