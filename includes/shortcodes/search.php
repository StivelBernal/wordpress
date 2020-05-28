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
    <div class="row">
    <!--CONTROLADOR PARA MOSTRAR SERVICIOS-->
    <div class="row-wrap">
    ';

    $items = '';

    for($i = 0; $i < 10; $i++){
        $items .='
          <div class="s-20">
              <div class="serlib-gallery-item">
                  <div class="serlib-simple-item-image">
                      <img src="http://localhost/wordpress/wp-content/uploads/2017/08/h5-tour-f-img-1.jpg" class="" >
                      <span class="serlib-gallery-simple-item-top-holder">

                          <span class="mkdf-tours-item-text">$1870</span>                            

                      </span>
                      <div class="serlib-gallery-simple-item-content-holder">
                          <div class="serlib-gallery-simple-item-content-inner">
                              <h5 class="serlib-gallery-simple-item-destination-holder">

                                  <a class="mkdf-tour-item-destination" href="http://localhost/wordpress/index.php/destinations/discover-costa-rica/">
                                      Discover Costa Rica </a>

                              </h5>
                              <div class="mkdf-tours-gallery-simple-title-holder">
                                  <h4 class="mkdf-tour-title">
                                      Costarica, Panama </h4>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>';

      }
      $formHTML .= $items.'</div></div>';

    
    return $formHTML;
    
}


?>