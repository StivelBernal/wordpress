<?php

include( 'pages/options.php' );
include( 'pages/cities.php' );
include( 'pages/states.php' );
   
function serlib_admin_menus(){
  add_menu_page(
    'Fovea Options',
    'Fovea Options',
    'edit_theme_options',
    'serlib_plugin_opts',
    'serlib_plugin_opts_page',
    'dashicons-admin-network',
    9
  );

  add_submenu_page(
    'serlib_plugin_opts',
    __('Ciudades', 'serlib'),
    __('Ciudades', 'serlib'),
    'manage_options',
    'serlib_cities',
    'serlib_plugin_cities_page'
  );

  add_submenu_page(
    'serlib_plugin_opts',
    __('Departamentos', 'serlib'),
    __('Departamentos', 'serlib'),
    'manage_options',
    'serlib_states',
    'serlib_plugin_states_page'
  );

  $tipos = get_terms([
    'hide_empty' => true,
    'order' => 'DESC',
    'taxonomy' => 'tipos_entradas' ]);
    
  foreach ($tipos as $key => $value) {
    add_submenu_page(
        'edit.php',
        $value->name,
        $value->name,
        'manage_options',
        'edit.php?tipos_entradas='.$value->name,
        ''
      );
  }
  

 

}