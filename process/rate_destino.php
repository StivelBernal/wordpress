<?php 

function serlib_rate_destino(){
   global $wpdb;

    $output     =   [ 'status' => 1 ];
    $post_ID    =   absint( $_POST['rid'] );
    $rating     =   round( $_POST['rating'], 1 );
    $user_ip    =   $_SERVER['REMOTE_ADDR'];

    /**Verificamos que el usuario no haya calificado ya el post */
    $rating_count = $wpdb->get_var( "SELECT COUNT(*) FROM  `" . $wpdb->prefix . "destino_ratings`
                                     WHERE destino_id = ".$post_ID." AND user_ip = '".$user_ip."'" );

    /**Get meta del post */
    $destino_data   =   get_post_meta( $post_ID, 'destino_data', true );
    
    if( $rating_count == 0 ){
        
        /**Inserta una calificación de un destino */
        $wpdb->insert( 
            $wpdb->prefix . 'destino_ratings', 
            [
                'destino_id'    =>  $post_ID,
                'rating'        =>  $rating,
                'user_ip'       =>  $user_ip
            ],
            [ '%d', '%f', '%s' ]
        );
    
        $output['status']   =   2;

        $destino_data['rating_count']++;

    }else{
        
        $wpdb->update( 
            $wpdb->prefix . 'destino_ratings', 
            [ 'rating'  =>  $rating ],
            [ 'user_ip' =>  $user_ip ]
        );
    }
        
    $destino_data['rating']     =    round($wpdb->get_var( "SELECT AVG(`rating`) FROM  `" . $wpdb->prefix . "destino_ratings`
    WHERE destino_id = '".$post_ID."'" ), 1);  

    update_post_meta( $post_ID, 'destino_data', $destino_data );
    
    wp_send_json( $output );

}