<?php

// WordPress environment
require('../../../../../../wp-load.php' );

$user = wp_get_current_user();
$roles =  $user->roles[0];

$STEP1 = __('Información', 'serlib');
$STEP2 = __('Redes sociales', 'serlib');
$STEP3 = __('Localización', 'serlib');

echo wp_nonce_field( 'serlib_form', '_wpnonce', true, false ) .'

<div ng-if="loader" class="loader"><div class="ser-ripple"><div></div><div></div></div></div>
</div>
<div class="row toolbar-actions p_tabs ">
    <div class="toggle_side" ng-click="toogle_side()"><i class="fa fa-bars" aria-hidden="true"></i></div>
    <div class="s-flex"><p md-truncate="" ng-class="{active_step: step >= 1}" ng-click="set_step(1, false)"><i class="dripicons-document" aria-hidden="true" title="'.$STEP1.'"></i><span>'.$STEP1.'</span></p></div>
    <div class="s-flex"><p md-truncate="" ng-class="{active_step: step >= 2}" ng-disabled="content.$invalid" ng-click="set_step(2, content.$invalid)"><i class="fa fa-users" title="'.$STEP2.'" aria-hidden="true"></i><span>'.$STEP2.'</span></p></div>
    <div class="s-flex"><p md-truncate="" ng-class="{active_step: step === 3}" ng-disabled="content.$invalid" ng-click="set_step(3, content.$invalid)"><i class="fa fa-marker" aria-hidden="true" title="'.$STEP3.'" ></i><span>'.$STEP3.'</span></p></div>
    <div class="s-7"></div>
    <md-button  class="s-flex" ng-class="{finish: step === 4}" ';  ?> ng-disabled="content.$invalid" <?php echo 'ng-click="submitFiles()">
        <span>{{ (Instance.post) ? "'.__('Guardar', 'serlib').'": "'.__('Crear', 'serlib').'" }}</span>
    </md-button>
</div>

<div class="row" ng-if="status">
    <div ng-if="send">'.__('Publicado', 'serlib').'</div>
    <div ng-if="revition">'.__('Su publicación esta en revisión', 'serlib').'</div>
    <div ng-if="error">'.__('Hubo un error en su publicación', 'serlib').'</div>
</div>




<div ng-show="step === 1">

    <form name="content" class="row-wrap"> 
        
        <div class="s-flex content-post">
            
            <div class="s-100">
                <div class="form-group s-100">
                    <md-input-container  titulo-post">
                            <label>Titulo del articulo</label>
                            <input class="md-primary" ng-model="Model.post_title"  required>
                    </md-input-container>
                </div>
            </div>

            <div class="s-100 form-group ">
                <label>'.__('Descripción corta:', 'serlib').'</label>
                <textarea rows="3" maxlength="255" ng-model="Model.post_excerpt" required></textarea>
            </div>

            <summernote config="options" id="summernote" ng-model="Model.post_content" required>descripcion</summernote>
            
        </div>
        
        <div class="s-25 row-wrap center-start options-post" style="padding-right:20px; padding-top:45px;">
        
            <div class="s-100">
                <div class="form-group s-flex">
                    <label>'.__('Municipio', 'serlib').'</label>      
                    <selector model="Model.post_category" name="municipios" value-attr="term_id" Label-attr="name" multi="true" require="true" options="municipios"></selector>
                </div>
            </div>

            <div class="s-100">
                <div class="form-group s-flex">
                    <label>'.__('Categoria', 'serlib').'</label>      
                    <selector model="Model.tipo_entrada"  name="tipo_entrada" value-attr="term_id" Label-attr="name" multiple="true" require="true" options="tipos"></selector>
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

    </form>

</div>

<div ng-if="step === 2" style="padding:15px;">   
                
    <div class="row-wrap space-around-end""> 
   
        <div class="s-49" > 
            <label>'.__('Telefono:', 'serlib').'</label>
            <input ng-model="Model.telefono"  placeholder="Número fijo o celular" type="text"  >
        </div>
        <div class="s-49" > 
            <label>'.__('Whatsapp:', 'serlib').'</label>
            <input ng-model="Model.whatsapp"  type="text"  placeholder="Número celular" >
        </div>
        <div class="s-32" > 
            <label>'.__('Facebook:', 'serlib').'</label>
            <input ng-model="Model.facebook"  type="text" placeholder="URL" >
        </div>

        <div class="s-32" > 
            <label>'.__('Página web:', 'serlib').'</label>
            <input ng-model="Model.web"  type="text" placeholder="URL" >
        </div>

        <div class="s-32" > 
            <label>'.__('Instagram:', 'serlib').'</label>
            <input ng-model="Model.instagram" placeholder="URL"  type="text"  >
        </div>

        <div class="s-49" > 
            <label>'.__('Correo:', 'serlib').'</label>
            <input ng-model="Model.correo" placeholder="Ejemplo@gmail.com" type="text"  >
        </div>

        <div class="s-49" > 
            <label>'.__('Dirección:', 'serlib').'</label>
            <input ng-model="Model.direccion" placeholder="Calle y carrera" type="text"  >
        </div>

    </div>


</div>

<div ng-show="step === 3">

    <div class="row-wrap">
        
        <div style="padding:30px;" class="s-50">  
    
            <div class="form-group s-flex"> 
             <label>'.__('Escribe la dirección de tu negocio', 'serlib').'</label> 
                <input ng-model="busqueda_mapa"  placeholder="'.__('Ciudad, calle - carrera', 'serlib').'" type="text"  ng-change="set_map_src(busqueda_mapa)" style="width:100%;" class="s-100" >
            </div>
           
        </div>
        
        <div class="s-50" id="gmap_canvas style="padding:30px;" >
             <iframe width="600" height="500"'; ?>  ng-src="{{'https://maps.google.com/maps?q='+busqueda+'&t=&z=9&ie=UTF8&iwloc=&output=embed'}}" <?php echo' frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>           
               
        </div>
        
    </div>

</div>


</form>';
?>
