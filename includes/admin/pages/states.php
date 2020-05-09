<?php

function serlib_plugin_states_page()
{

?>
<div class="wrap" ng-app="serApp" ng-controller="stateController" ng-cloak>
    
    <h1 class="wp-heading-inline">
        <?php echo __('Departamentos', 'serlib'); ?> </h1>

    <a ng-click="create(null)" class="page-title-action"> <?php echo __('Añadir nuevo', 'serlib'); ?></a>

    <hr class="wp-header-end">
    <p ng-if="hasValue(error)"style="color:red">{{error}}</p>

    <form class="search-form search-plugins"  style="margin-top:-30px;">
        <p class="search-box">
            <input type="search" class="wp-filter-search" ng-model="search" placeholder="<?php echo __('Buscar departamento...', 'serlib'); ?>">
        </p>
    </form> 

    <div class="tablenav top">
        <div class="tablenav-pages one-page">
            <span class="displaying-num">{{ ( ObjectList | filter:search:strict).length }} <?php echo __('elementos', 'serlib'); ?></span>  
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
                <tr class="active" md-virtual-repeat="object in ObjectList | filter:search:strict">
                    <th ng-style="{'border-left': '4px solid ' + (object.is_active ? '#2ead2e' : 'red')}" 
                         class="check-column">
                        <input type="checkbox" ng-model="object.is_active" ng-change="toggleActive(object)" >
                    </th>
                    <td class=" column-primary"><strong>{{object.nombre}}</strong>
                        <div class="row-actions visible">
                            <span><a ng-click="update($event ,object)"><?php echo __('Actualizar', 'serlib'); ?></a></span>
                            <span><a ng-click="delete(object.ID, $index)" style="margin-left:3px; color:#9d3243;" ng-click="update(object)"><?php echo __('Borrar', 'serlib'); ?></a></span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php
}
