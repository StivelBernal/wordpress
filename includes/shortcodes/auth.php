<?php

function serlib_footer_scripts(){

  // 70b319466e82d758dd86ee4988cb4161

  // google AIzaSyB8jiUEeoxqr4dvoNtJieG9gpOIZWr_xnU
  //497715945399-naggc6pk24b2hdlnld3n50cmeajmo4qs.apps.googleusercontent.com
  //gKuQGGvhvwp6pX2n5L5oYPkw
//INSTAGRAM
  // 1117533245288400
  // 92d0d55deb5af6c6a392e6ec81acb21d

  echo "<script>
              window.fbAsyncInit = function() {
              FB.init({
                  appId      : '808181629710199',
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


function serlib_login_form_shortcode(){
  if( is_user_logged_in() ){
    return '';
  }

  
  if(isset($_GET['code'])){

    define( 'INSTAGRAM_CS', '92d0d55deb5af6c6a392e6ec81acb21d' );
    define( 'INSTAGRAM_CID', '1117533245288400' );
    define( 'REDIRECT_URI', 'https://golfodemorrosquillo.com/auth/' ); 
    $code = str_replace('#_', '', $_GET['code']);
    $token = GetAccessToken( INSTAGRAM_CS, INSTAGRAM_CID, 'REDIRECT_URI', $code);
   // $datos = GetUserProfileInfo($token);
    var_dump($token);

    echo '<script> var Inst = "'.$_GET['code'].'"; </script>';

  }else{
    echo '<script> var Inst = false; </script>';
  }

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

function serlib_register_form_shortcode(){
    if( is_user_logged_in() ){
      return '';
    }
    add_action('wp_head', 'head_login_includes');
    add_action('wp_footer', 'serlib_footer_scripts');

    $formHTML = file_get_contents( 'templates/auth-register.php', true );
    
    $formHTML               = str_replace(
      ['register_has_I18N', 'turista_rol_I18N', 'required_I18N', 'email_error_I18N', 'password1_I18N',
       'comerciante_rol_I18N', 'registe_turista_I18N', 'or_register_with_I18N', 'nombre_I18N', 'apellido_I18N',
       'fecha_nacimiento_I18N', 'email_I18N', 'password_error_matchI18N', 'password_error_I18N', 'repeat_password_I18N',
       'telefono_I18N', 'terminos_condiciones_I18N', 'politica_privacidad_I18N', 'register_aditional_I18N', 'Departamento_I18N',
       'Ciudad_I18N', 'Conocimiento_pagina_I18N', 'Intereses_I18N', 'Ciudades a visitar_I18N', 'register_button_I18N', 'otro_I18N',
       'Tipo_documento_I18N', 'Numero_documento_I18N', 'Fotocopia_documento_I18N', 'Usuario_creado_I18N'], 
       [ 
         __('Registrarme como:', 'serlib'), __('Turista', 'serlib'), __('requerido', 'serlib'),
         __('Por favor coloca un email valido', 'serlib'), __('Contraseña', 'serlib'), __('Comerciante', 'serlib'),
         __('Registrarme como turista', 'serlib'), __('llena los siguientes campos, puedes autocompeltar con tus redes sociales', 'serlib'), __('Nombre', 'serlib'),
         __('Apellido', 'serlib'), __('Fecha de nacimiento', 'serlib'), __('Correo electrónico', 'serlib'), __('Las contraseñas no son iguales', 'serlib'),
         __('Por favor ingresa una contraseña que contenga, mayusculas, minisculas, un numero y mayor de 6 digitos', 'serlib'),
         __('Repetir contraseña', 'serlib'), __('Teléfono', 'serlib'), __('Términos y condiciones', 'serlib'), __('políticas de privacidad', 'serlib'), 
         __('Datos adicionales', 'serlib'), __('Departamento origen', 'serlib'), __('Ciudad origen', 'serlib'), __('Conocimiento de la página', 'serlib'), 
         __('Intereses', 'serlib'), __('Ciudades a visitar', 'serlib'), __('Registrarme', 'serlib'), __('¿ Cual ?', 'serlib'),
         __('Tipo de documento', 'serlib'), __('Número de documento', 'serlib'), __('Fotocopia del documento', 'serlib'), __('Usuario creado, redireccionando...', 'serlib')
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

  function GetAccessToken( $client_secret, $client_id, $redirect_uri, $code ) {		
    $url = 'https://api.instagram.com/oauth/access_token';
    //echo $code , $client_secret, $client_id, $redirect_uri;
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
   // if($http_code != '200')			
     // throw new Exception('Error : Failed to receieve access token');
    
    return $data;	
  }

  function GetUserProfileInfo($access_token) { 
    $url = 'https://api.instagram.com/v1/users/self/?access_token=' . $access_token;	
  
    $ch = curl_init();		
    curl_setopt($ch, CURLOPT_URL, $url);		
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);	
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    $data = json_decode(curl_exec($ch), true);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);	
    curl_close($ch); 
    if($data['meta']['code'] != 200 || $http_code != 200)
      throw new Exception('Error : Failed to get user information');
  
    return $data['data'];
  }