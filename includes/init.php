<?php

function serlib_fovea_init(){
	
	$labels = array( 
		'name'                  =>    _x( 'Destinos', 'post type general name', 'serlib' ),
		'singular_name'         =>    _x( 'Destino', 'post type singular name', 'serlib' ),
		'menu_name'             =>    _x( 'Destinos', 'admin menu', 'serlib' ),
		'name_admin_bar'        =>    _x( 'Destino', 'Agregar nuevo en la admin bar', 'serlib' ),
		'add_new'               =>    _x( 'Agregar Nuevo', 'agragar nuevo destino', 'serlib' ),
		'add_new_item'          =>    __( 'Agregar nuevo destino', 'serlib' ),
		'new_item'              =>    __( 'Nuevo Destino', 'serlib' ),
		'edit_item'             =>    __( 'Editar Destino', 'serlib' ),
		'view_item'             =>    __( 'Ver Destino', 'serlib' ),
		'all_items'             =>    __( 'Todos los Destinos', 'serlib' ),
		'search_items'          =>    __( 'Buscar Destinos', 'serlib' ),
		'parent_item_colon'     =>    __( 'Destinos Principal:', 'serlib' ),
		'not_found'             =>    __( 'Destino no encontrado.', 'serlib' ),
		'not_found_in_trash'    =>    __( 'No hay destinos en la papelera.', 'serlib' )
	);

	$args = array(
		'labels'                =>  $labels,
		'description'           =>  __( 'Post type para Destinos fovea.', 'serlib' ),
		'public'                =>  true,
		'publicly_queryable'    =>  true,
		'show_ui'               =>  true,
		'show_in_menu'          =>  true,
		'query_var'             =>  true,
		'rewrite'               =>  array( 'slug' => 'destinos' ),
		'capability_type'       =>  'post',
		'has_archive'           =>  true,
		'hierarchical'          =>  false,
		'menu_position'         =>  105,
        'supports'              =>  [ 'title', 'editor', 'author', 'thumbnail', 'comments' ],
        'taxonomies'            =>  ['post_tag'],
        'show_in_rest'          =>  true
	);

	register_post_type( 'destino' , $args );

	$labels2 = array( 
		'name'                  =>    _x( 'NEGOCIOS', 'post type general name', 'serlib' ),
		'singular_name'         =>    _x( 'NEGOCIO', 'post type singular name', 'serlib' ),
		'menu_name'             =>    _x( 'Negocios', 'admin menu', 'serlib' ),
		'name_admin_bar'        =>    _x( 'Negocio', 'Agregar nuevo en la admin bar', 'serlib' ),
		'add_new'               =>    _x( 'Agregar Nuevo', 'agragar nuevo destino', 'serlib' ),
		'add_new_item'          =>    __( 'Agregar nuevo negocio', 'serlib' ),
		'new_item'              =>    __( 'Nuevo Negocio', 'serlib' ),
		'edit_item'             =>    __( 'Editar Negocio', 'serlib' ),
		'view_item'             =>    __( 'Ver Negocio', 'serlib' ),
		'all_items'             =>    __( 'Todos los Negocios', 'serlib' ),
		'search_items'          =>    __( 'Buscar Negocios', 'serlib' ),
		'parent_item_colon'     =>    __( 'Negocios Principal:', 'serlib' ),
		'not_found'             =>    __( 'Negocio no encontrado.', 'serlib' ),
		'not_found_in_trash'    =>    __( 'No hay negocios en la papelera.', 'serlib' )
	);

	$args2 = array(
		'labels'                =>  $labels2,
		'description'           =>  __( 'Post type para Negocios fovea.', 'serlib' ),
		'public'                =>  true,
		'publicly_queryable'    =>  true,
		'show_ui'               =>  true,
		'show_in_menu'          =>  true,
		'query_var'             =>  true,
		'rewrite'               =>  array( 'slug' => 'negocios' ),
		'capability_type'       =>  'post',
		'has_archive'           =>  true,
		'hierarchical'          =>  false,
		'menu_position'         =>  105,
        'supports'              =>  [ 'title', 'editor', 'author', 'thumbnail', 'comments' ],
        'taxonomies'            =>  ['post_tag'],
        'show_in_rest'          =>  true
	);

	register_post_type( 'negocios' , $args2 );

}