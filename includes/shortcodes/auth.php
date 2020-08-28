<?php

function serlib_footer_scripts(){
  
  $opts = get_option( 'serlib' );

  echo "<script>
              var google_key = '".$opts['google_key']."';

              window.fbAsyncInit = function() {
              FB.init({
                  appId      : '".$opts['facebook_api']."',
                  cookie     : true,
                  xfbml      : true,
                  version    : 'v6.0'
              });
                  
              FB.AppEvents.logPageView();   
                  
              };
          
              (function(d, s, id){
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) {return;}
              js = d.createElement(s); js.id = id;
              js.src = 'https://connect.facebook.net/en_US/sdk.js';
              fjs.parentNode.insertBefore(js, fjs);
              }(document, 'script', 'facebook-jssdk'));
          </script>";

}

function login_redirect() {
  /**Activar cuenta */
  if( isset($_GET['confirm'], $_GET['u']) && $_GET['u'] !== '' &&  $_GET['confirm'] !== ''){
    
    $user = base64_decode($_GET['u']);

    $code = base64_decode($_GET['confirm']);
  
    $user = get_user_by('login', $user);
  
    if(!$user) return '';
    
    $email = $user->data->user_email;
    
    if(md5($email) === $code ){

      for($i = 0; $i < count( $user->roles); $i++){
        
        if( $user->roles[$i] === 'pendiente' ){

          $u = new WP_User( $user->ID );
          $u->set_role( 'turista' );
    
          $i = count( $user->roles );
          
          wp_set_current_user( $user->ID, $user->data->user_login );
 
          wp_set_auth_cookie( $user->ID );
          do_action( 'wp_login', $user->data->user_login, $user );

          echo '<script> window.location = "/gracias?pending"; </script>';
        } 
       
      } 

    }
   
    return '';
    
  }
}

function serlib_recover_account_shortcode(){
  if( is_user_logged_in() ){
    return '';
  }
  add_action('wp_footer', 'serlib_footer_scripts');

  $formHTML = file_get_contents( 'templates/auth-recover.php', true );

  if( isset($_GET['code'], $_GET['u']) && $_GET['u'] !== '' &&  $_GET['code'] !== ''){
    
    $user = base64_decode($_GET['u']);

    $code = base64_decode($_GET['code']);

    $user = get_user_by('login', $user);

    if($user){

      $codeU = $user->data->user_login.$user->ID.$user->data->user_email.$user->data->user_pass;
      
      if(md5($codeU) === $code ){
        echo '<script> var o = { code: "'.$code.'", u: "'.$_GET['u'].'"  };</script>';
        $formHTML = file_get_contents( 'templates/auth-form-reset-password.php', true );
      }
    }
    
  }

  $formHTML               = str_replace(
    ['recover_account_I18N', 'email_I18N', 'required_I18N', 'email_error_I18N', 'recover_I18N', 'email_info_I18N',
      'reset_pass_I18N', 'password1_I18N', 'password_error_I18N', 'repeat_password_I18N', 'password_error_matchI18N'],
    [ 
      __('Recuperar Cuenta', 'serlib'), __('Correo electrónico', 'serlib'), __('requerido', 'serlib'),
      __('Por favor coloca un email valido', 'serlib'), __('Recuperar', 'serlib'),
      __('Hemos enviado un correo electronico con la información para recuperar tu cuenta', 'serlib'),
      __('Establecer nueva contraseña', 'serlib'), __('Contraseña', 'serlib'), 
      __('Por favor ingresa una contraseña que contenga, mayusculas, minisculas, un numero y mayor de 6 digitos', 'serlib'),
      __('Repetir contraseña', 'serlib'), __('Las contraseñas no son iguales', 'serlib')
    ],
    $formHTML
  );

  $formHTML               = str_replace( 
    'NONCE_FIELD_PH', 
    wp_nonce_field( 'serlib_auth', '_wpnonce', true, false ),
    $formHTML
  );

  return $formHTML;
}


