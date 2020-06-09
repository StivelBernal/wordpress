<?php

// WordPress environment
require('../../../../../../wp-load.php' );

echo'
<div md-virtual-repeat-container>

    <div class="row toolbar-actions">
        <h2 md-truncate="" flex="">'.__('PUBLICACIONES', 'serlib').'</h2>
        <div class="s-flex"></div>
        <md-button  ui-sref="negocios.create">
            '.__('Agregar Nueva', 'serlib').'
        </md-button>
    </div>
';
?>
    <div class="crud-wrapper">
        <div class="item-wrapper">
            <strong class="s-flex uppercase"><?php echo __('Titulo', 'serlib'); ?></strong>
            <strong class="s-flex uppercase"><?php echo __('Extracto', 'serlib'); ?></strong>
            <strong class="s-flex uppercase text-center"><?php echo __('Imagen', 'serlib'); ?></strong>
            <div style="width:50px"></div>
        </div>

        <div class="item-wrapper" md-virtual-repeat="object in ObjectList">
            <div class="s-flex column uppercase">
                <strong><a ng-href="{{object.permalink}}" target="_blank">{{object.post_title}} <br>( {{ object.post_status === 'pending' ?'<?php echo __('Pendiente', 'serlib'); ?>': '<?php echo __('Publicada', 'serlib'); ?>' }} )</a></strong>
                <strong class="date">{{object.post_date }}</strong>
            </div>
            
            <strong class="s-flex uppercase">{{object.post_excerpt}}</strong>
            <div class="s-flex text-center"> 
                <img ng-src="{{object.thumbnail ? object.thumbnail: '/wp-content/plugins/ser_lib/assets/img/images.png'}}" width="80px">
            </div>
            <div style="width:50px">
                 <span ui-sref="negocios.update({ID: object.ID})" class="dashicons btnn-edit dashicons-edit-large"></span>
            </div>
        </div>
    </div>

</div>