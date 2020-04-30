<?php 

function serlib_activate_plugin(){
    
    if( version_compare( get_bloginfo( 'version'), '5.0', '<' ) ) {
        wp_die( __('Versión minima soportada de wordpress 5.*', 'serlib')  );
    }

    global $wpdb;
    $createSQL      =   "
    CREATE TABLE `" . $wpdb->prefix . "destino_ratings` (
        `ID` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `destino_id` BIGINT(20) UNSIGNED NOT NULL,
        `rating` FLOAT(3,2) UNSIGNED NOT NULL,
        `user_ip` VARCHAR(50) NOT NULL,
        PRIMARY KEY (`ID`)
    ) ENGINE=InnoDB " . $wpdb->get_charset_collate() . ";";

    require( ABSPATH . "/wp-admin/includes/upgrade.php" );
    dbDelta( $createSQL );
}
