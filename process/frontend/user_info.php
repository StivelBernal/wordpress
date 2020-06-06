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
        
        if( isset($_GET['ID']) && is_int($_GET['ID']) ){
            $query = 'SELECT * from '.$wpdb->prefix .'posts WHERE post_author = '.$user_id.'  AND ID = '.$_GET['ID'].'';
            $results =  $wpdb->get_row( $query );
        
        }else if( isset($_GET['post_type']) ){
        
            $query = 'SELECT * from '.$wpdb->prefix .'posts WHERE post_author = '.$user_id.'  AND post_type = "post" ORDER BY post_date';
            $results =  $wpdb->get_results( $query );
            for($i = 0; $i < count($results); $i++){
                $results[$i]->thumbnail = get_the_post_thumbnail_url($results[$i]->ID);
                $results[$i]->permalink = get_permalink($results[$i]->ID);
            }    
            
        }
    
    }

    if( $method == 'POST' ){
   
        $objDatos = json_decode(file_get_contents("php://input"));
       
        $results = [ 'status' => 1 ];
       
        if( empty($objDatos->title) ){
            wp_send_json( $results );
        }

        
        $title  =   sanitize_text_field( $objDatos->title );
        $content    =   wp_kses_post( $objDatos->content );
        // OBTENER ROL Y VERIFICAR QUE LOS CONTENIDOS VENGAN BIEN
        
        $post_id                        =   wp_insert_post([
            'post_content'                =>  $content,
            'post_name'                   =>  $title,
            'post_title'                  =>  $title,
            'post_status'                 =>  'pending',
            'post_type'                   =>  'blog'
            //,'post_category' => array(8,39)
        ]);

       
        if( !is_wp_error($post_id) ){
           
            //update_post_meta( $post_id, 'recipe_data', $recipe_data );
            /*
                    if(isset($_POST['attachment_id']) && !empty($_POST['attachment_id'])){
                        require_once( ABSPATH . 'wp-admin/includes/image.php' );
                        set_post_thumbnail( $post_id, absint($_POST['attachment_id']) );
                    }
            */
            $results['status']  =   2;

        }

        

    }

    wp_send_json($results);
    die();
}