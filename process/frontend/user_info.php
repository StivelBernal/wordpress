<?php

function custom_wpkses_post_tags( $tags, $context ) {

	if ( 'post' === $context ) {
		$tags['iframe'] = array(
			'src'             => true,
			'height'          => true,
			'width'           => true,
			'frameborder'     => true,
			'allowfullscreen' => true,
        );
        $tags['style'] = array(
            'src'             => true,
			'height'          => true,
			'width'           => true,
			'frameborder'     => true,
			'allowfullscreen' => true,
        );
	}

	return $tags;
}

add_filter( 'wp_kses_allowed_html', 'custom_wpkses_post_tags', 10, 2 );

function serlib_users_info(){
   
    $results = [];  
    $user =  wp_get_current_user();
    $method = $_SERVER['REQUEST_METHOD'];
    global $wpdb;
    
    if($user === 0){
        return;
    }
    
    $rol = $user->roles[0];
    if($rol === 'turista'){
        if( $method == 'GET' ){
            
            if( isset($_GET['ID']) && is_numeric($_GET['ID']) ){
            
                $query = 'SELECT * from '.$wpdb->prefix .'posts WHERE post_type = "blog" AND  post_author = '.$user->ID.'  AND ID = '.$_GET['ID'].'';
                $results['post'] =  $wpdb->get_row( $query );
                $terms = get_the_terms( $results['post']->ID , 'categorias_articulos', 'term_id' );
                for($i = 0; $i < count($terms); $i++ ) { 
                    $terms[$i] = $terms[$i]->term_id;
                }

                $results['post']->thumbnail = get_the_post_thumbnail_url($results['post']->ID);

                $results['post']->post_category = $terms;

            }else if( isset($_GET['post_type']) ){
            
                $query = 'SELECT * from '.$wpdb->prefix .'posts WHERE post_type = "blog" post_author = '.$user->ID.'  AND  post_type = "blog" ORDER BY post_date DESC';
                $results['posts'] =  $wpdb->get_results( $query );
                for($i = 0; $i < count($results['posts']); $i++){
                    $results['posts'][$i]->thumbnail = get_the_post_thumbnail_url($results['posts'][$i]->ID);
                    $results['posts'][$i]->permalink = get_permalink($results['posts'][$i]->ID);

                    /**Si role es = a turista si no entonces toca generar la consulta para entradas */
                    $results['posts'][$i]->post_category = get_the_terms( $results['posts'][$i]->ID , 'categorias_articulos' );
                }    
                
            }
            
            if( isset($_GET['categories'] )){
            
                $results['categories'] = get_terms([
                    'hide_empty' => false,
                    'order' => 'DESC',
                    'taxonomy' => 'categorias_articulos' ]);
                
            }
        
        }

        if( $method == 'POST' ){
    
            $objDatos = json_decode(file_get_contents("php://input"));
        
            $results = [ 'status' => 1 ];
        
            if( empty($objDatos->post_title) ){
                wp_send_json( $results );
            }

            
            $title  =   sanitize_text_field( $objDatos->post_title );
            $content    =   wp_kses_post( $objDatos->post_content );
            // OBTENER ROL Y VERIFICAR QUE LOS CONTENIDOS VENGAN BIEN
        
            if (is_array($objDatos->post_category)) {
                foreach ($objDatos->post_category as $key => $cat ) {
                    $cat = esc_attr($cat);
                }
            } else {
                $objDatos->post_category = esc_attr($objDatos->post_category);
            }
        
            $post_id                        =   wp_insert_post([
                'ID'                          =>    ($objDatos->ID ? $objDatos->ID: 0),
                'post_content'                =>    $content,
                'post_name'                   =>    $title,
                'post_title'                  =>    $title,
                'post_status'                 =>    'pending',
                'post_type'                   =>    'blog'
            ]);

        
            if( !is_wp_error($post_id) ){

                wp_set_post_terms($post_id, $objDatos->post_category, 'categorias_articulos');
            
                //update_post_meta( $post_id, 'ser_data', $ser_data );
                
                if( isset($_GET['id_featured']) && $_GET['id_featured'] !== 0 ){
                    require_once( ABSPATH . 'wp-admin/includes/image.php' );
                    set_post_thumbnail( $post_id, absint($_GET['id_featured']) );
                }
                
                $results['status']  =   2;
                $results['id']  =   $post_id;
                $results['permalink'] = get_permalink( $post_id );
            }

            

        }
    }
    
    if($rol === 'comerciante'){

        if( $method == 'GET' ){
            
            if( isset($_GET['ID']) && is_numeric($_GET['ID']) ){
            
                $query = 'SELECT * from '.$wpdb->prefix .'posts WHERE post_author = '.$user->ID.'  AND ID = '.$_GET['ID'].'';
                $results['post'] =  $wpdb->get_row( $query );
                $terms = get_the_terms( $results['post']->ID , 'category', 'term_id' );
                
                $results['post']->mapa_negocio = get_post_meta($results['post']->ID, 'mapa_negocio')[0];

                $results['post']->galery_ids = get_post_meta($results['post']->ID, 'galeria_negocio')[0];
                
                $results['post']->galery = [];
                
                for($i = 0; $i < count($results['post']->galery_ids); $i++ ) { 
                    $results['post']->galery[$i] = wp_get_attachment_image_src($results['post']->galery_ids[$i])[0];
                }

                $results['post']->servicios_negocio = get_post_meta($results['post']->ID, 'servicios_negocio')[0];                
                
                for($i = 0; $i < count($terms); $i++ ) { 
                    $terms[$i] = $terms[$i]->term_id;
                }

                $tipos_entradas = get_the_terms( $results['post']->ID , 'tipos_entradas', 'term_id' );
                
                for($i = 0; $i < count($tipos_entradas); $i++ ) { 
                    $tipos_entradas[$i] = $tipos_entradas[$i]->term_id;
                }

                $results['post']->thumbnail = get_the_post_thumbnail_url($results['post']->ID);

                $results['post']->post_category = $terms;

                $results['post']->tipo_entrada = $tipos_entradas;

            }else if( isset($_GET['post_type']) ){
            
                $query = 'SELECT * from '.$wpdb->prefix .'posts WHERE post_author = '.$user->ID.'  AND (post_type = "post") ORDER BY post_date DESC';
                $results['posts'] =  $wpdb->get_results( $query );
               
                for($i = 0; $i < count($results['posts']); $i++){
                    $results['posts'][$i]->thumbnail = get_the_post_thumbnail_url($results['posts'][$i]->ID);
                    $results['posts'][$i]->permalink = get_permalink($results['posts'][$i]->ID);

                    /**Si role es = a turista si no entonces toca generar la consulta para entradas */
                    //$results['posts'][$i]->post_category = get_the_terms( $results['posts'][$i]->ID , 'categorias_articulos' );
                }  

                
            }
            
            if( isset($_GET['municipios'] )){
            
                $results['municipios'] = get_terms([
                    'hide_empty' => false,
                    'order' => 'DESC',
                    'taxonomy' => 'category' ]);
                
            }
            if( isset($_GET['tipos'] )){
                
                $tipos_alcaldia = ['emergencias', 'transporte' ];

                $results['tipos'] = get_terms([
                    'hide_empty' => false,
                    'order' => 'DESC',
                    'taxonomy' => 'tipos_entradas' ]);
               
                for( $i = 0; $i < count($results['tipos']); $i++ ){
                 
                    if( in_array( $results['tipos'][$i]->slug, $tipos_alcaldia ) ) {
                        unset($results['tipos'][$i]);
                    }
                }

                $results['tipos'] = array_values($results['tipos']);
            }
        
        }

        if( $method == 'POST' ){
    
            $objDatos = json_decode(file_get_contents("php://input"));
            
            $results = [ 'status' => 1 ];
        
            if( empty($objDatos->post_title) ){
                wp_send_json( $results );
            }

            $title  =   sanitize_text_field( $objDatos->post_title );
            $content    =   wp_kses_post( $objDatos->post_content );
            $objDatos->mapa = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $objDatos->mapa);
            $mapa    =   wp_kses_post( $objDatos->mapa );
            $servicios = [];
            
            if(!empty($objDatos->servicios)){
                for($i = 0; $i < count($objDatos->servicios); $i++){
                    $servicios[$i] = sanitize_text_field($objDatos->servicios[$i]->text);
                }
            }
            
            // OBTENER ROL Y VERIFICAR QUE LOS CONTENIDOS VENGAN BIEN
        
            if (is_array($objDatos->post_category)) {
                foreach ($objDatos->post_category as $key => $cat ) {
                    $cat = esc_attr($cat);
                }
            } else {
                $objDatos->post_category = esc_attr($objDatos->post_category);
            }
        
            $post_id                        =   wp_insert_post([
                'ID'                          =>    ($objDatos->ID ? $objDatos->ID: 0),
                'post_content'                =>    $content,
                'post_name'                   =>    $title,
                'post_title'                  =>    $title,
                'post_status'                 =>    'pending',
                'post_type'                   =>    'post'
            ]);

            if( !is_wp_error($post_id) ){

                wp_set_post_terms($post_id, $objDatos->post_category, 'category');
                wp_set_post_terms($post_id, $objDatos->tipo_entrada, 'tipos_entradas');
                
            
                update_post_meta( $post_id, 'galeria_negocio', $objDatos->galery_ids );
                update_post_meta( $post_id, 'mapa_negocio', $mapa );
                update_post_meta( $post_id, 'servicios_negocio', $servicios );
                
                if( isset($_GET['id_featured']) && $_GET['id_featured'] !== 0 ){
                    require_once( ABSPATH . 'wp-admin/includes/image.php' );
                    set_post_thumbnail( $post_id, absint($_GET['id_featured']) );
                }
                
                $results['status']  =   2;
                $results['id']  =   $post_id;
                $results['permalink'] = get_permalink( $post_id );
            }

        }
    }

    if( $method == 'DELETE' ){
        $objDatos = json_decode(file_get_contents("php://input"));
        $nonce      =     isset($objDatos->_wpnonce) ? $objDatos->_wpnonce : '';
        
        if( !wp_verify_nonce( $nonce, 'serlib_form' ) ){
            wp_send_json('403');
        }   
       
        if( isset($objDatos->ID ) ){
    
            $objDatos->ID = $objDatos->ID->ID;
            $results =  $wpdb->query( 
                $wpdb->prepare( 
                    "
                        DELETE FROM $wpdb->posts
                        WHERE ID = %d
                        AND post_author = %d
                    ",
                    intval($objDatos->ID) ,  $user->ID )
            );
                   
            if($resulsts !== false && $results !== 0 ){
            
                $wpdb->query( 
                    $wpdb->prepare( 
                        "
                            DELETE FROM $wpdb->postmeta
                            WHERE post_id = %d
                        ",
                        intval($objDatos->ID) 
                        )
                );
            }
           
        }
    
    }


    wp_send_json($results);
    die();

}