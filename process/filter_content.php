<?php

function serlib_filter_destino_content( $content ) {
    if( !is_singular( 'destino' )  ){
        return $content;
    }
    global $post, $wpdb;
    $destino_data   =   get_post_meta( $post->ID, 'destino_data', true ); 
    $destino_html   =   file_get_contents( 'templates/destino.php', true );
    $destino_html   =   str_replace( 'RATE_I18N', __('Calificación', 'serlib'), $destino_html);
    $destino_html   =   str_replace( 'DESTINO_ID', $post->ID, $destino_html);
    $destino_html   =   str_replace( 'DESTINO_RATING', $destino_data['rating'], $destino_html);
   
    /**Verificamos si el usuario ya califico para mostrar el rating readonly */
    $user_IP            =   $_SERVER['REMOTE_ADDR'];   
    
    return $destino_html . $content;
}