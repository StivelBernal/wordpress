<?php 


function serlib_admin_frontend_shortcode(){
    
    $user = wp_get_current_user();
    //var_dump($user);
    $HTML = file_get_contents( 'templates/index.php', true );  
    
    return $HTML;
}