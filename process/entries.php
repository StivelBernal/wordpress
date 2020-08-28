<?php 

function serlib_entries(){
    
    $results = [];     

    if( isset($_POST['alcaldia']) ){
        
        global $wpdb;

        $results = [];        

        if($_POST['alcaldia'] === 'ALL'){
       
            $users = get_users( [ 'role__in' => [ 'alcaldia' ] ] );

            $userif = '';
        
            for( $i = 0; $i < count($users); $i++ ){
                if($i === 0){
                    $userif .= ' post_author = '.$users[$i]->ID;
                }else{
                    $userif .= ' OR  post_author = '.$users[$i]->ID;
                }
            }
        
        }else{
            $users = [$_POST['alcaldia']];
            $userif = 'post_author = '.$_POST['alcaldia'];

        }

        if(count($users) !== 0){
            
            $query = 'SELECT * from '.$wpdb->prefix .'posts WHERE ('.$userif.')  AND post_type = "post" AND post_status = "publish"  ORDER BY post_date LIMIT 10';
        
            $results['alcaldia'] = $wpdb->get_results( $query );
                        
            for($i = 0; $i < count($results['alcaldia']); $i++){
                $author = get_userdata($results['alcaldia'][$i]->post_author);
                $results['alcaldia'][$i]->author = $author->user_login;
                $thumb = get_the_post_thumbnail_url($results['alcaldia'][$i]->ID);
                $thumb = $thumb ? $thumb: 'https://golfodemorrosquillo.com/wp-content/uploads/2020/08/AZUL-OSCURO-con-logo-Horizontal.png';
                $results['alcaldia'][$i]->thumbnail = $thumb;
                $results['alcaldia'][$i]->permalink = get_permalink($results['alcaldia'][$i]->ID);           
            
            }
            
        }else {
            $results['errors'] =  _x('no hay posts de esta Alcaldia', 'post ajax respuesta alcaldia', 'serlib'); 
        }

        
    }

    if( isset($_POST['gobernacion']) ){   

        if( $_POST['gobernacion'] === 'ALL' ){   

            $users = get_users( [ 'role__in' => [ 'gobernacion' ] ] );

            $userif = '';
            
            for( $i = 0; $i < count($users); $i++ ){
                if($i === 0){
                    $userif .= ' post_author = '.$users[$i]->ID;
                }else{
                    $userif .= ' OR  post_author = '.$users[$i]->ID;
                }
            }
        
        }else{

            $userif = 'post_author = '.$_POST['gobernacion'];

        }

        if(count($users) !== 0){
        
            $query = 'SELECT * from '.$wpdb->prefix .'posts WHERE ('.$userif.')  AND post_type = "post" AND post_status = "publish"  ORDER BY post_date LIMIT 10';
        
            $results['gobernacion'] =  $wpdb->get_results( $query );
            
            for($i = 0; $i < count($results['gobernacion']); $i++){
                $author = get_userdata($results['gobernacion'][$i]->post_author);
                $results['gobernacion'][$i]->author = $author->user_login;
                $thumb = get_the_post_thumbnail_url($results['gobernacion'][$i]->ID);
                $thumb = $thumb ? $thumb: 'https://golfodemorrosquillo.com/wp-content/uploads/2020/08/AZUL-OSCURO-con-logo-Horizontal.png';
                $results['gobernacion'][$i]->thumbnail = $thumb;
                $results['gobernacion'][$i]->permalink = get_permalink($results['gobernacion'][$i]->ID);
            }
            
        }else {
             
            $results['error'] =  _x('no hay posts de esta Gobernación', 'post ajax respuesta gobernacion', 'serlib'); 
        }
    
    }

    if(empty($results)){
        $results['error'] =  'No se encontraron resultados';
    }

    wp_send_json($results);



}

function serlib_entries_array($rol){

    if(isset($_GET["busqueda"]) || empty($rol)){
    
        return [];
    
    }else{
    
        $rutas = explode('/' ,$_SERVER['REQUEST_URI']);
    
    }

    if(isset($rutas[1]) ){
        $categoria = get_term_by('slug', $rutas[1], 'category' );
        $categoria = $categoria->term_id;
    }else{
        $categoria = [];
    }
    

    var_dump($categoria);

    $results = [];  

    if( $rol === 'aliado' ){
        
        global $wpdb;

        $results = [];

        $users = get_users( [ 'role__in' => [ 'aliado' ] ] );

        $userif = '';
        
        for( $i = 0; $i < count($users); $i++ ){
            if($i === 0){
                $userif .= ' post_author = '.$users[$i]->ID;
            }else{
                $userif .= ' OR  post_author = '.$users[$i]->ID;
            }
        }


        if(count($users) !== 0){
        
            $query = 'SELECT * from '.$wpdb->prefix .'posts WHERE ('.$userif.')  AND post_type = "post" AND post_status = "publish"  ORDER BY post_date LIMIT 10';
            
            $results =  $wpdb->get_results( $query );

            if(isset($rutas[1]) ){

                if(!isset($categoria)){
                    return;
                }

                for($i = 0; $i < count($results); $i++){
                    var_dump(wp_get_object_terms($results[$i]->ID, 'category', $categoria ),'sdfdsf', $categoria);
                    if( !empty(wp_get_post_categories($results[$i]->ID, [ 'object_ids' => $categoria ] ) ) ){
                        $author = get_userdata($results[$i]->post_author);
                        $results[$i]->author = $author->user_login;
                        $thumb = get_the_post_thumbnail_url($results[$i]->ID);
                        $thumb = $thumb ? $thumb: 'https://golfodemorrosquillo.com/wp-content/uploads/2020/08/AZUL-OSCURO-con-logo-Horizontal.png';
                        $results[$i]->thumbnail = $thumb;
                        $results[$i]->permalink = get_permalink($results[$i]->ID);
                
                    }else{
                        array_splice($results, $i);
                    }
                    
                }

            }else{

                for($i = 0; $i < count($results); $i++){
                    $author = get_userdata($results[$i]->post_author);
                    $results[$i]->author = $author->user_login;
                    $thumb = get_the_post_thumbnail_url($results[$i]->ID);
                    $thumb = $thumb ? $thumb: 'https://golfodemorrosquillo.com/wp-content/uploads/2020/08/AZUL-OSCURO-con-logo-Horizontal.png';
                    $results[$i]->thumbnail = $thumb;
                    $results[$i]->permalink = get_permalink($results[$i]->ID);        
                    
                }

            }

            
        }

        
    }   

    return $results;



}

?>