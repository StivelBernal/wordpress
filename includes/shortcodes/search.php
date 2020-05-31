<?php 

function serlib_buscador_home_input_shortcode(){


    $formHTML = file_get_contents( 'templates/search-input.php', true );
    
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

function serlib_buscador_home_results_shortcode(){
    
  $formHTML = '
    <div class="row" id="search-results">
    <!--CONTROLADOR PARA MOSTRAR SERVICIOS-->
    <div class="row-wrap">
    ';
    
    $formHTML .= file_get_contents( 'templates/results-home.php', true );

    

    $items = '';
    $iconos = [
       'Hospedaje'    => ['hospedaje', 'https://golfodemorrosquillo.com/wp-content/uploads/2020/05/Hospedaje.png'],
       'Transporte'  => ['transporte' ,'https://golfodemorrosquillo.com/wp-content/uploads/2020/05/Transporte.png'],
       'Cultura'    => ['cultura' ,'https://golfodemorrosquillo.com/wp-content/uploads/2020/05/Cultura.png'],
       'Sitios'   => ['sitios' ,'https://golfodemorrosquillo.com/wp-content/uploads/2020/05/Sitios.png'], 
       'Diverisión'  => ['diversion' ,'https://golfodemorrosquillo.com/wp-content/uploads/2020/05/Diversion.png'],
       'Comercio'    => ['comercio' ,'https://golfodemorrosquillo.com/wp-content/uploads/2020/05/Comercio.png'],
       'Emergencias'   => ['emergencias' ,'https://golfodemorrosquillo.com/wp-content/uploads/2020/05/Emergencias.png'], 
       'Eventos'  => ['eventos' ,'https://golfodemorrosquillo.com/wp-content/uploads/2020/05/Eventos.png'],
       'Gastronomía'    => ['gastronomia' ,'https://golfodemorrosquillo.com/wp-content/uploads/2020/05/Gastronomia.png'],
       'Ferias y Fiestas'   => ['ferias-y-fiestas' ,'https://golfodemorrosquillo.com/wp-content/uploads/2020/05/Ferias-y-Fiestas.png']
    ];

    foreach( $iconos as $key => $value ){

        $items .='
          <a  base="'.$value[0].'" class="s-20 item-servicio-home">
              <div class="serlib-gallery-item">
                  <div class="serlib-simple-item-image">
                      <img class="fondo" src="http://localhost/wordpress/wp-content/uploads/2017/08/h5-tour-f-img-1.jpg" class="" >
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
      <div class="carrusel-destinos">
          <div class="swiper-container">
              <div class="swiper-wrapper">  
              </div>
          </div>
      </div>';

    
    return $formHTML;
    
}


?>