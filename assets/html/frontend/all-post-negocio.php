<?php

// WordPress environment
require('../../../../../../wp-load.php' );
echo wp_nonce_field( 'serlib_form', '_wpnonce', true, false );
echo'
<div md-virtual-repeat-container>

    <div class="row toolbar-actions">
        <div class="toggle_side" ng-click="toogle_side()"><i class="fa fa-bars" aria-hidden="true"></i></div>
        <h2 md-truncate="" flex="">'.__('PUBLICACIONES', 'serlib').'</h2>
        <div class="s-flex"></div>
        <md-button  ui-sref="negocios.create">
            '.__('Agregar Nueva', 'serlib').'
        </md-button>
    </div>
';
?>
    <div class="crud-wrapper row-wrap">
       
        <div class="item-wrapper s-20" md-virtual-repeat="object in ObjectList">
            <div class="column uppercase"> 
                <img ng-src="{{object.thumbnail ? object.thumbnail: '/wp-content/plugins/ser_lib/assets/img/images.png'}}" 
                width="100%" style="height: 150px">
                <strong >
                    <a ng-href="{{object.permalink}}" target="_blank">{{object.post_title}} <br>
                        <em ng-if="object.post_status === 'pending'"><?php echo __('Pendiente', 'serlib'); ?></em>
                        <em ng-if="object.post_status === 'publish'"><?php echo __('Publicada', 'serlib'); ?></em>
                        <em ng-if="object.post_status === 'trash'"><?php echo __('Eliminada', 'serlib'); ?></em>
                    </a>
                </strong>
                <strong class="date">{{object.post_date }}</strong>

                <div class="row">
                    <span title="<?php echo __('editar', 'serlib'); ?>"  ui-sref="negocios.update({ID: object.ID})" class="dashicons btnn-edit "><i class="fa fa-pencil"></i></span>
                    <span title="<?php echo __('eliminar', 'serlib'); ?>"   ng-click="delete({ID: object.ID}, $event)" class="dashicons btnn-delete"> <i class="fa fa-trash-o"></i></span>
                </div>
            </div>
            
        </div>
    </div>

</div>