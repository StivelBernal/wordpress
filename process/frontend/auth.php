<?php

function serlib_auth_handler(){
    
    $results = null;
    global $wpdb;

    if( $_SERVER['REQUEST_METHOD'] === 'GET' ){
        $query = "SELECT * FROM ".$wpdb->prefix."cities ;";
        $query2 = "SELECT * FROM ".$wpdb->prefix."states ;";
        $results['cities'] = $wpdb->get_results( $query );
        $results['states'] = $wpdb->get_results( $query2 );
       

    }

    wp_send_json( $results );
    die();
}