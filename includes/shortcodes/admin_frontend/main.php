<?php 


function serlib_admin_frontend_shortcode(){
    $HTML = file_get_contents( 'templates/index.php', true );  
    
    return $HTML;
}