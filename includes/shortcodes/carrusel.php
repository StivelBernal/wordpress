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
    
    $rand = random_int(0,7);
    foreach ($destinos as $key => $value) {
                
        $urlImg = get_the_post_thumbnail_url($value->ID);
        $meta = get_post_meta( $value->ID);
       
        $categoria_link = get_category($meta['municipio'][0], 'ARRAY_A');
        
        if(!isset($meta['subtitle'])) {$meta['subtitle'][0] = $value->post_title; } 
      
       if($key !== $rand){
           $id = '';
       }else {  $id = 'id="default_destino"'; }
        $itemsCarrusel .= '
        <div class="swiper-slide item-destino" style="background-image: url('.$urlImg.')">
            <div class="container-opts">
               
                <h3 class="title-destino">
                    '.$value->post_title.'
                </h3>
                <h5 class="subtitle-destino">
                    '.$meta['subtitle'][0].'
                </h5>
                <a class="button-destino" '.$id.' href="'.$categoria_link['slug'].'" municipio="'.$value->post_title.'" excerpt="'.$value->post_excerpt.'" alcaldia="'.$meta['alcaldiau'][0].'" gobernacion="'.$meta['gobernacion'][0].'" departamento="'.$meta['departamento'][0].'">
                   '._x('Ver más', 'boton carrusel destinos', 'serlib').'
                </a>
            </div>
        </div>';

    }
    
    return  ' 
                <div class="carrusel-destinos">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                          '.$itemsCarrusel.'  
                        </div>
                    </div>
                </div>';

}

?>

