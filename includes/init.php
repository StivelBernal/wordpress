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
			'rewrite'               =>  ['slug' => 'municipios'],
			'capability_type'       =>  'post',
			'has_archive'           =>  true,
			'hierarchical'          =>  false,
			'menu_position'         =>  5,
			'menu_icon'				=>  'dashicons-palmtree',
			'supports'              =>  [ 'title', 'editor', 'author', 'thumbnail', 'comments', 'excerpt' ],
			'taxonomies'            =>  [],
			'show_in_rest'          =>  true
		)
	);

	$blog_labels = array( 
		'name'                  =>    _x( 'Articulos', 'post type general name articulo', 'serlib' ),
		'singular_name'         =>    _x( 'Articulo', 'post type singular name articulo', 'serlib' ),
		'menu_name'             =>    _x( 'Articulos', 'admin menu articulo', 'serlib' ),
		'name_admin_bar'        =>    _x( 'Articulo', 'Agregar nuevo en la admin bar articulo', 'serlib' ),
		'add_new'               =>    _x( 'Agregar Nuevo', 'agregar nuevo articulo articulo', 'serlib' ),
		'add_new_item'          =>    __( 'Agregar nuevo articulo', 'serlib' ),
		'new_item'              =>    __( 'Nuevo articulo', 'serlib' ),
		'edit_item'             =>    __( 'Editar articulo', 'serlib' ),
		'view_item'             =>    __( 'Ver articulo', 'serlib' ),
		'all_items'             =>    __( 'Todos los articulos', 'serlib' ),
		'search_items'          =>    __( 'Buscar articulos', 'serlib' ),
		'parent_item_colon'     =>    __( 'Articulos principal:', 'serlib' ),
		'not_found'             =>    __( 'Articulo no encontrado.', 'serlib' ),
		'not_found_in_trash'    =>    __( 'No hay articulos en la papelera.', 'serlib' )
	);	

	register_post_type(
		'blog' , 
		array(
			'labels'                =>  $blog_labels,
			'description'           =>  __( 'Blog para usuarios turistas.', 'serlib' ),
			'public'                =>  true,
			'publicly_queryable'    =>  true,
			'show_ui'               =>  true,
			'show_in_menu'          =>  true,
			'query_var'             =>  true,
			'rewrite'               =>  true,
			'capability_type'       =>  'post',
			'has_archive'           =>  true,
			'hierarchical'          =>  false,
			'menu_position'         =>  5,
			'menu_icon'				=>  'dashicons-format-status',
			'supports'              =>  [ 'title', 'editor', 'author', 'thumbnail', 'comments', 'excerpt' ],
			'taxonomies'            =>  [],
			'show_in_rest'          =>  true
		)
	);

	register_taxonomy( 'tipos_entradas', 'post',
		[
			'label'			=>	'Tipos de post',
			'show_in_rest'	=>	true,
			'hierarchical' => true,
			'show_ui' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'rewrite' => array( 
				'with_front' => false,      
      			'hierarchical' => true  
			)
		]
	);

	
	register_taxonomy( 'categorias_articulos', 'blog',
		[
			'label'			=>	'Categorias articulos',
			'show_in_rest'	=>	true,
			'hierarchical' => true,
			'show_ui' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'rewrite' => array( 
				'with_front' => false,      
      			'hierarchical' => true  
			)
		]
	);
	/**Definimos urls */
	function tipos_entradas_permalink($permalink, $post_id, $leavename) { 
		if (strpos($permalink, '%tipos_entradas%') === false) return $permalink;
		
		$post = get_post($post_id); if (!$post) return $permalink;
		$terms = wp_get_object_terms($post->ID, 'tipos_entradas');
		if ( !is_wp_error($terms) && !empty($terms) && is_object($terms[0]) ) $taxonomy_slug = $terms[0]->slug;
		else $taxonomy_slug = 'todos';
		return str_replace('%tipos_entradas%', $taxonomy_slug, $permalink); 
	}

	add_filter('post_link', 'tipos_entradas_permalink', 10, 3);

	function blog_category_permalink($permalink, $post_id, $leavename) { 
		if (strpos($permalink, '%categorias_articulos%') === false) return $permalink;
		
		$post = get_post($post_id); if (!$post) return $permalink;
		$terms = wp_get_object_terms($post->ID, 'categorias_articulos');
		if ( !is_wp_error($terms) && !empty($terms) && is_object($terms[0]) ) $taxonomy_slug = $terms[0]->slug;
		else $taxonomy_slug = 'sin-categoria';
		return str_replace('%categorias_articulos%', $taxonomy_slug, $permalink); 
	}

	add_filter('post_type_link', 'tipos_entradas_permalink', 10, 3);

	/**Cambiar valor de los labels de entradas para que funcionen para os municipios */

	function modificar_post_label() {
		global $menu;
		global $submenu;
		$menu[5][0] = 'Publicaciones';
		$submenu['edit.php'][15][0] = 'Municipios';
		echo '';
	}

	add_action( 'admin_menu', 'modificar_post_label' );



	/**Quitamos el admin bar */
	$user = wp_get_current_user();
	if(isset($user->roles[0])){
			
		if( !in_array($user->roles[0], ['administrator', 'staff']) !== false){
			
			add_filter( 'show_admin_bar', '__return_false' );
			
			add_action( 'admin_init', 'restrict_admin_area_by_rol' );			
			
			function restrict_admin_area_by_rol(){
				wp_redirect( site_url('404') );
				exit;		
				}
			}
	}
	

}