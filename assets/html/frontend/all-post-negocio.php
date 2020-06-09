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
    <div class="crud-wrapper row-wrap">
       
        <div class="item-wrapper s-20" md-virtual-repeat="object in ObjectList">
            <div class="column uppercase"> 
                <img ng-src="{{object.thumbnail ? object.thumbnail: '/wp-content/plugins/ser_lib/assets/img/images.png'}}" 
                width="100%" style="height: 150px">
                
                <strong><a ng-href="{{object.permalink}}" target="_blank">{{object.post_title}} <br>( {{ object.post_status === 'pending' ?'<?php echo __('Pendiente', 'serlib'); ?>': '<?php echo __('Publicada', 'serlib'); ?>' }} )</a></strong>
                <strong class="date">{{object.post_date }}</strong>

                <div style="width:50px">
                    <span ui-sref="negocios.update({ID: object.ID})" class="dashicons btnn-edit dashicons-edit-large"></span>
                </div>
            </div>
            
        </div>
    </div>

</div>