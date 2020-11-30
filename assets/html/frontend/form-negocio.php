<?php

// WordPress environment
require('../../../../../../wp-load.php' );

$user = wp_get_current_user();
$roles =  $user->roles[0];

$STEP1 = __('Galeria', 'serlib');
$STEP2 = __('Información', 'serlib');
$STEP3 = __('Servicios', 'serlib');
$STEP4 = __('Localización', 'serlib');

echo wp_nonce_field( 'serlib_form', '_wpnonce', true, false ) .'

<div ng-if="loader" class="loader"><div class="ser-ripple"><div></div><div></div></div></div>
</div>
<div class="row toolbar-actions p_tabs">
    <div class="toggle_side" ng-click="toogle_side()"><i class="fa fa-bars" aria-hidden="true"></i></div>
    <div class="s-flex"><p md-truncate="" ng-class="{active_step: step >= 1, active_hover: step === 1}" ng-click="set_step(1, false)"><i class="fa fa-camera" aria-hidden="true" title="'.$STEP1.'"></i><span>'.$STEP1.'</span></p></div>
    <div class="s-flex"><p md-truncate="" ng-class="{active_step: step >= 2, active_hover: step === 2, disabled: galery.length < 1 }" ng-click="set_step(2, (galery.length < 1))"><i class="dripicons-document" aria-hidden="true" title="'.$STEP2.'"></i><span>'.$STEP2.'</span></p></div>
    <div class="s-flex"><p md-truncate="" ng-class="{active_step: step >= 3, active_hover: step === 3, disabled: content.$invalid }" ng-click="set_step(3, content.$invalid)"><i class="fa fa-shopping-basket" aria-hidden="true" title="'.$STEP3.'"></i><span>'.$STEP3.'</span></p></div>
    <div class="s-flex"><p md-truncate="" ng-class="{active_step: step === 4, active_hover: step === 4, disabled: servicios.length < 1 }"  ng-click="set_step(4, (servicios.length < 1))"><i class="fa fa-map-marker" aria-hidden="true" title="'.$STEP4.'"></i><span>'.$STEP4.'</span></p></div>
    <div class="s-7"></div>
    <md-button  class="s-flex" ng-class="{finish: step === 4}" ';  ?> ng-disabled="content.$invalid || servicios.length < 1 || (busqueda !== '' && !busqueda)" <?php echo 'ng-click="submitFiles()">
    <span>{{ (Instance.post) ? "'.__('Guardar', 'serlib').'": "'.__('Crear', 'serlib').'" }}</span>
    </md-button>
</div>

<div class="row" ng-if="status">
    <div ng-if="send">'.__('Publicado', 'serlib').'</div>
    <div ng-if="revition">'.__('Su publicación esta en revisión', 'serlib').'</div>
    <div ng-if="error">'.__('Hubo un error en su publicación', 'serlib').'</div>
</div>


<div ng-if="step === 1" ng-class="{ validated_step: validated_step }">
    <p style="padding:20px 30px;">Recomendamos utilizar fotos de calidad y una alta resolución para que la primera impresión sea buena</p>
    <div class="row-wrap"> 
        
            <div class="s-25" ng-repeat="image in galery">       
                
                <div class="galery-image-container">
               
                ';
                ?>
                    <div><img class="img-galeria"  ng-src="{{preview_galery[$index] ? preview_galery[$index]: preview_default}}"></div> 
                <?php echo '
                    <span title="eliminar" ng-click="delete_image($index)" class="dashicons btnn-delete " role="button" tabindex="0"> <i class="fa fa-trash-o"></i></span>
             
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

