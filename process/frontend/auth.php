<?php

function serlib_auth_handler(){
    
    $results = null;
    global $wpdb;

    if( $_SERVER['REQUEST_METHOD'] === 'GET' ){
        
        $query = "SELECT * FROM ".$wpdb->prefix."states;";
        $query2 = "SELECT * FROM ".$wpdb->prefix."cities WHERE is_active = 1;";

        $results['states'] = $wpdb->get_results( $query );
        $results['cities_active'] = $wpdb->get_results( $query2 );
        
        for($i = 0; $i < count($results['states']); $i++ ){
            $results['states'][$i]->cities = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."cities WHERE state_id = ".$results['states'][$i]->ID.";");
        }

    }

    wp_send_json( $results );
    die();
}