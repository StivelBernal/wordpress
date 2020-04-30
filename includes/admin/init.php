<?php

function serlib_admin_init(){
    include( 'columns.php' );

    add_filter( 'manage_destino_posts_columns', 'serlib_Add_new_destino_columns' );
    add_action( 'manage_destino_posts_custom_column', 'serlib_manage_destino_columns', 10, 2 );
}

