<?php

// WordPress environment
require('../../../../../../wp-load.php' );

echo wp_nonce_field( 'serlib_form', '_wpnonce', true, false ) .'

<div ng-if="loader" class="loader"><div class="ser-ripple"><div></div><div></div></div></div>
</div>
<form>
    <div class="row toolbar-actions">
        <h2 md-truncate="" flex="">'.__('FORM', 'serlib').'</h2>
        <div class="s-flex"></div>
        <md-button ng-click="submit()">
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
            
            <summernote config="options" ng-model="Model.post_content"></summernote>
            
        </div>

        <div class="s-25 row-wrap center-start options-post" style="padding-right:20px;">
            <div class="s-100">
              Aqui ira imagen destacada y abra terminado
            </div>
            <div class="s-100">
                <div class="form-group s-flex">
                    <label>'.__('Categorias', 'serlib').'</label>      
                    <selector model="Model.post_category" name="categories" value-attr="term_id" Label-attr="name" multi="true" options="categories"></selector>
                </div>
            </div>
        </div>

    </div>
</form>';
?>