function serlib_login_form_shortcode(){
  if( is_user_logged_in() ){
    return '';
  }

  $opts = get_option( 'serlib' );

  if(isset($_GET['code'])){


    define( 'INSTAGRAM_CS', $opts['instagram_client_secret'] );
    define( 'INSTAGRAM_CID',  $opts['instagram_client_id'] );
    define( 'REDIRECT_URI', $opts['instagram_redirect_uri'] ); 
    $code = str_replace('#_', '', $_GET['code']);
    $token = GetAccessToken( INSTAGRAM_CS, INSTAGRAM_CID, REDIRECT_URI, $code);
   /*$token = [
    'access_token' => 'IGQVJVUlpKWlZAvSENlRnI4U2swUkpReWlCTGZAMdTRIeEtiVVlDT1hCUlhrNzRiaFFyVUtneG95Vy02SkFVbXdVU2tmSXRlcTNLa1N6TkpqbE5vaVlTZAEpzU1UxcXRnWDl2MW1Pc0hpeFlQYUg2aG1yRkVfaXRqRWxMVjJv',
    'user_id' => 17841433887861158
   ];*/

    if(isset($token) ){ 
      $datos = GetUserProfileInfo($token);
      
      echo '<script> var Inst = '.json_encode($datos, true).'; </script>';
     
    }else{
      echo 'Error : Failed to receieve access token'; 
    }
 
  }else{
    echo '<script> var Inst = false; </script>';
  }
  /**Activar cuenta */
  add_action('wp_footer', 'serlib_footer_scripts');

  $formHTML               = file_get_contents( 'templates/auth-login.php', true );

  $formHTML               = str_replace(
    ['login_I18N', 'email_I18N', 'required_I18N', 'email_error_I18N', 'password_I18N', 'Inicio_de_session_I18N',
     'Remember_me_I18N', 'Lost_your_pass_I18N', 'or_login_with_I18N', 'No_tienes_cuenta_I18N', 'Registerme_I18N'],
     [ 
       __('Iniciar sesión', 'serlib'), __('Correo electrónico', 'serlib'), __('requerido', 'serlib'),
       __('Por favor coloca un email valido', 'serlib'), __('Contraseña', 'serlib'), __('Inicio de sesión exitoso', 'serlib'), __('Recuerdame', 'serlib'),
       __('Olvidaste tu contraseña', 'serlib'), __('o iniciar sesión con', 'serlib'), __('No tienes cuenta', 'serlib'),
       __('Registrate', 'serlib') 
     ],
    $formHTML
  );

  $formHTML               = str_replace( 
    'NONCE_FIELD_PH', 
    wp_nonce_field( 'serlib_auth', '_wpnonce', true, false ),
    $formHTML
  );

  return $formHTML;
}

/**Mensaje */
function serlib_register_gracias_shortcode(){

  if( is_user_logged_in() ){
    return '';
  }

  $formHTML = file_get_contents( 'templates/thanks-message.php', true );
  
  if(isset($_GET['pending'])){

    if($_GET['pending'] === 'comerciante'){
       $formHTML  = str_replace( ['gracias_I18N', 'parrafo_I18N', 'ir_al_inicio_I18N'],
       [__('Gracias', 'serlib'), __('Se revisará tu información para activar la cuenta', 'serlib'), __('Ir al Inicio', 'serlib') ], 
        $formHTML );
    }
    if($_GET['pending'] === 'turista'){
      $formHTML  = str_replace( ['gracias_I18N', 'parrafo_I18N', 'ir_al_inicio_I18N'],
        [__('Gracias', 'serlib'), __('Por favor revisa el enlace enviado a tu correo electronico para activar la cuenta', 'serlib'),
        __('Ir al Inicio', 'serlib') ], 
        $formHTML );
    }
    if($_GET['pending'] === ''){
      $formHTML  = str_replace(
       ['gracias_I18N', 'parrafo_I18N', 'ir_al_inicio_I18N'],
       [__('Gracias', 'serlib'), __('ya estas registrado.', 'serlib'), __('Ir al Inicio', 'serlib')  ],
       $formHTML );
    }
  
    return $formHTML;
  
  }else{
    return '';
  }

  

}


