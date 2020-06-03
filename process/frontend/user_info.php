<?php

function serlib_users_info(){
   
    $results = [];  
    $user_id =  get_current_user_id ();
     global $wpdb;
    
    if($user_id === 0){
        return;
    }

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

    wp_send_json($results);
    die();
}