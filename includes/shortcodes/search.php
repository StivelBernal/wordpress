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
        $iconos[$titulo[1]] = [ $url, $icono, $imagen];
        
        var_dump($categorias_publicacion[$i]->post_id);
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
                                  <h4 class="mkdf-tour-title">
                                  '.$key.' </h4>
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
    }
      
  }else{
   
    if($a['tipo_usuario'] === 'alcaldia'){ 
      $HTML = file_get_contents( 'templates/results-destino-alcaldia.php', true );

    }else if($a['tipo_usuario'] === 'gobernacion'){
      $HTML = file_get_contents( 'templates/results-destino-gobernacion.php', true );
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