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
            
                $query = 'SELECT * from '.$wpdb->prefix .'posts WHERE post_author = '.$user->ID.'  AND  post_type = "blog" ORDER BY post_date DESC';
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
                'post_type'                   =>    'blog',
                'comment_status'              =>    'open'
            ]);

        
            if( !is_wp_error($post_id) ){


                enviar_email_notificacione_staff('Nuevo publicacion de turista por aprobar');

                wp_set_post_terms($post_id, $objDatos->post_category, 'categorias_articulos');
            
                //update_post_meta( $post_id, 'ser_data', $ser_data );
                
                if( isset($_GET['id_featured']) && $_GET['id_featured'] !== 0 ){
                    require_once( ABSPATH . 'wp-admin/includes/image.php' );
                    set_post_thumbnail( $post_id, absint($_GET['id_featured']) );
                }else{
                    require_once( ABSPATH . 'wp-admin/includes/image.php' );
                    set_post_thumbnail( $post_id, 637 );
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
                $terms = get_the_terms( $results['post']->ID , 'category' );
               
                $tags = get_the_terms( $results['post']->ID , 'post_tag' );
                


                $results['post']->mapa_negocio = get_post_meta($results['post']->ID, 'mapa_negocio')[0];

                $results['post']->galery_ids = get_post_meta($results['post']->ID, 'galeria_negocio')[0];
                
                $results['post']->galery = [];
                
                for($i = 0; $i < count($results['post']->galery_ids); $i++ ) { 
                    $results['post']->galery[$i] = wp_get_attachment_image_src($results['post']->galery_ids[$i])[0];
                }

                $results['post']->servicios = get_post_meta($results['post']->ID, 'servicios_negocio')[0];  
                
                
                $results['post']->telefono = get_post_meta($results['post']->ID, 'telefono_negocio')[0];  
                $results['post']->whatsapp = get_post_meta($results['post']->ID, 'whatsapp_negocio')[0];  
                $results['post']->facebook = get_post_meta($results['post']->ID, 'facebook_negocio')[0];  
                $results['post']->web = get_post_meta($results['post']->ID, 'web_negocio')[0];  
                $results['post']->correo = get_post_meta($results['post']->ID, 'correo_negocio')[0];  
                $results['post']->direccion = get_post_meta($results['post']->ID, 'direccion_negocio')[0]; 
                $results['post']->instagram = get_post_meta($results['post']->ID, 'instagram_negocio')[0];  
              
                for($i = 0; $i < count($terms); $i++ ) { 
                    $terms[$i] = $terms[$i]->term_id;
                }

                $tipos_entradas = get_the_terms( $results['post']->ID , 'tipos_entradas' );
                
                for($i = 0; $i < count($tipos_entradas); $i++ ) { 
                    $tipos_entradas[$i] = $tipos_entradas[$i]->term_id;
                }
               
                for($i = 0; $i < count($tags); $i++ ) { 
                    $tags[$i] = $tags[$i]->term_id;
                }

                $results['post']->thumbnail = get_the_post_thumbnail_url($results['post']->ID);

                $results['post']->post_category = $terms;

                $results['post']->tags = $tags;

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
                    'exclude' => [1, 28],
                    'taxonomy' => 'category' ]);

                $results['tags'] = get_terms('post_tag', [
                    'hide_empty' => false,
                    'order' => 'DESC']);
                
            }


            if( isset($_GET['tipos'] )){
                
                $tipos_alcaldia = ['emergencias', 'ferias-y-fiestas', 'cultura', 'sitios'  ];

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
            $excerpt = sanitize_text_field( $objDatos->post_excerpt );
            $content    =   wp_kses_post( $objDatos->post_content );
            $mapa    =   sanitize_text_field( $objDatos->mapa );
            $telefono    =   sanitize_text_field( $objDatos->telefono );
            $whatsapp    =   sanitize_text_field( $objDatos->whatsapp );
            $facebook    =   sanitize_text_field( $objDatos->facebook );
            $web    =   sanitize_text_field( $objDatos->web );
            $correo    =   sanitize_text_field( $objDatos->correo );
            $direccion    =   sanitize_text_field( $objDatos->direccion );
            $instagram    =   sanitize_text_field( $objDatos->instagram );

            $servicios  = [];
            
            if(!empty($objDatos->servicios)){
                for($i = 0; $i < count($objDatos->servicios); $i++){
                   
                    $servicios[$i]->title = sanitize_text_field($objDatos->servicios[$i]->title);
                    $servicios[$i]->text = sanitize_text_field($objDatos->servicios[$i]->text);
                    $servicios[$i]->price = sanitize_text_field($objDatos->servicios[$i]->price);
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

            if (is_array($objDatos->tags)) {
                foreach ($objDatos->tags as $key => $tag ) {
                    $tag = esc_attr($tag);
                }
            } else {
                $objDatos->tags = esc_attr($objDatos->tags);
            }
            
            remove_action( 'save_post_post', 'ser_save_post_admin' );
        
            $post_id                        =   wp_insert_post([
                'ID'                          =>    ($objDatos->ID ? $objDatos->ID: 0),
                'post_content'                =>    $content,
                'post_name'                   =>    $title,
                'post_title'                  =>    $title,
                'post_excerpt'                =>    $excerpt,
                'post_status'                 =>    'pending',
                'post_type'                   =>    'post',
                'comment_status'              =>    'open'
            ]);
            
            add_action( 'save_post_post', 'ser_save_post_admin' );

            
            if( !is_wp_error($post_id) ){
                
                enviar_email_notificacione_staff('Nuevo publicación de comerciante por aprobar');

                wp_set_post_terms($post_id, $objDatos->post_category, 'category');
                wp_set_post_terms($post_id, $objDatos->tipo_entrada, 'tipos_entradas');
                wp_set_post_terms($post_id, $objDatos->tags, 'post_tag');
                
                update_post_meta( $post_id, 'telefono_negocio', $telefono );
                update_post_meta( $post_id, 'whatsapp_negocio', $whatsapp );
                update_post_meta( $post_id, 'facebook_negocio', $facebook );
                update_post_meta( $post_id, 'web_negocio', $web );
                update_post_meta( $post_id, 'correo_negocio', $correo );
                update_post_meta( $post_id, 'direccion_negocio', $direccion );
                update_post_meta( $post_id, 'instagram_negocio', $instagram );

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


    if($rol === 'aliado'){
        if( $method == 'GET' ){
            
            if( isset($_GET['ID']) && is_numeric($_GET['ID']) ){
            
                $query = 'SELECT * from '.$wpdb->prefix .'posts WHERE post_author = '.$user->ID.'  AND ID = '.$_GET['ID'].'';
                $results['post'] =  $wpdb->get_row( $query );
                $terms = get_the_terms( $results['post']->ID , 'category', 'term_id' );             
                
                for($i = 0; $i < count($terms); $i++ ) { 
                    $terms[$i] = $terms[$i]->term_id;
                }

                $tipos_entradas = get_the_terms( $results['post']->ID , 'tipos_entradas', 'term_id' );

                for($i = 0; $i < count($tipos_entradas); $i++ ) { 
                    $tipos_entradas[$i] = $tipos_entradas[$i]->term_id;
                }

                $results['post']->thumbnail = get_the_post_thumbnail_url($results['post']->ID);

                $results['post']->telefono = get_post_meta($results['post']->ID, 'telefono_negocio')[0];  
                $results['post']->whatsapp = get_post_meta($results['post']->ID, 'whatsapp_negocio')[0];  
                $results['post']->facebook = get_post_meta($results['post']->ID, 'facebook_negocio')[0];  
                $results['post']->web = get_post_meta($results['post']->ID, 'web_negocio')[0];  
                $results['post']->correo = get_post_meta($results['post']->ID, 'correo_negocio')[0];  
                $results['post']->direccion = get_post_meta($results['post']->ID, 'direccion_negocio')[0]; 
                $results['post']->instagram = get_post_meta($results['post']->ID, 'instagram_negocio')[0]; 
                $results['post']->mapa_negocio = get_post_meta($results['post']->ID, 'mapa_negocio')[0];
                $results['post']->post_category = $terms;

                $results['post']->tipo_entrada = $tipos_entradas;

            }else if( isset($_GET['post_type']) ){
            
                $query = 'SELECT * from '.$wpdb->prefix .'posts WHERE post_author = '.$user->ID.'  AND (post_type = "post") ORDER BY post_date DESC';
                $results['posts'] =  $wpdb->get_results( $query );
               
                for($i = 0; $i < count($results['posts']); $i++){
                    $results['posts'][$i]->thumbnail = get_the_post_thumbnail_url($results['posts'][$i]->ID);
                    $results['posts'][$i]->permalink = get_permalink($results['posts'][$i]->ID);
                }  
                
            }
            
            if( isset($_GET['municipios'] )){


                $results['municipios'] = get_terms([
                    'hide_empty' => false,
                    'order' => 'DESC',
                    'exclude' => [1, 28],
                    'taxonomy' => 'category' ]);
                
            }

            if( isset($_GET['tipos'] )){

                $user = wp_get_current_user();
                $roles =  $user->roles[0];
                
                $tipos_aliado = [ 'ferias-y-fiestas', 'cultura', 'eventos' ];
                $arrayTaxAlcaldia = [];
                $results['tipos'] = get_terms([
                    'hide_empty' => false,
                    'order' => 'DESC',
                    'taxonomy' => 'tipos_entradas' ]);
                    
                for( $i = 0; $i < count($results['tipos']); $i++ ){
                    
                    if( in_array( $results['tipos'][$i]->slug, $tipos_aliado ) ) { 
                        //var_dump(in_array( $results['tipos'][$i]->slug, $tipos_alcaldia));
                        array_push($arrayTaxAlcaldia,  $results['tipos'][$i] );
                    }

                }

                $results['tipos'] = $arrayTaxAlcaldia;
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
            $excerpt = sanitize_text_field( $objDatos->post_excerpt );
            $mapa    =   sanitize_text_field( $objDatos->mapa );
            $telefono    =   sanitize_text_field( $objDatos->telefono );
            $whatsapp    =   sanitize_text_field( $objDatos->whatsapp );
            $facebook    =   sanitize_text_field( $objDatos->facebook );
            $web    =   sanitize_text_field( $objDatos->web );
            $correo    =   sanitize_text_field( $objDatos->correo );
            $direccion    =   sanitize_text_field( $objDatos->direccion );
            $instagram    =   sanitize_text_field( $objDatos->instagram );
                        
            if (is_array($objDatos->post_category)) {
                foreach ($objDatos->post_category as $key => $cat ) {
                    $cat = esc_attr($cat);
                }
            } else {
                $objDatos->post_category = esc_attr($objDatos->post_category);
            }

            remove_action( 'save_post_post', 'ser_save_post_admin' );
        
            if($objDatos->post_category === 'emergencias'){
                $post_id                        =   wp_insert_post([
                    'ID'                          =>    ($objDatos->ID ? $objDatos->ID: 0),
                    'post_content'                =>    $content,
                    'post_name'                   =>    $title,
                    'post_title'                  =>    $title,
                    'post_excerpt'                =>    $excerpt,
                    'post_status'                 =>    'pending',
                    'post_type'                   =>    'post',
                    'comment_status'              =>    'closed'
                 ]);
            }else{
                $post_id                        =   wp_insert_post([
                    'ID'                          =>    ($objDatos->ID ? $objDatos->ID: 0),
                    'post_content'                =>    $content,
                    'post_name'                   =>    $title,
                    'post_title'                  =>    $title,
                    'post_excerpt'                =>    $excerpt,
                    'post_status'                 =>    'pending',
                    'post_type'                   =>    'post',
                    'comment_status'              =>    'open'
                 ]);
            }
            
            add_action( 'save_post_post', 'ser_save_post_admin' );

            if( !is_wp_error($post_id) ){

                enviar_email_notificacione_staff('Nuevo publicacion de aliado por aprobar');

                wp_set_post_terms($post_id, $objDatos->post_category, 'category');
                wp_set_post_terms($post_id, $objDatos->tipo_entrada, 'tipos_entradas');
                wp_set_post_terms($post_id, $objDatos->tags, 'post_tag');
             
                update_post_meta( $post_id, 'telefono_negocio', $telefono );
                update_post_meta( $post_id, 'whatsapp_negocio', $whatsapp );
                update_post_meta( $post_id, 'facebook_negocio', $facebook );
                update_post_meta( $post_id, 'web_negocio', $web );
                update_post_meta( $post_id, 'correo_negocio', $correo );
                update_post_meta( $post_id, 'direccion_negocio', $direccion );
                update_post_meta( $post_id, 'instagram_negocio', $instagram );
                update_post_meta( $post_id, 'mapa_negocio', $mapa );
            

                wp_set_post_terms($post_id, $objDatos->post_category, 'category');
                wp_set_post_terms($post_id, $objDatos->tipo_entrada, 'tipos_entradas');

                  
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

    if($rol === 'alcaldia' || $rol === 'gobernacion'){

        if( $method == 'GET' ){
            
            if( isset($_GET['ID']) && is_numeric($_GET['ID']) ){
            
                $query = 'SELECT * from '.$wpdb->prefix .'posts WHERE post_author = '.$user->ID.'  AND ID = '.$_GET['ID'].'';
                $results['post'] =  $wpdb->get_row( $query );
                $terms = get_the_terms( $results['post']->ID , 'category', 'term_id' );             
                
                for($i = 0; $i < count($terms); $i++ ) { 
                    $terms[$i] = $terms[$i]->term_id;
                }

                $tipos_entradas = get_the_terms( $results['post']->ID , 'tipos_entradas', 'term_id' );
                
                for($i = 0; $i < count($tipos_entradas); $i++ ) { 
                    $tipos_entradas[$i] = $tipos_entradas[$i]->term_id;
                }

                $results['post']->thumbnail = get_the_post_thumbnail_url($results['post']->ID);
                $results['post']->telefono = get_post_meta($results['post']->ID, 'telefono_negocio')[0];  
                $results['post']->whatsapp = get_post_meta($results['post']->ID, 'whatsapp_negocio')[0];  
                $results['post']->facebook = get_post_meta($results['post']->ID, 'facebook_negocio')[0];  
                $results['post']->web = get_post_meta($results['post']->ID, 'web_negocio')[0];  
                $results['post']->correo = get_post_meta($results['post']->ID, 'correo_negocio')[0];  
                $results['post']->direccion = get_post_meta($results['post']->ID, 'direccion_negocio')[0]; 
                $results['post']->instagram = get_post_meta($results['post']->ID, 'instagram_negocio')[0]; 
                $results['post']->mapa_negocio = get_post_meta($results['post']->ID, 'mapa_negocio')[0];
                $results['post']->post_category = $terms;

                $results['post']->tipo_entrada = $tipos_entradas;

            }else if( isset($_GET['post_type']) ){
            
                $query = 'SELECT * from '.$wpdb->prefix .'posts WHERE post_author = '.$user->ID.'  AND (post_type = "post") ORDER BY post_date DESC';
                $results['posts'] =  $wpdb->get_results( $query );
               
                for($i = 0; $i < count($results['posts']); $i++){
                    $results['posts'][$i]->thumbnail = get_the_post_thumbnail_url($results['posts'][$i]->ID);
                    $results['posts'][$i]->permalink = get_permalink($results['posts'][$i]->ID);
                }  
                
            }
            
            if( isset($_GET['municipios'] )){

                $mun_temp = [];
                $results['municipios'] = [];
                /** 
                 * TRAER TODOS LOS DESTINOS DESPUES ITERAR TRAER META Y HACER UN ARRAY PUSH 
                */
                $args = array(
                    'post_type'     => 'destino',
                    'numberposts'   => '20'
                );
                
                $municipios_relacionados =  get_posts($args);
                if( $rol === 'alcaldia' ){
                    
                    for ($i=0; $i < count($municipios_relacionados); $i++) { 

                        if( get_post_meta( $municipios_relacionados[$i]->ID, 'alcaldiau' )[0] === ( get_current_user_id().'') ){
    
                            array_push( $results['municipios'], get_term_by('id', get_post_meta($municipios_relacionados[$i]->ID, 'municipio')[0], 'category' ) );
                            
                        }
                          
                    }

                }

                if( $rol === 'gobernacion' ){
                    
                    for ($i=0; $i < count($municipios_relacionados); $i++) { 

                        if( get_post_meta( $municipios_relacionados[$i]->ID, 'gobernacion' )[0] === ( get_current_user_id().'') ){
    
                            array_push( $results['municipios'], get_term_by('id', get_post_meta($municipios_relacionados[$i]->ID, 'municipio')[0], 'category' ) );
                            
                        }
                          
                    }

                }
               
                
            }

            if( isset($_GET['tipos'] )){

                $user = wp_get_current_user();
                $roles =  $user->roles[0];
                
                $tipos_alcaldia = ['emergencias', 'transporte', 'eventos', 'cultura', 'sitios', 'ferias-y-fiestas'  ];
                $arrayTaxAlcaldia = [];
                $results['tipos'] = get_terms([
                    'hide_empty' => false,
                    'exclude' => [1, 28],
                    'order' => 'DESC',
                    'taxonomy' => 'tipos_entradas' ]);
                    
                for( $i = 0; $i < count($results['tipos']); $i++ ){
                    
                    if( in_array( $results['tipos'][$i]->slug, $tipos_alcaldia ) ) { 
                        //var_dump(in_array( $results['tipos'][$i]->slug, $tipos_alcaldia));
                        array_push($arrayTaxAlcaldia,  $results['tipos'][$i] );
                    }

                }

                $results['tipos'] = $arrayTaxAlcaldia;
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
            $excerpt = sanitize_text_field( $objDatos->post_excerpt );
            $mapa    =   sanitize_text_field( $objDatos->mapa );
            $telefono    =   sanitize_text_field( $objDatos->telefono );
            $whatsapp    =   sanitize_text_field( $objDatos->whatsapp );
            $facebook    =   sanitize_text_field( $objDatos->facebook );
            $web    =   sanitize_text_field( $objDatos->web );
            $correo    =   sanitize_text_field( $objDatos->correo );
            $direccion    =   sanitize_text_field( $objDatos->direccion );
            $instagram    =   sanitize_text_field( $objDatos->instagram );
                        
            if (is_array($objDatos->post_category)) {
                foreach ($objDatos->post_category as $key => $cat ) {
                    $cat = esc_attr($cat);
                }
            } else {
                $objDatos->post_category = esc_attr($objDatos->post_category);
            }

            remove_action( 'save_post_post', 'ser_save_post_admin' );
        
            if($objDatos->post_category === 'emergencias'){
                $post_id                        =   wp_insert_post([
                    'ID'                          =>    ($objDatos->ID ? $objDatos->ID: 0),
                    'post_content'                =>    $content,
                    'post_name'                   =>    $title,
                    'post_title'                  =>    $title,
                    'post_excerpt'                =>    $excerpt,
                    'post_status'                 =>    'pending',
                    'post_type'                   =>    'post',
                    'comment_status'              =>    'closed'
                 ]);
            }else{
                $post_id                        =   wp_insert_post([
                    'ID'                          =>    ($objDatos->ID ? $objDatos->ID: 0),
                    'post_content'                =>    $content,
                    'post_name'                   =>    $title,
                    'post_title'                  =>    $title,
                    'post_excerpt'                =>    $excerpt,
                    'post_status'                 =>    'pending',
                    'post_type'                   =>    'post',
                    'comment_status'              =>    'open'
                 ]);
            }
            
            add_action( 'save_post_post', 'ser_save_post_admin' );
            
            if( !is_wp_error($post_id) ){

                enviar_email_notificacione_staff('Nuevo publicacion de gobernacion/alcaldia por aprobar');

                wp_set_post_terms($post_id, $objDatos->post_category, 'category');
                wp_set_post_terms($post_id, $objDatos->tipo_entrada, 'tipos_entradas');
                wp_set_post_terms($post_id, $objDatos->tags, 'post_tag');
             
                update_post_meta( $post_id, 'telefono_negocio', $telefono );
                update_post_meta( $post_id, 'whatsapp_negocio', $whatsapp );
                update_post_meta( $post_id, 'facebook_negocio', $facebook );
                update_post_meta( $post_id, 'web_negocio', $web );
                update_post_meta( $post_id, 'correo_negocio', $correo );
                update_post_meta( $post_id, 'direccion_negocio', $direccion );
                update_post_meta( $post_id, 'instagram_negocio', $instagram );
                update_post_meta( $post_id, 'mapa_negocio', $mapa );
            

                wp_set_post_terms($post_id, $objDatos->post_category, 'category');
                wp_set_post_terms($post_id, $objDatos->tipo_entrada, 'tipos_entradas');

                  
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

    if( $method == 'PUT' ){
        
        $objDatos = json_decode(file_get_contents("php://input"));
       
        $nonce      =     isset($objDatos->_wpnonce) ? $objDatos->_wpnonce : '';
       
        if( !wp_verify_nonce( $nonce, 'serlib_form' ) ){
           
            wp_send_json($output);
            die();
        }
      
        if(get_current_user_id() === 0 ){
            wp_send_json($output);
            die();
        }
       
        if(isset($objDatos->password)){
            $user_password       =  sanitize_text_field($objDatos->password);
            $u = new WP_User( get_current_user_id() );
            reset_password($u, $user_password);
        }

        $user_fields = [];

        if(isset($objDatos->first_name)){
            $user_fields['first_name'] = sanitize_text_field($objDatos->first_name);
        }

        if(isset($objDatos->last_name)){
            $user_fields['last_name'] = sanitize_text_field($objDatos->last_name);
        }

        if(!empty($user_fields)){

            $user_fields['ID'] = get_current_user_id();  
            $results['user_update'] = wp_update_user($user_fields);
        }          

    }

    wp_send_json($results);
    die();

}