<?php
  
// WordPress environment
require('../../../../../../wp-load.php' );
echo wp_nonce_field( 'serlib_form', '_wpnonce', true, false );
?>
<div md-virtual-repeat-container>

    <div class="row toolbar-actions">
        <div class="toggle_side" ng-click="toogle_side()"><i class="fa fa-bars" aria-hidden="true"></i></div>
        <h2 md-truncate="" flex=""><?php echo __('PUBLICACIONES', 'serlib'); ?></h2>
        <div class="s-flex"></div>
        <md-button  ui-sref="articulos.create"><?php echo __('Agregar Nuevo', 'serlib'); ?></md-button>   
    </div>

    <div class="crud-wrapper">
        <div class="item-wrapper">
            <strong class="s-flex uppercase"><?php echo __('Titulo', 'serlib'); ?></strong>
            <strong class="s-flex uppercase"><?php echo __('Extracto', 'serlib'); ?></strong>
            <strong class="s-flex uppercase text-center"><?php echo __('Imagen', 'serlib'); ?></strong>
            <strong class="s-10 uppercase text-center"><?php echo __('Acciones', 'serlib'); ?></strong>
        </div>

        <div class="item-wrapper" md-virtual-repeat="object in ObjectList">
            <div class="s-flex column uppercase title-p">
                <strong>
                    <a ng-href="{{object.permalink}}" target="_blank">{{object.post_title}} <br>
                        <em ng-if="object.post_status === 'pending'"><?php echo __('Pendiente', 'serlib'); ?></em>
                        <em ng-if="object.post_status === 'publish'"><?php echo __('Publicada', 'serlib'); ?></em>
                        <em ng-if="object.post_status === 'trash'"><?php echo __('Eliminada', 'serlib'); ?></em>
                    </a>
                </strong>
                <strong class="date">{{object.post_date }}</strong>
            </div>
            
            <div class="s-flex uppercase" style="font-weight:500;" ><span>{{object.post_excerpt}}</span></div>
             <div class="s-flex text-center"> 
                <img ng-src="{{object.thumbnail ? object.thumbnail: '/wp-content/plugins/ser_lib/assets/img/images.png'}}" width="80px">
            </div>
            <div class="s-10 text-center" >
                <span ng-if="rol === 'turista'" title="<?php echo __('editar', 'serlib'); ?>" ui-sref="publicaciones.update({ID: object.ID})" class="dashicons btnn-edit "><i class="fa fa-pencil"></i></span>
                <span ng-if="rol !== 'turista'" title="<?php echo __('editar', 'serlib'); ?>" ui-sref="articulos.update({ID: object.ID})" class="dashicons btnn-edit "><i class="fa fa-pencil"></i></span>
                <span title="<?php echo __('eliminar', 'serlib'); ?>"   ng-click="delete({ID: object.ID}, $event)" class="dashicons btnn-delete"> <i class="fa fa-trash-o"></i></span>
               
            </div>
        </div>
    </div>

</div>