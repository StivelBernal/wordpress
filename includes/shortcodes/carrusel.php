<?php 

function serlib_carrusel_destinos_shortcode($atts){
    
     // Genero los valores por defecto de los parámetros
     $params = shortcode_atts( array(
        'LIMIT'        => 12  
    ), $atts );

    global $wpdb;

    $consulta   =    'SELECT * FROM  `'.$wpdb->prefix.'posts` WHERE (`post_type` = "destino" AND `post_status` = "publish") ORDER BY ID DESC LIMIT '.$params['LIMIT'].'';
    
    
    $destinos   =   $wpdb->get_results($consulta);
    $itemsCarrusel = '';

    foreach ($destinos as $key => $value) {
                
        $urlImg = get_the_post_thumbnail_url($value->ID);
        $itemsCarrusel .= '
        <div class="swiper-slide item-destino" style="background-image: url('.$urlImg.')">
            <div class="container-opts">
               
            <h3 class="mkdf-als-item-link-title"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Vacaciones en el mar</font></font></h3>
                <h5 class="mkdf-als-item-link-subtitle"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Simplemente hermoso</font></font></h5>
                <a class="mkdf-als-item-link mkdf-btn mkdf-btn-large mkdf-btn-solid" href="https://roam.qodeinteractive.com/tour-item/costarica-panama/" target="_self">
                    <span class="mkdf-als-item-link-text"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Reservar ahora</font></font></span>
                </a>
               
            </div>
        </div>';

    }
    
    return ' 
                <div class="carrusel-destinos">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                          '.$itemsCarrusel.'  
                        </div>
                    </div>
                </div>';

}

?>