function serlib_register_form_shortcode(){
    if( is_user_logged_in() ){
      return '';
    }
    add_action('wp_footer', 'serlib_footer_scripts');

    $formHTML = file_get_contents( 'templates/auth-register.php', true );
    
    $formHTML  = str_replace(
      ['register_has_I18N', 'turista_rol_I18N', 'required_I18N', 'email_error_I18N', 'password1_I18N',
       'comerciante_rol_I18N', 'registe_turista_I18N', 'or_register_with_I18N', 'nombre_I18N', 'apellido_I18N',
       'fecha_nacimiento_I18N', 'email_I18N', 'password_error_matchI18N', 'password_error_I18N', 'repeat_password_I18N',
       'telefono_I18N', 'terminos_condiciones_I18N', 'politica_privacidad_I18N', 'register_aditional_I18N', 'Departamento_I18N',
       'Ciudad_I18N', 'Conocimiento_pagina_I18N', 'Intereses_I18N', 'Ciudades a visitar_I18N', 'register_button_I18N', 'otro_I18N',
       'Tipo_documento_I18N', 'Numero_documento_I18N', 'Fotocopia_documento_I18N', 'Usuario_creado_I18N', 'register_comerciante_I18N', 'register_turista_I18N', 'Ubicacion_negocios_I18N'], 
       [ 
         __('Registrarme como:', 'serlib'), __('Turista', 'serlib'), __('requerido', 'serlib'),
         __('Por favor coloca un email valido', 'serlib'), __('Contraseña', 'serlib'), __('Comerciante', 'serlib'),
         __('Registrarme como turista', 'serlib'), __('llena los siguientes campos, puedes autocompletar con tus redes sociales', 'serlib'), __('Nombre', 'serlib'),
         __('Apellido', 'serlib'), __('Fecha de nacimiento', 'serlib'), __('Correo electrónico', 'serlib'), __('Las contraseñas no son iguales', 'serlib'),
         __('Por favor ingresa una contraseña que contenga, mayusculas, minisculas, un numero y mayor de 6 digitos', 'serlib'),
         __('Repetir contraseña', 'serlib'), __('Teléfono', 'serlib'), __('Términos y condiciones', 'serlib'), __('políticas de privacidad', 'serlib'), 
         __('Datos adicionales', 'serlib'), __('Departamento origen', 'serlib'), __('Ciudad origen', 'serlib'), __('Conocimiento de la página', 'serlib'), 
         __('Intereses', 'serlib'), __('Ciudades a visitar', 'serlib'), __('Registrarme', 'serlib'), __('¿ Cual ?', 'serlib'),
         __('Tipo de documento', 'serlib'), __('Número de documento', 'serlib'), __('Fotocopia del documento', 'serlib'), __('Usuario creado, redireccionando...', 'serlib')
         , __('Registro Comerciante', 'serlib'), __('Registro como turista', 'serlib'), __('Ubicación de negocios', 'serlib')
       ],
      $formHTML
    );

    $formHTML = str_replace( 
      'NONCE_FIELD_PH', 
      wp_nonce_field( 'serlib_auth', '_wpnonce', true, false ),
      $formHTML
    );
  
    return $formHTML;
  }

  /**INSTAGRAM */

  function GetAccessToken( $client_secret, $client_id, $redirect_uri, $code ) {		
    $url = 'https://api.instagram.com/oauth/access_token';
    $curlPost = 'client_id='. $client_id . '&redirect_uri=' . $redirect_uri . '&client_secret=' . $client_secret . '&code='. $code . '&grant_type=authorization_code';
    $ch = curl_init();		
    curl_setopt($ch, CURLOPT_URL, $url);		
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);		
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);			
    $data = json_decode(curl_exec($ch), true);	
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);	
    curl_close($ch); 
    if($http_code !== 200){
      return NULL;
    }else{
      return $data;
    } 

  }

  function longLiveToken( $token, $cs ) { 
    $url = 'https://graph.instagram.com/oauth/access_token?grant_type=ig_exchange_token&client_secret='.$cs.'&access_token='.$token["access_token"];	
  
    $ch = curl_init();		
    curl_setopt($ch, CURLOPT_URL, $url);		
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);	
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $data = json_decode(curl_exec($ch), true);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);	
    curl_close($ch); 
    if($http_code == 200){ return $data; }else { return NULL; }
     
  }

  function GetUserProfileInfo( $token ) { 
    $url = 'https://graph.instagram.com/'.$token["user_id"].'?fields=id,username&access_token=' . $token["access_token"];	
  
    $ch = curl_init();		
    curl_setopt($ch, CURLOPT_URL, $url);		
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);	
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $data = json_decode(curl_exec($ch), true);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);	

    curl_close($ch); 
    if($http_code !== 200)
      echo 'Error : Failed to get user information';

    return $data;
  }