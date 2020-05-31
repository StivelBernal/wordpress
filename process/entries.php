<?php 

function serlib_entries(){
    
    $results = [];  

    if( isset($_POST['alcaldia']) ){
    
        // parametros de query
        $the_args = array(
            'author'        =>  esc_attr($_POST['alcaldia']),
            'post_status' => 'publish',
            'orderby'       =>  'post_date',
            'order'         =>  'DESC',
            'posts_per_page' => 10,
            'offset'      =>   0,
            'post_type' => 'post'
        );

        $query = new WP_Query($the_args);
        
         
        if( $query->have_posts() ) {
            $query = new WP_Query($the_args);
            echo 'algo?';
            while( $query->have_posts() ){
                 var_dump($query->the_post());
           }
 
        }else{
            $results['errors'] =  _x('no hay posts de esta Alcaldia', 'post ajax respuesta alcaldia', 'serlib'); 
        }
    
    }

    if( isset($_POST['gobernacion']) ){
    
        // parametros de query
        $the_args = array(
            'author'        =>  esc_attr($_POST['gobernacion']),
            'post_status' => 'publish',
            'orderby'       =>  'post_date',
            'order'         =>  'DESC',
            'posts_per_page' => 10,
            'offset'      =>   0,
            'post_type' => 'post'
        );

        $query = new WP_Query($the_args);
        
        if( $query->have_posts() ) {
            $query = new WP_Query($the_args);
            while( $query->have_posts() ){
                 var_dump($query->the_post());
           }
 
        }else{
            $results['error'] =  _x('no hay posts de esta Gobernación', 'post ajax respuesta gobernacion', 'serlib'); 
        }
    
    }

    if(empty($results)){
        $results['error'] =  'No se encontraron resultados';
    }

    wp_send_json($results);



}