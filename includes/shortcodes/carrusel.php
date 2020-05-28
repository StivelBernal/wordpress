<?php 

function serlib_carrusel_destinos_shortcode($atts){
    
     // Genero los valores por defecto de los parámetros
     $params = shortcode_atts( array(
        'LIMIT'        => 12  
    ), $atts );

    global $wpdb;

    $consulta   =    'SELECT * FROM  `'.$wpdb->prefix.'posts` WHERE (`post_type` = "destino" AND `post_status` = "publish") ORDER BY post_date DESC LIMIT '.$params['LIMIT'].'';
    
    $destinos   =   $wpdb->get_results($consulta);
    $itemsCarrusel = '';   

    foreach ($destinos as $key => $value) {
                
        $urlImg = get_the_post_thumbnail_url($value->ID);
        $subtitle = get_post_meta( $value->ID, 'subtitle');
        if(!isset($subtitle[0])) {$subtitle[0] = $value->post_title; } 
       
        $itemsCarrusel .= '
        <div class="swiper-slide item-destino" style="background-image: url('.$urlImg.')">
            <div class="container-opts">
               
                <h3 class="title-destino">
                    '.$value->post_title.'
                </h3>
                <h5 class="subtitle-destino">
                    '.$subtitle[0].'
                </h5>
                <a class="button-destino" href="/destinos/'.$value->post_name.'" >
                   '._x('Ver más', 'boton carrusel', 'serlib').'
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

