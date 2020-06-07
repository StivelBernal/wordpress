<?php

function serlib_users_info(){
   
    $results = [];  
    $user_id =  get_current_user_id ();
    $method = $_SERVER['REQUEST_METHOD'];
    global $wpdb;
    
    if($user_id === 0){
        return;
    }

    if( $method == 'GET' ){
        
        if( isset($_GET['ID']) && is_numeric($_GET['ID']) ){
           
            $query = 'SELECT * from '.$wpdb->prefix .'posts WHERE post_author = '.$user_id.'  AND ID = '.$_GET['ID'].'';
            $results['post'] =  $wpdb->get_row( $query );
            $terms = get_the_terms( $results['post']->ID , 'categorias_articulos', 'term_id' );
            for($i = 0; $i < count($terms); $i++ ) { 
                $terms[$i] = $terms[$i]->term_id;
            }
            $results['post']->post_category = $terms;
        }else if( isset($_GET['post_type']) ){
         
            $query = 'SELECT * from '.$wpdb->prefix .'posts WHERE post_author = '.$user_id.'  AND (post_type = "post" OR post_type = "blog") ORDER BY post_date DESC';
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
           
            //update_post_meta( $post_id, 'recipe_data', $recipe_data );
            /*
                    if(isset($_POST['attachment_id']) && !empty($_POST['attachment_id'])){
                        require_once( ABSPATH . 'wp-admin/includes/image.php' );
                        set_post_thumbnail( $post_id, absint($_POST['attachment_id']) );
                    }
            */
            $results['status']  =   2;
            $results['id']  =   $post_id;
            $results['permalink'] = get_permalink( $post_id );
        }

        

    }

    wp_send_json($results);
    die();
}