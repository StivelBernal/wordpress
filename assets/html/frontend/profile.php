<?php

// WordPress environment
require('../../../../../../wp-load.php' );

echo wp_nonce_field( 'serlib_form', '_wpnonce', true, false ) .'
<div ng-if="loader" class="loader"><div class="ser-ripple"><div></div><div></div></div></div>
</div>

<form name="profile">

    <div class="row toolbar-actions">
        <h2 md-truncate="" flex="">'.__('PERFIL', 'serlib').'</h2>
        <div class="s-flex"></div>
        <md-button style="padding:0 20px;" ng-click="submitFiles()">
            '.__('Actualizar', 'serlib').'
        </md-button>
    </div>

    <div class="row-wrap center-center"> 
        
        <div class="s-70 content-post">
            
            <div class="s-100 center-center">
                <div class="profile-image-container">

                    <div><img id="img-profile" class="img-profile"  ng-src="{{profile_photo}}"></div> 
                    <label class="photo-profile row center-center" for="photo-profile"><span class="icon_camera"></span></label>
                    <input type="file" id="photo-profile" preview="profile_photo" ng-model="photo" accept="image/png, image/jpeg" app-filereader style="display:none;" > 
                    
                </div>
            </div>


            <div class="s-100">
                <div class="form-group s-100">
                    <label>'.__('Nombre', 'serlib').'</label>
                    <input class="md-primary" type="text" ng-model="Model.first_name" >
                </div>
            </div>

            <div class="s-100">
                <div class="form-group s-100">
                    <label>'.__('Apellido', 'serlib').'</label>
                    <input class="md-primary" type="text" ng-model="Model.last_name" >
                </div>
            </div>

            <div class="s-100">
                <div class="form-group s-100">
                    <label>'.__('Contraseña', 'serlib').'</label>
                    <input class="md-primary" type="text" name="password"  ng-pattern="/^((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])).{6,}$/" ng-model="Model.password" >

                    <div ng-messages="profile.password.$error">
                        <div ng-message="pattern">'.__('La contraseña debe tener mas de 6 caracteres, mayusculas, minusculas y numeros').'</div>
                    </div>

                </div>
            </div>
            
        </div>

        

    </div>
</form>';
?>

