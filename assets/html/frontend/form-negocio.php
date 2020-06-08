<?php

// WordPress environment
require('../../../../../../wp-load.php' );

$user = wp_get_current_user();
$roles =  $user->roles[0];


$TIPO = __('Negocios', 'serlib');

echo wp_nonce_field( 'serlib_form', '_wpnonce', true, false ) .'

<div ng-if="loader" class="loader"><div class="ser-ripple"><div></div><div></div></div></div>
</div>
<form>
    <div class="row toolbar-actions">
        <h2 md-truncate="" flex="">'.$TIPO.'</h2>
        <div class="s-flex"></div>
        <md-button ng-click="submitFiles()">
        {{ (Instance.post) ? "'.__('Editar', 'serlib').'": "'.__('Crear', 'serlib').'" }}
        </md-button>
    </div>

    <div class="row" ng-if="status">
        <div ng-if="send">'.__('Publicado', 'serlib').'</div>
        <div ng-if="revition">'.__('Su publicación esta en revisión', 'serlib').'</div>
        <div ng-if="error">'.__('Hubo un error en su publicación', 'serlib').'</div>
    </div>

    <div class="row-wrap"> 
        
        <div class="s-flex content-post">
            
            <div class="s-100">
                <div class="form-group s-100">
                    <md-input-container  titulo-post">
                            <label>Nombre</label>
                            <input class="md-primary" ng-model="Model.post_title" >
                    </md-input-container>
                </div>
            </div>
            
            <summernote config="options" id="summernote" ng-model="Model.post_content"></summernote>
            
        </div>

        <div class="s-25 row-wrap center-start options-post" style="padding-right:20px; padding-top:45px;">
          
            <div class="s-100">
                <div class="form-group s-flex">
                    <label>'.__('Municipios', 'serlib').'</label>      
                    <selector model="Model.post_category" name="municipios" value-attr="term_id" Label-attr="name" options="municipios"></selector>
                </div>
            </div>

            <div class="s-100">
                <div class="form-group s-flex">
                    <label>'.__('Categorias', 'serlib').'</label>      
                    <selector model="Model.tipo_entrada" name="tipo_entrada" value-attr="term_id" Label-attr="name" options="tipos"></selector>
                </div>
            </div>

            <div class="s-100 ">       
                <label>'.__('Imagen destacada','serlib').'</label>
                <div class="destacada-image-container">
                    <div><img class="img-destacada"  ng-src="{{featured}}"></div> 
                </div>
                <div class="form-group s-100">
                <label for="featured" class="input-file-label">{{ !featured_file.name ? "'.__('Seleccionar imagen','serlib').'": featured_file.name }} </label>      
                <input class="input_file" type="file" ng-model="featured_file" preview="featured" app-filereader accept="image/png, image/jpeg" app-filereader style="display:none;"  id="featured"></selector>
                
            </div>
            </div>
        </div>

    </div>
</form>';
?>
