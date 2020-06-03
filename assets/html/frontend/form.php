<?php

// WordPress environment
require('../../../../../../wp-load.php' );

echo'
<div class="row toolbar-actions">
    <h2 md-truncate="" flex="">'.__('FORM', 'serlib').'</h2>
    <div class="s-flex"></div>
    <md-button>
    '.__('Agregar nuevo', 'serlib').'
    </md-button>
</div>
<div class="s-flex">
    <md-input-container class="s-47">
        <label>Nombre</label>
        <input ng-model="Model.nombre" >
    </md-input-container>

    <div class="flex"></div>
    <md-input-container class="s-47">
        <md-select ng-model="Model.state_id" placeholder="Selecciona departamento">
        <md-option ng-value="opt.ID" ng-repeat="opt in FormData">{{ opt.nombre }}</md-option>
        </md-select>
    </md-input-container>
    
    <textarea name="" id="" cols="30" rows="10"></textarea>
    
</div>';
?>
