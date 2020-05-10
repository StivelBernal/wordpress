<?php

function serlib_auth_handler(){
    
    $results = null;
    global $wpdb;

    if( $_SERVER['REQUEST_METHOD'] === 'GET' ){
        
        $query = "SELECT * FROM ".$wpdb->prefix."states;";
        
        $results = $wpdb->get_results( $query );
        
        for($i = 0; $i < count($results); $i++ ){
            $results[$i]->cities = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."cities WHERE state_id = ".$results[$i]->ID.";");
        }

    }

    wp_send_json( $results );
    die();
}