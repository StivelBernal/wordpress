<?php 

function serlib_admin_angular(){
    
    global $wpdb;
    $method = $_SERVER['REQUEST_METHOD'];

    if( $_GET['table'] == 'cities' ){
        
        $cities = $wpdb->get_results( "SELECT c.ID, c.nombre, c.is_active, c.state_id, s.nombre AS 'Departamento' FROM  `" . $wpdb->prefix . "cities` c INNER JOIN  `" . $wpdb->prefix . "states` s ON c.state_id = s.ID" );
        
        for($i = 0; $i < count($cities); $i++ ){ 
            $cities[$i] -> is_active = $cities[$i]->is_active == 0 ? false: true;
        }
       
        $states = $wpdb->get_results( "SELECT * FROM  `" . $wpdb->prefix . "states`" );
        
        $results = array('departamentos' => $states, 'ciudades' => $cities );

        echo json_encode($results, true);
        
        die();
    }

    if( $_GET['table'] == 'states' ){
        
        $states = $wpdb->get_results( "SELECT * FROM  `" . $wpdb->prefix . "states`" );
        
        for($i = 0; $i < count($states); $i++ ){ 
            $states[$i] -> is_active = $states[$i]->is_active == 0 ? false: true;
        }

       echo json_encode($states, true);
       die();
    }

    

    if ('POST' === $method && isset( $_GET['table_mod'] ) ) {
        
        $objDatos = json_decode(file_get_contents("php://input"));
        
        if($_GET['table_mod'] === 'cities' ){
               
            if($_GET['act'] === 'CREATE'){

                $response = $wpdb->insert( 
                    $wpdb->prefix . 'cities', 
                    [
                        'nombre'    =>  $objDatos->nombre,
                        'state_id'        =>  $objDatos->state_id,
                        'is_active'       =>  0
                    ],
                    [ '%s', '%d', '%d' ]
                );

                echo $response;

            }else if($_GET['act'] === 'UPDATE'){
                $response = $wpdb->update( 
                    $wpdb->prefix . 'cities', 
                    [ 'nombre'  =>  $objDatos->nombre,  'state_id' =>  $objDatos->state_id ],
                    [ 'ID' => $objDatos->ID  ]
                );
                echo $response;
            }else if($_GET['act'] === 'TOOGLE_ACTIVE'){
            
                $response = $wpdb->update( 
                    $wpdb->prefix . 'cities', 
                    [ 'is_active'  =>  $objDatos->is_active ],
                    [ 'ID' => $objDatos->ID ]
                );
                echo $response;
            }
            else if($_GET['act'] === 'DELETE'){
            
                $response = $wpdb->delete( 
                    $wpdb->prefix . 'cities', 
                    [ 'ID' => $objDatos ]
                );
                echo $response;
            }
        }
        
        else if($_GET['table_mod'] === 'states'){
           
            if($_GET['act'] === 'CREATE'){

                $response = $wpdb->insert( 
                    $wpdb->prefix . 'states', 
                    [
                        'nombre'    =>  $objDatos->nombre,
                        'is_active'       =>  0
                    ],
                    [ '%s', '%d' ]                );

                echo $response;

            }else if($_GET['act'] === 'UPDATE'){
                $response = $wpdb->update( 
                    $wpdb->prefix . 'states', 
                    [ 'nombre'  =>  $objDatos->nombre ],
                    [ 'ID' => $objDatos->ID  ]
                );
                echo $response;
            }else if($_GET['act'] === 'TOOGLE_ACTIVE'){
                        
                $response = $wpdb->update( 
                    $wpdb->prefix . 'states', 
                    [ 'is_active'  =>  $objDatos->is_active ],
                    [ 'ID' => $objDatos->ID ]
                );

                echo $response;
            }else if($_GET['act'] === 'DELETE'){
                
                $response = $wpdb->delete( 
                    $wpdb->prefix . 'states', 
                    [ 'ID' => $objDatos ]
                );
                echo $response;
            }
        }

       die();
    }

   

}  
