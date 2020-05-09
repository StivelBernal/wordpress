<?php

function serlib_plugin_states_page()
{

?>
<div class="wrap" ng-app="serApp" ng-controller="stateController" ng-cloak>
    
        <h1 class="wp-heading-inline">
            <?php echo __('Departamentos', 'serlib'); ?> </h1>

        <a ng-click="create(null)" class="page-title-action"> <?php echo __('Añadir nuevo', 'serlib'); ?></a>

        <hr class="wp-header-end">

        <form class="search-form search-plugins"  style="margin-top:-30px;">
            <p class="search-box">
                <input type="search" class="wp-filter-search" ng-model="search" placeholder="<?php echo __('Buscar departamento...', 'serlib'); ?>">
            </p>
        </form> 

        <div class="tablenav top">
            
            <div class="tablenav-pages one-page"><span class="displaying-num">12 <?php echo __('elementos', 'serlib'); ?></span>
                
        </div>
    </div>
<table class="wp-list-table widefat plugins">
            <thead>
                <tr>
                    <th style="position: sticky; top: 0;"></th>
                    <th style="position: sticky; top: 0;" class="manage-column column-name column-primary"><?php echo __('Nombre', 'serlib'); ?></th>
                </tr>
            </thead>
    </table>
    <div md-virtual-repeat-container style="width:100%; min-height:100vh;">
    
        <table class="wp-list-table widefat plugins">
            <tbody id="the-list" >
                <tr class="active" md-virtual-repeat="state in states">
                    <th scope="row" class="check-column"><input type="checkbox" ng-click="toggleActive()" name="checked[]"></th>
                    <td class=" column-primary"><strong>{{state.nombre}}</strong>
                        <div class="row-actions visible">
                            <span><a ng-click="update(state)"><?php echo __('Actualizar', 'serlib'); ?></a></span>
                            <span><a ng-click="delete(state.ID)" style="margin-left:3px; color:#9d3243;" ng-click="update(state)"><?php echo __('Borrar', 'serlib'); ?></a></span>
                        </div>
                        
                    </td>

                </tr>
            </tbody>
    
        </table>
       
    </div>
</div>
<?php
}
