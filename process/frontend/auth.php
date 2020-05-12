<?php

function serlib_auth_handler(){
    
    global $wpdb;

    if( $_SERVER['REQUEST_METHOD'] === 'GET' ){
        
        $query = "SELECT * FROM ".$wpdb->prefix."states;";
        $query2 = "SELECT * FROM ".$wpdb->prefix."cities WHERE is_active = 1;";

        $results['states'] = $wpdb->get_results( $query );
        $results['cities_active'] = $wpdb->get_results( $query2 );
        
        for($i = 0; $i < count($results['states']); $i++ ){
            $results['states'][$i]->cities = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."cities WHERE state_id = ".$results['states'][$i]->ID.";");
        }

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

        $headers[]= 'From: Contacto <contact@gofomorrosquillo.com>';

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
        $pass                   =   validateIsset($objDatos->password);
        $confirm_pass           =   validateIsset($objDatos->password_confirm);
        $role                   =   validateIsset($objDatos->rol) ;
        $telefono               =   validateIsset($objDatos->telefono);
        $birthdate              =   validateIsset($objDatos->birthdate);
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
        
        if( username_exists($username) ){
            $username = $username.$user_random;
        }

        if( email_exists($email) || $pass !== $confirm_pass || !is_email($email) ){
            
            $output  =  [ 'error' => 'email en uso' ];
                
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
            'role'                  =>  $role,
            'show_admin_bar_front'  =>  false 
        ]);

        if( is_wp_error($user_id) ){
            $output  =  [ 'error' => 'error register' ];
            wp_send_json($output);
            return;    
        }

        $output  =  [ 'success' => $user_id ];

        update_user_meta( $user_id, 'user_telefono', $telefono );
        update_user_meta( $user_id, 'user_birthdate', $birthdate );
        update_user_meta( $user_id, 'user_modo', $modo );
        update_user_meta( $user_id, 'user_intereses', $intereses );
        update_user_meta( $user_id, 'user_ciudad_visitar', $ciudad_visitar );
        update_user_meta( $user_id, 'user_conocimiento_pagina', $conocimiento_pagina );
        
        if($role === 'turista'){
            update_user_meta( $user_id, 'user_city_id', $city_id );
            update_user_meta( $user_id, 'user_state_id', $state_id );
        }
        if($role === 'comerciante'){
            update_user_meta( $user_id, 'document_type', $document_type );
            update_user_meta( $user_id, 'document_number', $document_number );
        }
        
        
        if($modo === 'directo'){
            /**test 
            $user   =   get_user_by( 'id', $user_id );
            wp_set_current_user( $user_id, $user->user_login );
            wp_set_auth_cookie( $user_id );
            do_action( 'wp_login', $user->user_login, $user );*/
            //wp_new_user_notification( $user_id, null, 'user' );
            
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
        
        
        $output     =     [ 'error' => 400 ];

        $nonce      =     isset($objDatos->_wpnonce) ? $objDatos->_wpnonce : '';
        
        if( !wp_verify_nonce( $nonce, 'serlib_auth' ) ){
           
            wp_send_json($output);
        }
        
        if( !isset( $objDatos->email, $objDatos->password ) ){
              echo 'sdf';
              wp_send_json($output);
        }

        $user                   =   wp_signon([
            'user_login'          =>  sanitize_text_field($objDatos->email),
            'user_password'       =>  sanitize_text_field($objDatos->password),
            'remember'            =>  boolval($objDatos->remembermme)
          ], false);

          if( is_wp_error($user) ){
            wp_send_json($output);
          }
        
          $output['success']       =   2;
          wp_send_json($output);

    }

    die();
}