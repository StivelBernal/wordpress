<div class="search_home" ng-app="search" ng-controller="formController" >
    <form name="search_home">

        <div class="row-wrap">

            <div class="form-group s-40">
                
                <input class="fovea-input input-text" ng-model="Model.busqueda" placeholder="buscar_placeholder_I18N"  type="text">
                         
            </div>
            <div class="form-group s-35">
                <selector model="Model.ciudad" value-attr="slug" Label-attr="name"  options="options_ciudades"></selector>      
            </div>
            
            <div class="s-flex">
                <button class="bttn default" ng-click="submit()">buscar_button_I18N</button>
            </div>

        </div>
    </form>
</div>
