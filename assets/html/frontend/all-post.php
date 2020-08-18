<?php
  
// WordPress environment
require('../../../../../../wp-load.php' );
echo wp_nonce_field( 'serlib_form', '_wpnonce', true, false );
?>
<div md-virtual-repeat-container>

    <div class="row toolbar-actions">
        <h2 md-truncate="" flex=""><?php echo __('PUBLICACIONES', 'serlib'); ?></h2>
        <div class="s-flex"></div>
        <md-button ng-if="rol === 'turista'" ui-sref="publicaciones.create"><?php echo __('Agregar Nueva', 'serlib'); ?></md-button>
        <md-button ng-if="rol !== 'turista'" ui-sref="articulos.create"><?php echo __('Agregar Nuevo', 'serlib'); ?></md-button>   
    </div>

    <div class="crud-wrapper">
        <div class="item-wrapper">
            <strong class="s-flex uppercase"><?php echo __('Titulo', 'serlib'); ?></strong>
            <strong class="s-flex uppercase"><?php echo __('Categorias', 'serlib'); ?></strong>
            <strong class="s-flex uppercase text-center"><?php echo __('Imagen', 'serlib'); ?></strong>
            <strong class="s-10 uppercase text-center"><?php echo __('Acciones', 'serlib'); ?></strong>
           
        </div>

        <div class="item-wrapper" md-virtual-repeat="object in ObjectList">
            <div class="s-flex column uppercase">
                <strong><a ng-href="{{object.permalink}}" target="_blank">{{object.post_title}} <br>( {{ object.post_status === 'pending' ?'<?php echo __('Pendiente', 'serlib'); ?>': '<?php echo __('Publicada', 'serlib'); ?>' }} )</a></strong>
                <strong class="date">{{object.post_date }}</strong>
            </div>
            
            <div class="s-flex uppercase" style="font-weight:600;" ng-if="object.post_category !== false"><span ng-repeat="cat in object.post_category" ng-class="{in:!$first}" >{{cat.name}}</span></div>
            <div class="s-flex uppercase" ng-if="object.post_category == false"><strong><?php echo __('sin categoria', 'serlib'); ?></strong> </div>
            <div class="s-flex text-center"> 
                <img ng-src="{{object.thumbnail ? object.thumbnail: '/wp-content/plugins/ser_lib/assets/img/images.png'}}" width="80px">
            </div>
            <div class="s-10 text-center" >
                <span ng-if="rol === 'turista'" title="<?php echo __('editar', 'serlib'); ?>" ui-sref="publicaciones.update({ID: object.ID})" class="dashicons btnn-edit "><i class="fa fa-pencil"></i></span>
                <span ng-if="rol !== 'turista'" title="<?php echo __('editar', 'serlib'); ?>" ui-sref="articulos.update({ID: object.ID})" class="dashicons btnn-edit "><i class="fa fa-pencil"></i></span>
                <span title="<?php echo __('eliminar', 'serlib'); ?>"   ng-click="delete({ID: object.ID})" class="dashicons btnn-delete"> <i class="fa fa-trash-o"></i></span>
               
            </div>
        </div>
    </div>

</div>