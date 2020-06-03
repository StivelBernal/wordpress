<?php 

function serlib_entries(){
    
    $results = [];  

    if( isset($_POST['alcaldia']) ){
        
        global $wpdb;

        $results = [];
       
        $query = 'SELECT * from '.$wpdb->prefix .'posts WHERE post_author = '.$_POST['alcaldia'].'  AND post_type = "post" AND post_status = "publish"  ORDER BY post_date LIMIT 10';
    
        $results['alcaldia'] =  $wpdb->get_results( $query );
                 
        if( !$results['alcaldia'] ) {
            $results['errors'] =  _x('no hay posts de esta Alcaldia', 'post ajax respuesta alcaldia', 'serlib'); 
        }else{
         
            for($i = 0; $i < count($results['alcaldia']); $i++){
                $results['alcaldia'][$i]->thumbnail = get_the_post_thumbnail_url($results['alcaldia'][$i]->ID);
                $results['alcaldia'][$i]->permalink = get_permalink($results['alcaldia'][$i]->ID);
            }

        }
        
    }

    if( isset($_POST['gobernacion']) ){
        
        $query = 'SELECT * from '.$wpdb->prefix .'posts WHERE post_author = '.$_POST['gobernacion'].'  AND post_type = "post" AND post_status = "publish"  ORDER BY post_date LIMIT 10';
    
        $results['gobernacion'] =  $wpdb->get_results( $query );
         
        if(!$results['gobernacion'] ) {   
            $results['error'] =  _x('no hay posts de esta Gobernación', 'post ajax respuesta gobernacion', 'serlib'); 
        }else{
         
            for($i = 0; $i < count($results['gobernacion']); $i++){
                $results['gobernacion'][$i]->thumbnail = get_the_post_thumbnail_url($results['gobernacion'][$i]->ID);
                $results['gobernacion'][$i]->permalink = get_permalink($results['gobernacion'][$i]->ID);
            }

        }
    
    }

    if(empty($results)){
        $results['error'] =  'No se encontraron resultados';
    }

    wp_send_json($results);



}
?>

