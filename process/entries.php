<?php 

function serlib_entries(){
    
    global $wpdb;
    $results = []; 

    if( isset($_POST['municipio']) ){
        $municipio = get_term_by('slug',$_POST['municipio'], 'category' );

        $value = $wpdb->get_results( "SELECT * FROM $wpdb->postmeta WHERE meta_value = ".$municipio->term_id." AND meta_key = 'municipio'" );

        $_POST['alcaldia'] = get_post_meta( $value[0]->post_id, 'alcaldiau', true);
        $_POST['gobernacion'] = get_post_meta( $value[0]->post_id, 'gobernacion', true);
       
    }   
    

    if( isset($_POST['alcaldia']) ){
        
        

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
    

            if($_POST['alcaldia'] !== 0){
                $users = [$_POST['alcaldia']];
                $userif = 'post_author = '.$_POST['alcaldia'];

            } 

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

            if($_POST['gobernacion'] !== 0){
                $users = [$_POST['gobernacion']];
                $userif = 'post_author = '.$_POST['gobernacion'];
            } 


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

    if( isset($_GET["busqueda"]) || $rol === '' ){
    
        return [];
    
    }else{
    
        $rutas = explode('/' ,$_SERVER['REQUEST_URI']);
    
    }
    
    if($rutas !== '') {
        if(!isset($rutas[1]) ){
            $categoria = [];
        }else{
            $categoria = get_term_by('slug', $rutas[1], 'category' );
            $categoria = $categoria->term_id;
        }
    }else{
        $categoria = [];
    }

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
            
            if( !(is_front_page())){
                
                if(!isset($categoria)){
                    return;
                }

                
                $results = get_posts(["category" => $categoria ]);
                var_dump(count($results));
                for($i = 0; $i < count($results); $i++){

                    $user_meta=get_userdata($results[$i]->post_author);
                    $user_roles=$user_meta->roles[0];
                    var_dump($user_meta);
                    if( $user_roles == 'aliado' ){
                        
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

                $query = 'SELECT * from '.$wpdb->prefix .'posts WHERE ('.$userif.')  AND post_type = "post" AND post_status = "publish"  ORDER BY post_date LIMIT 10';
                
                $results =  $wpdb->get_results( $query );

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