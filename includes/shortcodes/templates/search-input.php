<div class="search_home" ng-app="search" ng-controller="formController" >
    <form name="search_home">

        <div class="row-wrap">

            <div class="form-group s-40">
                <input class="fovea-input input-text" placeholder="buscar_placeholder_I18N" required type="text">
                         
            </div>
            <div class="form-group s-35">
                <selector  name="conocimiento" require="true" model="Model.conocimiento_pagina" options="conocimientoPagina"></selector>          
            </div>
            
            <div class="s-flex">
                <button class="bttn default">buscar_button_I18N</button>
            </div>

        </div>

    </form>
</div>
