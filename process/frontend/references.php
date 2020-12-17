<?php


function serlib_references(){

    $method = $_SERVER['REQUEST_METHOD'];
    
    if( $method === 'GET' ){

        $results = [];

        if( isset($_GET['municipios']) ){
           
            $municipios = [];
           
            $results['municipios'] = get_terms( 'category', [ 'hide_empty' => false, 'order' => 'DESC' ]);
            
            for( $i = 0; $i < count($results['municipios']); $i++) {
                
                if($results['municipios'][$i]->term_id !== 1){
                    array_push($municipios, $results['municipios'][$i]);
                }

            }

            $results['municipios'] = $municipios;
        
        }

        if( isset($_GET['tipos']) ){
          
            $results['tipos'] = get_terms( 'tipos_entradas' , [ 'hide_empty' => false, 'order' => 'DESC'] );

        }

        if( isset($_GET['tags']) ){
            
            $results['tags'] = get_terms('post_tag', [ 'hide_empty' => false, 'order' => 'DESC']);

        }

        wp_send_json($results);
        die();


    }





}


