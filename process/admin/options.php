<?php 

function serlib_options_handler(){

    if(!current_user_can( 'manage_options') ){
        return;
        die();
    }

    $results = null;
    global $wpdb;

    if($_GET['table'] == 'states' ){
                

        if( $_SERVER['REQUEST_METHOD'] === 'GET' ){

            $results = $wpdb->get_results( 
                "SELECT * FROM ".$wpdb->prefix."states "
            );
            for($i = 0; $i < count($results); $i++){
                $results[$i]->is_active = boolval( $results[$i]->is_active );
            }

        }else{
           
            $data = file_get_contents('php://input');
            $data = json_decode($data);

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                
                $results = $wpdb->insert( 
                    $wpdb->prefix . 'states', 
                    [
                        'nombre'    =>  $data->nombre,
                        'is_active' =>  0
                    ],
                    [ '%s','%d' ]
                );
               
        
            }

            if($_SERVER['REQUEST_METHOD'] == 'PUT'){
                
                if(isset($data->ID)){
                   
                    if($_GET['mod'] == 'active' ){
                       
                       
                       $results = $wpdb->update( 
                            $wpdb->prefix . 'states', 
                            [ 'is_active'  =>  $data->is_active ],
                            [ 'ID' =>  $data->ID ]
                        );

                    }else{
                        
                        $results = $wpdb->update( 
                            $wpdb->prefix . 'states', 
                            [ 'nombre'  =>  $data->nombre ],
                            [ 'ID' =>  $data->ID ]
                        );

                    }
                }
        
            }

            if($_SERVER['REQUEST_METHOD'] == 'DELETE'){

                if(isset($data) && is_int($data)){
                    
                    $results = $wpdb->delete( 
                        $wpdb->prefix . 'states', 
                        [ 'ID'  =>  $data ],
                        ['%d']
                    );

                }  
        
            }
        
            
    
        }

        wp_send_json( $results );
        die();
        

    }else if( $_GET['table'] == 'cities'){
    
    
        if( $_SERVER['REQUEST_METHOD'] === 'GET' ){

            $results = $wpdb->get_results( 
                "SELECT * FROM ".$wpdb->prefix."cities "
            );
            for($i = 0; $i < count($results); $i++){
                $results[$i]->is_active = boolval( $results[$i]->is_active );
            }

        }else{
        
            $data = file_get_contents('php://input');
            $data = json_decode($data);

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                
                $results = $wpdb->insert( 
                    $wpdb->prefix . 'cities', 
                    [
                        'nombre'    =>  $data->nombre,
                        'state_id'    =>  $data->state_id,
                        'is_active' =>  0
                    ],
                    [ '%s','%d' ]
                );
            
        
            }

            if($_SERVER['REQUEST_METHOD'] == 'PUT'){
                
                if(isset($data->ID)){
                
                    if($_GET['mod'] == 'active' ){
                    
                    
                    $results = $wpdb->update( 
                            $wpdb->prefix . 'cities', 
                            [ 'is_active'  =>  $data->is_active ],
                            [ 'ID' =>  $data->ID ]
                        );

                    }else{
                        
                        $results = $wpdb->update( 
                            $wpdb->prefix . 'cities', 
                            [ 'nombre'  =>  $data->nombre, 'state_id'  =>  $data->state_id  ],
                            [ 'ID' =>  $data->ID ]
                        );

                    }
                }
        
            }

            if($_SERVER['REQUEST_METHOD'] == 'DELETE'){

                if(isset($data) && is_int($data)){
                    
                    $results = $wpdb->delete( 
                        $wpdb->prefix . 'cities', 
                        [ 'ID'  =>  $data ],
                        ['%d']
                    );

                }  
        
            }
        
            

        }
        
        wp_send_json( $results );

        die();
    }

 }

?>