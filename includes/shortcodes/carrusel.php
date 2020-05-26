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
               
                <h3 class="title-destino">
                    '.$value->post_title.'
                </h3>
                <h5 class="subtitle-destino">
                    '.$value->post_name.'
                </h5>
                <a class="button-destino" href="/destino/'.$value->post_name.'" >
                    Ver ahora
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

