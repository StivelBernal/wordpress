<?php 


/**BUSCADORES */
function serlib_buscador_home_input_shortcode (){
  
  if(isset($_GET["busqueda"])){
    $rutas = explode('?' ,$_SERVER['REQUEST_URI']);
    $rutas = explode('/' ,$rutas[0]);
  }else{
    $rutas = explode('/' ,$_SERVER['REQUEST_URI']);
  }
 
  
  $slug = '';

  if(isset($rutas[1]) ){
    $municipio = get_term_by('slug', $rutas[1], 'category' );
  }else{
    $municipio = false;
  }

  if( isset($rutas[2]) && $rutas !== ''){
    $tipo_entrada = get_term_by('slug', $rutas[2], 'tipos_entradas' );
  }else{
    $tipo_entrada = false;
  }
  
  $formHTML = '';

	if( !$municipio && !$tipo_entrada ){
    $slug = '<div id="slug-search" slug="/"></div>';
    $formHTML = $slug.file_get_contents( 'templates/search-input-home.php', true );
    
  } else {

    if( !$tipo_entrada && $municipio ){
     
      $slug = '<div id="slug-search" slug="/'.$municipio->slug.'/"></div>';
      $formHTML = $slug.file_get_contents( 'templates/search-input-municipio.php', true );
    
    }else if($municipio && $tipo_entrada ){
      $slug = '<div id="slug-search" slug="/'.$municipio->slug.'/'.$tipo_entrada->slug.'/"></div>';
      $formHTML = $slug.file_get_contents( 'templates/search-input-tipo.php', true );
    
    }

   
  }

    
    
    $formHTML               = str_replace( 
      ['buscar_placeholder_I18N', 'buscar_button_I18N'], 
     [
      _x('¿Que buscas?', 'placeholder input form busqueda home', 'serlib'), 
      _x('Buscar', 'texto botón form busqueda home', 'serlib')
    ],
      $formHTML
    );

    $formHTML               = str_replace( 
      'NONCE_FIELD_PH', 
      wp_nonce_field( 'serlib_input_home', '_wpnonce', true, false ),
      $formHTML
    );
  
    return $formHTML;


}



/**
 * RESULTADOS HOME
 */
function serlib_buscador_home_results_shortcode(){
  
  $rutas = explode('/' ,$_SERVER['REQUEST_URI']);
  $slug = '';

  if(isset($rutas[1]) ){
    $municipio = get_term_by('slug', $rutas[1], 'category' );
  }


  if( isset($municipio) && $municipio !== false){
    global $wpdb;
    $categorias_publicacion = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta WHERE meta_value = ".$municipio->term_id." AND meta_key = 'municipio_relacion'" );
    
    $iconos = [];
    for($i = 0; $i < count($categorias_publicacion); $i++){
        
        $url = get_post_meta($categorias_publicacion[$i]->post_id, 'relacion_categoria' )[0];
        $titulo = explode('/' ,$url);
        $icono = wp_get_attachment_image_src( get_post_meta($categorias_publicacion[$i]->post_id, 'icono_publicacion_municipio' )[0], 'single-post-thumbnail')[0];
        $imagen =  wp_get_attachment_image_src( get_post_thumbnail_id( $categorias_publicacion[$i]->post_id ), 'medium' )[0];
        $iconos[$titulo[1]] = [ $url, $icono, $imagen ];
        
        
    }
   
    $formHTML = '
      <div class="row" id="search-results">
        <!--CONTROLADOR PARA MOSTRAR SERVICIOS-->
        <div class="row-wrap">
      ';
    
   // $formHTML .= file_get_contents( 'templates/results-home.php', true );

    // Obtener todas las categorias relacionadas a la categoria
    //var_dump($iconos);
    $items = '';
    
    foreach( $iconos as $key => $value ){
       
        $items .='
          <a  href="/'.$value[0].'" class="s-field">
              <div class="serlib-gallery-item">
                  <div class="serlib-simple-item-image">
                      <img class="fondo" src="'.$value[2].'" class="" >
                      <div class="serlib-gallery-simple-item-content-holder">
                          <div class="serlib-gallery-simple-item-content-inner">
                              <img class="icono" src="'.$value[1].'">
                              <div class="mkdf-tours-gallery-simple-title-holder">
                                  <h4 class="tipo_mun_title mkdf-tour-title">
                                  '. str_replace(['-', 'ion'], [' ', 'ión'], $key ) .' </h4>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </a>';

    }

      $formHTML .= $items.'
        </div>
      </div>
      ';

      return $formHTML;
  }
    
}

