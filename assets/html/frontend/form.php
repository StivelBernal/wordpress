<?php

// WordPress environment
require('../../../../../../wp-load.php' );

echo'
<form>
<div class="row toolbar-actions">
    <h2 md-truncate="" flex="">'.__('FORM', 'serlib').'</h2>
    <div class="s-flex"></div>
    <md-button>
    '.__('Action', 'serlib').'
    </md-button>
</div>
<div class="row-wrap"> 
    <div class="s-100">
        <md-input-container class="s-70 titulo-post">
                <label>Titulo</label>
                <input class="md-primary" ng-model="Model.titulo" >
        </md-input-container>
    </div>
    <div class="s-flex content-post" >
     <summernote></summernote>
        
    </div>
    <div class="s-25 row-wrap center-start options-post">
        <div class="s-100">
            <md-input-container  titulo-post">
                    <label>Nombre</label>
                    <input class="md-primary" ng-model="Model.titulo" >
            </md-input-container>
        </div>
        <div class="s-100">
            <md-input-container>
                <md-select ng-model="Model.state_id" placeholder="Selecciona departamento">
                <md-option ng-value="opt.ID" ng-repeat="opt in FormData">{{ opt.nombre }}</md-option>
                </md-select>
            </md-input-container>
        </div>
    </div>
</div>
</form>';
?>
