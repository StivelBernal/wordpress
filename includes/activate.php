<?php 

function serlib_activate_plugin(){
    
    if( version_compare( get_bloginfo( 'version'), '5.0', '<' ) ) {
        wp_die( __('Versión minima soportada de wordpress 5.*', 'serlib')  );
    }
    
    require( ABSPATH . "/wp-admin/includes/upgrade.php" );
  
    global $wpdb;

    $createDestinosSQL      =   "
    CREATE TABLE `" . $wpdb->prefix . "destino_ratings` (
        `ID` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `destino_id` BIGINT(20) UNSIGNED NOT NULL,
        `rating` FLOAT(3,2) UNSIGNED NOT NULL,
        `user_ip` VARCHAR(50) NOT NULL,
        PRIMARY KEY (`ID`)
    ) ENGINE=InnoDB " . $wpdb->get_charset_collate() . ";";

    dbDelta( $createDestinosSQL );
    
    $createStatesSQL      =   "
    CREATE TABLE `" . $wpdb->prefix . "states` (
        `ID` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `nombre` VARCHAR(255) NOT NULL,
        `is_active` BIT NOT NULL,
        PRIMARY KEY(ID) 
    ) ENGINE=InnoDB " . $wpdb->get_charset_collate() . ";";

    dbDelta( $createStatesSQL );

    $createCitiesSQL      =   "
    CREATE TABLE `" . $wpdb->prefix . "cities` (
        `ID` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        `nombre` VARCHAR(255) NOT NULL,
        `state_id` BIGINT(20) UNSIGNED NOT NULL,
        `is_active` BIT NOT NULL,
         PRIMARY KEY(ID)
    ) ENGINE=InnoDB " . $wpdb->get_charset_collate() . ";";
 
    dbDelta( $createCitiesSQL );

    /**Opciones del plugin */
    $serlib_opts        =   get_option( 'serlib_opts' );
   
    if( !$serlib_opts ){

        $opts    =   [
            'rating_login_required'     =>  1,
            'submission_login_required'  =>  1
        ];

        add_option( 'serlib', $opts );

    }

    /**Tipos de usuarios */
    global $wp_roles;

    add_role(
        'turista',
        __('Turista', 'serlib'),
        [
            'read'          =>  true,
            'edit_posts'    =>  true,
            'upload_files'  =>  true
        ]
    );

    add_role(
        'comerciante',
        __('Comerciante', 'serlib'),
        [
            'read'          =>  true,
            'edit_posts'    =>  true,
            'upload_files'  =>  true
        ]
    );

    add_role(
        'alcaldia',
        __('Alcaldia', 'serlib'),
        [
            'read'          =>  true,
            'edit_posts'    =>  true,
            'upload_files'  =>  true
        ]
    );

    add_role(
        'gobernacion',
        __('Gobernación', 'serlib'),
        [
            'read'          =>  true,
            'edit_posts'    =>  true,
            'upload_files'  =>  true
        ]
    );

    add_role(
        'staff',
        __('Staff', 'serlib'),
        [
            'read'          =>  true,
            'edit_posts'    =>  true,
            'upload_files'  =>  true
        ]
    );

}

