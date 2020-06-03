<?php

// WordPress environment
require('../../../../../../wp-load.php' );

echo'
<div md-virtual-repeat-container>

    <div class="row toolbar-actions">
        <h2 md-truncate="" flex="">'.__('PUBLICACIONES', 'serlib').'</h2>
        <div class="s-flex"></div>
        <md-button  ui-sref="publicaciones.form">
            '.__('Agregar Nueva', 'serlib').'
        </md-button>
    </div>
';
?>
    <div class="crud-wrapper">
        <div class="item-wrapper">
            <strong class="s-flex uppercase">Nombre</strong>
            <strong class="s-flex uppercase">Preguntas</strong>
        </div>

        <div class="item-wrapper" md-virtual-repeat="object in ObjectList">
            <strong class="s-flex uppercase"><a ng-href=""" target="_blank">Nombre</a></strong>
            <strong class="s-flex uppercase">Preguntas</strong>
        </div>
    </div>

</div>