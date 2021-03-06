<?php

function serlib_uploader(){  
    
    function guardar_archivo(){ 
        
        ini_set('error_reporting', E_ALL);
        ini_set('post_max_size','120M');
        ini_set('upload_max_filesize','120M');
        ini_set('max_execution_time','1000');
        ini_set('max_input_time','1000');
        $file = $_FILES['files'];
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ">", "/", "?");
        $name = str_replace([' ', 'á', 'e', 'í', 'ó', 'ú'], ['-', 'a', 'e', 'i', 'o', 'u'], $file['name']);
        $name = str_replace($strip, '', $name);
        $wordpress_upload_dir = wp_upload_dir();
        // number of tries when the file with the same name is already exists
        $i = 1; 
        
        $new_file_path = $wordpress_upload_dir['path'] . '/' . $name;
        
        $new_file_mime = mime_content_type( $file['tmp_name'] );

        if( empty( $file ) )
            die( 'File is not selected.' );

        if( $file['error'] )
            die( $file['error'] );

        if( $file['size'] > wp_max_upload_size() )
            die( 'It is too large than expected.' );
    
        if( !in_array( $new_file_mime, get_allowed_mime_types() ) )
            die( 'WordPress doesn\'t allow this type of uploads.' );

        while( file_exists( $new_file_path ) ) {
            $i++;
            $new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $name;
        }
        
        $file_move = move_uploaded_file( $file['tmp_name'], $new_file_path );
        
        // looks like everything is OK
        if( $file_move ) {
        
            $upload_id = wp_insert_attachment( array(
                'guid'           => $new_file_path, 
                'post_mime_type' => $new_file_mime,
                'post_title'     => preg_replace( '/\.[^.]+$/', '', $file['name'] ),
                'post_content'   => '',
                'post_status'    => 'inherit'
            ), $new_file_path );
            

            
            // wp_generate_attachment_metadata() won't work if you do not include this file
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
        
            // Generate and save the attachment metas into the database
            wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );
            
            $output  =  [ 'success' => $upload_id ];

            if( $_GET["destino"] === 'photo_profile' ){
           
                $output  =  [ 'success' => $new_file_path ];

            }else if($_GET["destino"] === 'file_document'){
           
                $output  =  [ 'success' => $new_file_path ];

                // update_user_meta( $_GET['id'], 'file_document', $new_file_path );
            }else if($_GET["destino"] === 'comments_media'){
               
                $media = get_comment_meta($_GET['id_comment'], 'comments_media')[0]; 
                
                if(isset($media)){
                    array_push( $media, wp_get_attachment_image_src($upload_id)[0] );
                    
                    update_comment_meta( $_GET['id_comment'], 'comments_media', $media );
                }else{
                    update_comment_meta( $_GET['id_comment'], 'comments_media', [ wp_get_attachment_image_src($upload_id, 'full')[0] ] );
                }
                
            }
            
            if(isset($_GET["order"])){
                
                $output  =    [ 'success' => ["id" => $upload_id, "order" => $_GET["order"] ] ];
           
            }   
            
            if($_GET["destino"] === 'image'){
                echo wp_get_attachment_image_src($upload_id, 'full')[0];
            }else{
                wp_send_json($output);
            }
            
        }

        die();
    
    }


    if( $_GET['destino'] === 'featured' || $_GET['destino'] === 'image' || $_GET['destino'] ===  'photo_profile' || $_GET['destino'] ===  'file_document' || $_GET['destino'] ===  'comments_media'  ){
        guardar_archivo();
    }

}