function serlib_buscador_home_results_blog_shortcode($atts){

  $a = shortcode_atts( array(
		'tipo_usuario' => 'alcaldia'
  ), $atts );
  
  $rutas = explode('/' ,$_SERVER['REQUEST_URI']);

  if(isset($rutas[1]) ){
    $municipio = get_term_by('slug', $rutas[1], 'category' );
  }
 
  if( !$municipio ){
   
    if($a['tipo_usuario'] === 'alcaldia'){
      $HTML = file_get_contents( 'templates/results-home-alcaldia.php', true );
    }else if($a['tipo_usuario'] === 'gobernacion'){

      $HTML = '<script>var carrusel_instancia = true;</script>'.file_get_contents( 'templates/results-home-gobernacion.php', true );

    }else if($a['tipo_usuario'] === 'aliado'){

      echo '<script> var aliado_carrusel = true;  </script>';
      
      $HTML = '<div class="mkdf-blog-holder mkdf-blog-standard-date-on-side entradas_tipo_usuario">
                  <div class="swiper-container-aliado">
                      <div class="swiper-wrapper">';

                         $posts   =   serlib_entries_array('aliado');

                         
                         $months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

                         $itemsCarrusel = '';
                         foreach ($posts as $key => $value) {
                
                         
                          $day = date("d", strtotime($value->post_date));
                          $month = date("n", strtotime($value->post_date));
                          $year = date("Y", strtotime($value->post_date));

                          $fecha = $months[$month-1].' '. $day.', '.$year;
                          $itemsCarrusel .= '
                          <div class="swiper-slide mkdf-team mkdf-item-space info-hover">
                            <div class="mkdf-team-inner">
                              <div class="mkdf-team-image">
                                  <img style="width:100%;" src="'.$value->thumbnail.'" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" >
                                  <div class="mkdf-team-info-tb">
                                      <div class="mkdf-team-info-tc">
                                          <div class="mkdf-team-title-holder">
                                              <h4 itemprop="name" class="mkdf-team-name entry-title">
                                                  <a itemprop="url" href="'.$value->permalink.'">'.$value->post_title.'</a>
                                              </h4>
                                              <h6>'.$fecha.'</h6>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>';
                  
                      }
                         

      $HTML .= $itemsCarrusel.'
                      </div>
                  </div>
              </div>';
    }
      
  }else{
   
    if($a['tipo_usuario'] === 'alcaldia'){ 
      $HTML = file_get_contents( 'templates/results-destino-alcaldia.php', true );

    }else if($a['tipo_usuario'] === 'gobernacion'){
      $HTML = file_get_contents( 'templates/results-destino-gobernacion.php', true );
    }else if($a['tipo_usuario'] === 'aliado'){
      echo '<script> var aliado_carrusel = true;  </script>';
      $HTML = '
      
      <div class="mkdf-blog-holder mkdf-blog-standard-date-on-side entradas_tipo_usuario">
                  <div class="swiper-container-aliado">
                      <div class="swiper-wrapper">
                         ';

                         $posts   =   serlib_entries_array('aliado');

                         $months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

                         $itemsCarrusel = '';
                         foreach ($posts as $key => $value) {
                
                         
                          $day = date("d", strtotime($value->post_date));
                          $month = date("n", strtotime($value->post_date));
                          $year = date("Y", strtotime($value->post_date));
                          
                          $fecha = $months[$month-1].' '. $day.', '.$year;
                          $itemsCarrusel .= '
                          <div class="swiper-slide mkdf-team mkdf-item-space info-hover">
                            <div class="mkdf-team-inner">
                              <div class="mkdf-team-image">
                                  <img style="width:100%;" src="'.$value->thumbnail.'" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" >
                                  <div class="mkdf-team-info-tb">
                                      <div class="mkdf-team-info-tc">
                                          <div class="mkdf-team-title-holder">
                                              <h4 itemprop="name" class="mkdf-team-name entry-title">
                                                  <a itemprop="url" href="'.$value->permalink.'">Aliados'.$value->post_title.'</a>
                                              </h4>
                                              <div class="detalles-post-slider">
                                                <span class="author"> <i class="fa fa-user" aria-hidden="true"></i>'.$value->author.' </span>
                                                <span class="fecha"> <i class="fa fa-calendar-check-o" aria-hidden="true"></i> '.$fecha.'</span>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                            </div>
                        </div>';
                  
                      }
                         

      $HTML .= $itemsCarrusel.'
                      </div>
                  </div>
              </div>
              
              ';
    }
   
  }

echo $HTML;

}



function serlib_entradas_user_shortcode($atts){

  $a = shortcode_atts( array(
		'id_user' => 0
  ), $atts );
  
  if($a['id_user'] === '0'){
    $HTML = file_get_contents( 'templates/results-home-alcaldia.php', true );
  }else if($a['tipo_usuario'] === 'gobernacion'){
    $HTML = file_get_contents( 'templates/results-home-gobernacion.php', true );
  }

return $HTML;

}


?>