<?php

function serlib_fovea_init(){
	/**
	 *  [POST TYPES]
	 *  HOME DONDE ESTARIA LOS DESTINOS PRICIPALES Y LA PUBLICIDAD
	 *  DESTINOS: PAGINA PRINCIPAL DEL DESTINO PODRIAMOS APROVECHAR LO QUE YA TIENE EL TEMA Y MODIFICARLO PORQUE APENAS ES UN POSTTYPE
	 *  SITIOS: PLANES QUE PUEDEN HACERSE EN ESE LUGAR PDORIA  APLICARSE LO DE LOS TOURS
	 *  NEGOCIOS: [DIVERSION , TRANSPORTE, GASTRONOMIA, HOSPEDAJE, COMERCIO ]
	 *  RUTAS CRUD
	 *  CULTURA: CRUD
	 *  EVENTOS: CRUD
	 *  EMERGENCIAS [Cotiene los nuemros de las autoridades locales aqui encontramos bomberos ambulancia cruz roja]
	 *  {*} TODOS SE VAN A PODER RESEÑAR MENOS EMERGENCIAS  
	 */

	 /**
	  * DESTINOS PRINCIPAL PAGINAS SECUNDARIAS [Puede que se elimine totalmente mikado tours porque lo reemplazariamos por el que
	  * 										usaramos aca]
	  */
	$destino_labels = array( 
		'name'                  =>    _x( 'Destinos', 'post type general name destino', 'serlib' ),
		'singular_name'         =>    _x( 'Destino', 'post type singular name destino', 'serlib' ),
		'menu_name'             =>    _x( 'Destinos', 'admin menu destino', 'serlib' ),
		'name_admin_bar'        =>    _x( 'Destino', 'Agregar nuevo en la admin bar destino', 'serlib' ),
		'add_new'               =>    _x( 'Agregar Nuevo', 'agragar nuevo destino destino', 'serlib' ),
		'add_new_item'          =>    __( 'Agregar nuevo destino', 'serlib' ),
		'new_item'              =>    __( 'Nuevo destino', 'serlib' ),
		'edit_item'             =>    __( 'Editar destino', 'serlib' ),
		'view_item'             =>    __( 'Ver destino', 'serlib' ),
		'all_items'             =>    __( 'Todos los destinos', 'serlib' ),
		'search_items'          =>    __( 'Buscar destinos', 'serlib' ),
		'parent_item_colon'     =>    __( 'Destinos principal:', 'serlib' ),
		'not_found'             =>    __( 'Destino no encontrado.', 'serlib' ),
		'not_found_in_trash'    =>    __( 'No hay destinos en la papelera.', 'serlib' )
	);	

	register_post_type(
		'destino' , 
		array(
			'labels'                =>  $destino_labels,
			'description'           =>  __( 'Post type para destinos fovea.', 'serlib' ),
			'public'                =>  true,
			'publicly_queryable'    =>  true,
			'show_ui'               =>  true,
			'show_in_menu'          =>  true,
			'query_var'             =>  true,
			'rewrite'               =>  array( 'slug' => 'destinos' ),
			'capability_type'       =>  'post',
			'has_archive'           =>  true,
			'hierarchical'          =>  false,
			'menu_position'         =>  115,
			'menu_icon'				=>  'dashicons-palmtree',
			'supports'              =>  [ 'title', 'editor', 'author', 'thumbnail', 'comments' ],
			'taxonomies'            =>  ['post_tag'],
			'show_in_rest'          =>  true
		)
	);

	/**
	 * POST TYPE SITIOS
	 */
	$sitios_labels = array( 
		'name'                  =>    _x( 'Sitios', 'post type general name sitios', 'serlib' ),
		'singular_name'         =>    _x( 'Sitio', 'post type singular name sitio', 'serlib' ),
		'menu_name'             =>    _x( 'Sitios', 'admin menu sitio', 'serlib' ),
		'name_admin_bar'        =>    _x( 'Sitio', 'Agregar nuevo en la admin bar sitio', 'serlib' ),
		'add_new'               =>    _x( 'Agregar Nuevo', 'agragar nuevo sitio ', 'serlib' ),
		'add_new_item'          =>    __( 'Agregar nuevo sitio', 'serlib' ),
		'new_item'              =>    __( 'Nuevo sitio', 'serlib' ),
		'edit_item'             =>    __( 'Editar sitio', 'serlib' ),
		'view_item'             =>    __( 'Ver sitio', 'serlib' ),
		'all_items'             =>    __( 'Todos los sitios', 'serlib' ),
		'search_items'          =>    __( 'Buscar sitios', 'serlib' ),
		'parent_item_colon'     =>    __( 'Sitios principal:', 'serlib' ),
		'not_found'             =>    __( 'Sitio no encontrado.', 'serlib' ),
		'not_found_in_trash'    =>    __( 'No hay sitios en la papelera.', 'serlib' )
	);	

	register_post_type(
		'sitio' , 
		array(
			'labels'                =>  $sitios_labels,
			'description'           =>  __( 'Post type para sitios fovea.', 'serlib' ),
			'public'                =>  true,
			'publicly_queryable'    =>  true,
			'show_ui'               =>  true,
			'show_in_menu'          =>  true,
			'query_var'             =>  true,
			'rewrite'               =>  array( 'slug' => 'sitios' ),
			'capability_type'       =>  'post',
			'has_archive'           =>  true,
			'hierarchical'          =>  false,
			'menu_position'         =>  115,
			'menu_icon'				=>  'dashicons-images-alt',
			'supports'              =>  [ 'title', 'editor', 'author', 'thumbnail', 'comments' ],
			'taxonomies'            =>  ['post_tag'],
			'show_in_rest'          =>  true
		)
	);
	/**
	 *  NEGOCIOS CUSTOM POST TYPE 
	 */
	$negocios_labels = array( 
		'name'                  =>    _x( 'NEGOCIOS', 'post type general name negocios', 'serlib' ),
		'singular_name'         =>    _x( 'NEGOCIO', 'post type singular name negocios', 'serlib' ),
		'menu_name'             =>    _x( 'Negocios', 'admin menu negocios', 'serlib' ),
		'name_admin_bar'        =>    _x( 'Negocio', 'Agregar nuevo en la admin bar negocios', 'serlib' ),
		'add_new'               =>    _x( 'Agregar Nuevo', 'agragar nuevo destino negocios', 'serlib' ),
		'add_new_item'          =>    __( 'Agregar nuevo negocio', 'serlib' ),
		'new_item'              =>    __( 'Nuevo negocio', 'serlib' ),
		'edit_item'             =>    __( 'Editar negocio', 'serlib' ),
		'view_item'             =>    __( 'Ver negocio', 'serlib' ),
		'all_items'             =>    __( 'Todos los negocios', 'serlib' ),
		'search_items'          =>    __( 'Buscar negocios', 'serlib' ),
		'parent_item_colon'     =>    __( 'Negocios principal:', 'serlib' ),
		'not_found'             =>    __( 'Negocio no encontrado.', 'serlib' ),
		'not_found_in_trash'    =>    __( 'No hay negocios en la papelera.', 'serlib' )
	);

	register_post_type( 
		'negocios' , 
		array(
			'labels'                =>  $negocios_labels,
			'description'           =>  __( 'Post type para negocios fovea.', 'serlib' ),
			'public'                =>  true,
			'publicly_queryable'    =>  true,
			'show_ui'               =>  true,
			'show_in_menu'          =>  true,
			'query_var'             =>  true,
			'rewrite'               =>  array( 'slug' => 'negocios' ),
			'capability_type'       =>  'post',
			'has_archive'           =>  true,
			'hierarchical'          =>  false,
			'menu_icon'				=>  'dashicons-store',
			'menu_position'         =>  115,
			'supports'              =>  [ 'title', 'editor', 'author', 'thumbnail', 'comments' ],
			'taxonomies'            =>  ['post_tag', 'category'],
			'show_in_rest'          =>  true
		)
	);
	/**
	 *  RUTAS CUSTOM POST TYPE 
	 */
	$rutas_labels = array( 
		'name'                  =>    _x( 'RUTAS', 'post type general name rutas', 'serlib' ),
		'singular_name'         =>    _x( 'RUTAS', 'post type singular name rutas', 'serlib' ),
		'menu_name'             =>    _x( 'Rutas', 'admin menu rutas', 'serlib' ),
		'name_admin_bar'        =>    _x( 'Rutas', 'Agregar nuevo en la admin bar rutas', 'serlib' ),
		'add_new'               =>    _x( 'Agregar Nuevo', 'agragar nuevo destino rutas', 'serlib' ),
		'add_new_item'          =>    __( 'Agregar nueva ruta', 'serlib' ),
		'new_item'              =>    __( 'Nueva ruta', 'serlib' ),
		'edit_item'             =>    __( 'Editar ruta', 'serlib' ),
		'view_item'             =>    __( 'Ver ruta', 'serlib' ),
		'all_items'             =>    __( 'Todos los rutas', 'serlib' ),
		'search_items'          =>    __( 'Buscar rutas', 'serlib' ),
		'parent_item_colon'     =>    __( 'Ruta principal:', 'serlib' ),
		'not_found'             =>    __( 'Ruta no encontrado.', 'serlib' ),
		'not_found_in_trash'    =>    __( 'No hay rutas en la papelera.', 'serlib' )
	);

	register_post_type( 
		'rutas' , 
		array(
			'labels'                =>  $rutas_labels,
			'description'           =>  __( 'Post type para rutas fovea.', 'serlib' ),
			'public'                =>  true,
			'publicly_queryable'    =>  true,
			'show_ui'               =>  true,
			'show_in_menu'          =>  true,
			'query_var'             =>  true,
			'rewrite'               =>  array( 'slug' => 'rutas' ),
			'capability_type'       =>  'post',
			'has_archive'           =>  true,
			'hierarchical'          =>  false,
			'menu_icon'				=>  'dashicons-location-alt',
			'menu_position'         =>  115,
			'supports'              =>  [ 'title', 'editor', 'author', 'thumbnail', 'comments' ],
			'taxonomies'            =>  [],
			'show_in_rest'          =>  true
		)
	);
	/**
	 *  CULTURA CUSTOM POST TYPE 
	 */
	$cultura_labels = array( 
		'name'                  =>    _x( 'CULTURA', 'post type general name cultura', 'serlib' ),
		'singular_name'         =>    _x( 'CULTURA', 'post type singular name cultura', 'serlib' ),
		'menu_name'             =>    _x( 'Cultura', 'admin menu cultura', 'serlib' ),
		'name_admin_bar'        =>    _x( 'Cultura', 'Agregar nuevo en la admin bar reseña de cultura', 'serlib' ),
		'add_new'               =>    _x( 'Agregar Nuevo', 'agragar nuevo reseña de cultura', 'serlib' ),
		'add_new_item'          =>    __( 'Agregar nueva reseña de cultura', 'serlib' ),
		'new_item'              =>    __( 'Nueva Reseña', 'serlib' ),
		'edit_item'             =>    __( 'Editar Reseña', 'serlib' ),
		'view_item'             =>    __( 'Ver Reseñas', 'serlib' ),
		'all_items'             =>    __( 'Todos las reseñas', 'serlib' ),
		'search_items'          =>    __( 'Buscar reseña de cultura', 'serlib' ),
		'parent_item_colon'     =>    __( 'Reseña de cultura principal:', 'serlib' ),
		'not_found'             =>    __( 'Reseña de cultura no encontrado.', 'serlib' ),
		'not_found_in_trash'    =>    __( 'No hay reseñas de cultura en la papelera.', 'serlib' )
	);

	register_post_type( 
		'cultura' , 
		array(
			'labels'                =>  $cultura_labels,
			'description'           =>  __( 'Post type para cultura fovea.', 'serlib' ),
			'public'                =>  true,
			'publicly_queryable'    =>  true,
			'show_ui'               =>  true,
			'show_in_menu'          =>  true,
			'query_var'             =>  true,
			'rewrite'               =>  array( 'slug' => 'cultura' ),
			'capability_type'       =>  'post',
			'has_archive'           =>  true,
			'hierarchical'          =>  false,
			'menu_icon'				=>  'dashicons-nametag',
			'menu_position'         =>  115,
			'supports'              =>  [ 'title', 'editor', 'author', 'thumbnail', 'comments' ],
			'taxonomies'            =>  ['post_tag'],
			'show_in_rest'          =>  true
		)
	);
	/**
	 *  EVENTOS CUSTOM POST TYPE 
	 */
	$eventos_labels = array( 
		'name'                  =>    _x( 'EVENTOS', 'post type general name eventos', 'serlib' ),
		'singular_name'         =>    _x( 'EVENTOS', 'post type singular name eventos', 'serlib' ),
		'menu_name'             =>    _x( 'Eventos', 'admin menu eventos', 'serlib' ),
		'name_admin_bar'        =>    _x( 'Eventos', 'Agregar nuevo en la admin bar evento', 'serlib' ),
		'add_new'               =>    _x( 'Agregar Nuevo', 'agragar nuevo evento', 'serlib' ),
		'add_new_item'          =>    __( 'Agregar nuevo evento', 'serlib' ),
		'new_item'              =>    __( 'Nuevo Evento', 'serlib' ),
		'edit_item'             =>    __( 'Editar Evento', 'serlib' ),
		'view_item'             =>    __( 'Ver Eventos', 'serlib' ),
		'all_items'             =>    __( 'Todos las eventos', 'serlib' ),
		'search_items'          =>    __( 'Buscar evento', 'serlib' ),
		'parent_item_colon'     =>    __( 'Evento principal:', 'serlib' ),
		'not_found'             =>    __( 'Evento no encontrado.', 'serlib' ),
		'not_found_in_trash'    =>    __( 'No hay eventos en la papelera.', 'serlib' )
	);

	register_post_type( 
		'evento' , 
		array(
			'labels'                =>  $eventos_labels,
			'description'           =>  __( 'Post type para evento fovea.', 'serlib' ),
			'public'                =>  true,
			'publicly_queryable'    =>  true,
			'show_ui'               =>  true,
			'show_in_menu'          =>  true,
			'query_var'             =>  true,
			'rewrite'               =>  array( 'slug' => 'eventos' ),
			'capability_type'       =>  'post',
			'has_archive'           =>  true,
			'hierarchical'          =>  false,
			'menu_icon'				=>  'dashicons-megaphone',
			'menu_position'         =>  115,
			'supports'              =>  [ 'title', 'editor', 'author', 'thumbnail', 'comments' ],
			'taxonomies'            =>  ['post_tag'],
			'show_in_rest'          =>  true
		)
	);
	/**
	 *  EMERGENCIAS CUSTOM POST TYPE 
	 */
	$emergencias_labels = array( 
		'name'                  =>    _x( 'EMERGENCIAS', 'post type general name eventos', 'serlib' ),
		'singular_name'         =>    _x( 'EMERGENCIAS', 'post type singular name eventos', 'serlib' ),
		'menu_name'             =>    _x( 'Emergencias', 'admin menu eventos', 'serlib' ),
		'name_admin_bar'        =>    _x( 'Emergencias', 'Agregar nuevo en la admin bar evento', 'serlib' ),
		'add_new'               =>    _x( 'Agregar Nuevo', 'agragar nuevo evento', 'serlib' ),
		'add_new_item'          =>    __( 'Agregar nuevo página de emergencias', 'serlib' ),
		'new_item'              =>    __( 'Nuevo página de emergencias', 'serlib' ),
		'edit_item'             =>    __( 'Editar Emergencia', 'serlib' ),
		'view_item'             =>    __( 'Ver Emergencias', 'serlib' ),
		'all_items'             =>    __( 'Todos las páginas de emergencias', 'serlib' ),
		'search_items'          =>    __( 'Buscar página de emergencia', 'serlib' ),
		'parent_item_colon'     =>    __( 'P. Emergencias principal:', 'serlib' ),
		'not_found'             =>    __( 'Página de emergencia no encontrado.', 'serlib' ),
		'not_found_in_trash'    =>    __( 'No hay páginas de emergencias en la papelera.', 'serlib' )
	);

	register_post_type( 
		'emergecias' , 
		array(
			'labels'                =>  $emergencias_labels,
			'description'           =>  __( 'Post type para emergencias fovea.', 'serlib' ),
			'public'                =>  true,
			'publicly_queryable'    =>  true,
			'show_ui'               =>  true,
			'show_in_menu'          =>  true,
			'query_var'             =>  true,
			'rewrite'               =>  array( 'slug' => 'emergencias' ),
			'capability_type'       =>  'post',
			'has_archive'           =>  true,
			'hierarchical'          =>  false,
			'menu_icon'				=>  'dashicons-warning',
			'menu_position'         =>  115,
			'supports'              =>  [ 'title', 'editor', 'author', 'thumbnail', 'comments' ],
			'taxonomies'            =>  [],
			'show_in_rest'          =>  true
		)
	);
	 
	
}