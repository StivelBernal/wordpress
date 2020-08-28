<?php 

function serlib_comments(){

    if( $_SERVER['REQUEST_METHOD'] === 'POST'){

        $objDatos   =     json_decode(file_get_contents("php://input"));
        if($objDatos->text  === '') { $objDatos->text  = '...'; }
       
        $parent = 0;
       
        if(isset($objDatos->parent)){
            $parent = $objDatos->parent;
        }

        $result = wp_handle_comment_submission ( ["comment_post_ID" => $objDatos->post_id , 'comment' => $objDatos->text, 'comment_parent' => $parent ] );
    
        if ( !is_wp_error( $result ) ) {
            
            if(!empty($objDatos->stars)){
            update_comment_meta( $result->comment_ID, 'stars_items', $objDatos->stars );
            }
            
            if($result->comment_parent === 0){
                enviar_email_notificaciones_author_post($objDatos->post_id);
            }else{

                $user_repl = get_comment($result->comment_parent);
                enviar_email_notificaciones_author_comment($objDatos->post_id, $user_repl->user_id, $result->comment_author);
            }
            
            
            $result = [ 'success' => _x('Comentario publicado', 'comentarios respuestas ajax correcto', 'serlib'),
                        'comment_ID' => $result->comment_ID];
            
            

        }else{
    

            $result = [ 'error' => _x('Error enviando el comentario', 'comentarios respuestas ajax error', 'serlib') ];
        
            
        }
        
       

    }

    if( $_SERVER['REQUEST_METHOD'] === 'DELETE'){
        
        $comment_id = $_GET['id_comment']; //$commentID your var

        $comment = get_comment( $comment_id );
        
        $comment_author_id = $comment -> user_id;

        if($comment_author_id == get_current_user_id() ){
             $result = wp_delete_comment ( $comment_id  );
             if($result) {
                $result = ['success' => 'borrado'];
             }else{
                $result = ['error' => 'huvo problemas en el borrado'];
             }
        }
       

    }

    wp_send_json($result);
    die();
}