<?php 

function ser_save_post_admin( $post_id, $post, $update ){
    $destino_data   =   get_post_meta( $post_id, 'destino_data', true );
    $destino_data   =   empty($destino_data) ? [] : $destino_data;
    $destino_data['rating']   =   isset($destino_data['rating']) ? absint($destino_data['rating']): 0 ;
    $destino_data['rating_count']   =   isset($destino_data['rating_count']) ? absint($destino_data['rating_count']): 0 ;
   
    update_post_meta( $post_id, 'destino_data', $destino_data );
}