<div ng-show="step === 2" ng-class="{ validated_step: validated_step }">

    <form name="content" class="row-wrap"> 
        
        <div class="s-flex content-post">
            
            <div class="s-100">
                <div class="form-group s-100">
                    <md-input-container  titulo-post">
                            <label>Nombre del negocio</label>
                            <input class="md-primary" ng-model="Model.post_title"  required>
                    </md-input-container>
                </div>
            </div>

            <div class="s-100 form-group ">
                <label>'.__('Slogan del negocio y/o horarios de atención:', 'serlib').'</label>
                <textarea rows="3" maxlength="50" ng-model="Model.post_excerpt" required></textarea>
            </div>

            <div class="row-wrap space-around-end""> 
                <div class="s-49" > 
                    <label>'.__('Telefono:', 'serlib').'</label>
                    <input ng-model="Model.telefono" type="text"  >
                </div>
                <div class="s-49" > 
                    <label>'.__('Whatsapp:', 'serlib').'</label>
                    <input ng-model="Model.whatsapp" placeholder="Número celular" type="text"  >
                </div>
                <div class="s-32" > 
                    <label>'.__('Facebook:', 'serlib').'</label>
                    <input ng-model="Model.facebook" placeholder="URL" type="text"  >
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
                    <input ng-model="Model.correo" placeholder="Ejemplo@gmail.com"  type="text"  >
                </div>

                <div class="s-49" > 
                    <label>'.__('Dirección:', 'serlib').'</label>
                    <input ng-model="Model.direccion" placeholder="Calle y carrera" type="text"  >
                </div>

            </div>

            <summernote config="options" id="summernote" ng-model="Model.post_content" required>descripcion</summernote>
            
        </div>
        
        <div class="s-25 row-wrap center-start options-post" style="padding-right:20px; padding-top:45px;">
        
            <div class="s-100">
                <div class="form-group s-flex">
                    <label>'.__('Municipio', 'serlib').'</label>      
                    <selector model="Model.post_category" name="municipios"  disable-search="true" value-attr="term_id" Label-attr="name" require="true" options="municipios"></selector>
                </div>
            </div>

            <div class="s-100">
                <div class="form-group s-flex">
                    <label>'.__('Categoria', 'serlib').'</label>      
                    <selector model="Model.tipo_entrada"  disable-search="true" name="tipo_entrada" value-attr="term_id" Label-attr="name" require="true" options="tipos"></selector>
                </div>
            </div>

            <div class="s-100">
                <div class="form-group s-flex">
                    <label>'.__('Etiquetas', 'serlib').'</label>      
                    <selector model="Model.tags"  disable-search="true" multi="true" name="tags" value-attr="term_id" Label-attr="name" require="true" options="tags"></selector>
                </div>
            </div>

            <div class="s-100 ">       
                <label>'.__('Imagen destacada','serlib').'</label>
                <div class="destacada-image-container">
                    <div><img class="img-destacada"  ng-src="{{featured}}"></div> 
                </div>
                <div class="form-group s-100">
                <label for="featured" class="input-file-label">{{ !featured_file.name ? "'.__('Seleccionar imagen','serlib').'": featured_file.name }} </label>      
                <input class="input_file" type="file" ng-model="featured_file" preview="featured" app-filereader accept="image/png, image/jpeg" app-filereader style="display:none;"  id="featured">
                <p style="padding:10px 0px; text-align:center;">Recomendamos utilizar fotos de calidad y una alta resolución para que la primera impresión sea buena</p>
            </div>
            </div>
        </div>

    </form>
</div>

<div ng-if="step === 3" style="padding:15px;" ng-class="{ validated_step: validated_step }">
    
    <div class="s-100 row ">       
                
        <div class="service-image-container">
            <div><button ng-click="add_service()">'.__('Agregar Servicio', 'serlib').'</button></div> 
        </div>

    </div>

    <div class="row-wrap">        
             
        <div class="s-50 " ng-repeat="servicio in servicios" >       
            
            <div class="form-group s-100">
                <label>'.__('Titulo:', 'serlib').'</label>
                <input ng-model="servicio.title"  placeholder="'.__('Titulo del servicio', 'serlib').'" type="text"  style="width:100%;" class="s-100" >
            </div>
            <div class="form-group s-100">
                <label>'.__('Descripcion:', 'serlib').'</label>
                <textarea rows="5" ng-model="servicio.text" indice="{{$index}}">
                </textarea>
            </div>
            <div class="form-group s-100 servicios-border">
              
                <div class="row space-around-end""> 
                    <div class="s-field" > 
                        <label>'.__('Precio:', 'serlib').'</label>
                        <input ng-model="servicio.price"  placeholder="$ 0,00" type="text"  >
                    </div>
                    <button class="s-field delete-service" ng-click="delete_service($index)">'.__('Eliminar Servicio', 'serlib').'</button>
                </div>
              
            </div>
            
        </div>         

    </div>

</div>

<div ng-show="step === 4" ng-class="{ validated_step: validated_step }">

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
