<?php

// WordPress environment
require('../../../../../../wp-load.php' );

$user = wp_get_current_user();
$roles =  $user->roles[0];


$STEP1 = __('Galeria', 'serlib');
$STEP2 = __('información', 'serlib');
$STEP3 = __('Servicios', 'serlib');
$STEP4 = __('Localización', 'serlib');

echo wp_nonce_field( 'serlib_form', '_wpnonce', true, false ) .'

<div ng-if="loader" class="loader"><div class="ser-ripple"><div></div><div></div></div></div>
</div>
<div class="row toolbar-actions">
    
    <div class="s-flex"><p md-truncate="" ng-class="{active_step: step >= 1}" ng-click="set_step(1)">'.$STEP1.'</p></div>
    <div class="s-flex"><p md-truncate="" ng-class="{active_step: step >= 2}" ng-click="set_step(2)">'.$STEP2.'</p></div>
    <div class="s-flex"><p md-truncate="" ng-class="{active_step: step >= 3}" ng-click="set_step(3)">'.$STEP3.'</p></div>
    <div class="s-flex"><p md-truncate="" ng-class="{active_step: step === 4}" ng-click="set_step(4)">'.$STEP4.'</p></div>
    <div class="s-7"></div>
    <md-button  class="s-flex" ng-class="{finish: step === 4}" ';  ?> ng-disabled=" step < 4 || (Model.post_title !== '' && !Model.post_title)" <?php echo 'ng-click="submitFiles()">
    {{ (Instance.post) ? "'.__('Editar', 'serlib').'": "'.__('Crear', 'serlib').'" }}
    </md-button>
</div>

<div class="row" ng-if="status">
    <div ng-if="send">'.__('Publicado', 'serlib').'</div>
    <div ng-if="revition">'.__('Su publicación esta en revisión', 'serlib').'</div>
    <div ng-if="error">'.__('Hubo un error en su publicación', 'serlib').'</div>
</div>

<form>
<div ng-if="step === 1">

    <div class="row-wrap"> 
        
            <div class="s-25" ng-repeat="image in galery">       
                
                <div class="galery-image-container">';
                ?>
                    <div><img class="img-galeria"  ng-src="{{preview_galery[$index] ? preview_galery[$index]: preview_default}}"></div> 
                <?php echo '
                </div>
                <div class="form-group s-100">
                    <label for="featured{{$index}}" class="input-file-label">{{ !galery[$index].name ? "'.__('Seleccionar imagen','serlib').'": galery[$index].name }} </label>      
                    <input class="input_file" type="file" ng-model="galery[$index]" indice="{{$index}}" preview-array="preview_galery" app-filereader accept="image/png, image/jpeg" app-filereader style="display:none;"  id="featured{{$index}}">
                </div>
            </div> 


            <div class="s-25 row center-center">       
                
                <div class="galery-image-container more-images">
                    <div><img ng-click="add_galery()" src="/wp-content/plugins/ser_lib/assets/img/more_images2.png"></div> 
                </div>
    
            </div>

    </div>

</div>

<div ng-show="step === 2">

    <div class="row-wrap"> 
        
        <div class="s-flex content-post">
            
            <div class="s-100">
                <div class="form-group s-100">
                    <md-input-container  titulo-post">
                            <label>Nombre del negocio</label>
                            <input class="md-primary" ng-model="Model.post_title" >
                    </md-input-container>
                </div>
            </div>
            
            <summernote config="options" id="summernote" ng-model="Model.post_content"></summernote>
            
        </div>

        <div class="s-25 row-wrap center-start options-post" style="padding-right:20px; padding-top:45px;">
        
            <div class="s-100">
                <div class="form-group s-flex">
                    <label>'.__('Municipio', 'serlib').'</label>      
                    <selector model="Model.post_category" name="municipios" value-attr="term_id" Label-attr="name" options="municipios"></selector>
                </div>
            </div>

            <div class="s-100">
                <div class="form-group s-flex">
                    <label>'.__('Categoria', 'serlib').'</label>      
                    <selector model="Model.tipo_entrada" multi="true" name="tipo_entrada" value-attr="term_id" Label-attr="name" options="tipos"></selector>
                </div>
            </div>

            <div class="s-100 ">       
                <label>'.__('Imagen destacada','serlib').'</label>
                <div class="destacada-image-container">
                    <div><img class="img-destacada"  ng-src="{{featured}}"></div> 
                </div>
                <div class="form-group s-100">
                <label for="featured" class="input-file-label">{{ !featured_file.name ? "'.__('Seleccionar imagen','serlib').'": featured_file.name }} </label>      
                <input class="input_file" type="file" ng-model="featured_file" preview="featured" app-filereader accept="image/png, image/jpeg" app-filereader style="display:none;"  id="featured"></selector>
                
            </div>
            </div>
        </div>

    </div>
</div>

<div ng-if="step === 3">
    
    <div class="s-100 row ">       
                
        <div class="service-image-container">
            <div><button ng-click="add_service()">Agregar Servicio</button></div> 
        </div>

    </div>

    <div class="row-wrap">        
            
        <div class="s-50" ng-repeat="servicio in servicios">       
            
            <div class="form-group s-100">
                
                <textarea rows="5" ng-model="servicio.text" indice="{{$index}}">
                </textarea>
            </div>
        </div>         

    </div>

</div>

<div ng-if="step === 4">

    <div class="row-wrap">
        
        <div style="padding:30px;" class="s-50 ">  
        
        <h4>
            Pega a qui el codigo de google maps para mostrar el mapa o
            <a style="text-decoration:underline;" href="https://www.embedgooglemap.net/en/" target="_blank" >
            generalo en este enlace</a> 
        </h4>

            <textarea style="width:100%;" ng-change="bind_mapa(mapa)" rows="10" ng-model="mapa" >
            </textarea>
        </div>
        <div class="s-50" style="padding:30px;" id="mapa"></div>
    </div>

</div>


</form>';
?>
