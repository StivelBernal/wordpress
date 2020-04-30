<?php 

function serlib_Add_new_destino_columns( $columns ){
    $new_columns                =   [];
    $new_columns['cb']          =   '<input type="checkbox" />';
    $new_columns['title']       =   __( 'Titulo', 'serlib' );
    $new_columns['tags']        =   __( 'Etiquetas', 'serlib' );
    $new_columns['count']       =   __( 'Cantidad calificaciones', 'serlib' );
    $new_columns['rating']      =   __( 'Promedio calificaciones', 'serlib' );
    $new_columns['date']        =   __( 'Fecha', 'serlib' );

    return $new_columns;
}

function serlib_manage_destino_columns( $column, $post_id ){
    switch( $column ){
        case 'count':
            $destino_data        =   get_post_meta( $post_id, 'destino_data', true );
            echo isset($destino_data['rating_count']) ? $destino_data['rating_count'] : 0;
            break;
        case 'rating':
            $destino_data        =   get_post_meta( $post_id, 'destino_data', true );
            echo isset($destino_data['rating']) ? $destino_data['rating'] : 'N/A';
            break;
        default:
            break;
    }
}