<?php 



function serlib_comments(){

    $objDatos   =     json_decode(file_get_contents("php://input"));
    if($objDatos->text  === '') { $objDatos->text  = '...'; }
    $result = wp_handle_comment_submission ( ["comment_post_ID" => $objDatos->post_id , 'comment' => $objDatos->text ] );
    
    if ( !is_wp_error( $result ) ) {
        
        if(!empty($objDatos->stars)){
           update_comment_meta( $result->comment_ID, 'stars_items', $objDatos->stars );
        }
        
        $result = [ 'success' => _x('Comentario publicado', 'comentarios respuestas ajax correcto', 'serlib'),
                    'comment_ID' => $result->comment_ID];

    }else{
   

        $result = [ 'error' => _x('Error enviando el comentario', 'comentarios respuestas ajax error', 'serlib') ];
     
        
    }
    
    wp_send_json($result);
    die();


}