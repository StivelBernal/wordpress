NONCE_FIELD_PH
                       
<div ng-app="serAuth">
    <div class="row center-center auth">
        <div ng-controller="registerController" class="s-80 ng-cloak">
            <div class="ser-form" style="min-height:400px;">
            
                <div class="s-100" >
                    <div class="account-social"><h3>register_has_I18N</h3></div>
                    <md-radio-group class="row options-users" ng-model="Model.rol">

                        <md-radio-button value="turista" class="md-primary">turista_I18N</md-radio-button>
                        <md-radio-button value="comerciante">comerciante_I18N </md-radio-button>

                    </md-radio-group>
                </div>

                <form class="register form-show-hide " name="registerForm" ng-show="Model.rol == 'turista'"  method="post">

                    <h4>register_turista_I18N</h4>
                    
                    <div class="row-wrap space-around-center" >
                       
                        <div class="s-95">
                            
                            <div class="socials-buttons-auth row">
                                <div class="google ">Google</div>
                                <div class="facebook">Facebook</div>
                                <div class="instagram">Instagram</div>       
                            </div>
                            <div class="account-social"><h6>or_register_with_I18N</h6></div>
                        </div>

                        <div class="s-95" center-center">
                            <div class="profile-image-container">

                                <div><img id="img-profile" class="img-profile"  ng-src="{{profile_photo}}"></div> 
                                <label class="photo-profile row center-center" for="photo-profile"><span class="icon_camera"></span></label>
                                <input type="file" id="photo-profile" preview="profile_photo" ng-model="photo" accept="image/png, image/jpeg" app-filereader style="display:none;" > 
                                
                            </div>
                        </div>

                        <div class="form-group s-45">
                            <label for="nombre">nombre_I18N<span class="required"  >*</span></label>
                            <input type="text" name="nombre" ng-model="Model.nombre" id="nombre" class="fovea-input input-text" maxlength="40" required>
                            <div ng-messages="registerForm.nombre.$error">
                                <div ng-message="required">required_I18N</div>
                            </div>
                        </div>
                        <div class="form-group s-45">
                            <label for="apellido">apellido_I18N<span class="required"  >*</span></label>
                            <input type="text" name="apellido" ng-model="Model.apellido" id="apellido" class="fovea-input input-text" maxlength="40" required>
                            <div ng-messages="registerForm.apellido.$error">
                                <div ng-message="required">required_I18N</div>
                            </div>
                        </div>
                       
                        <div class="form-group s-45">
                            <label for="birthdate">fecha_nacimiento_I18N</label>
                            <datepicker  date-format="yyyy-MM-dd" button-prev-title="previous month"  button-next-title="next month" date-year-title="Click aqui">
                                <input  ng-model="Model.birthday" name="birthdate" id="birthdate" type="text" required/>
                            </datepicker>
                            <div ng-messages="registerForm.birthdate.$error">
                                <div ng-message="required">required_I18N</div>
                            </div>
                          
                        </div>

                        <div class="form-group s-45">
                            <label for="email">email_I18N</label>
                            <input type="email" class="fovea-input input-text" ng-model="Model.email" name="email" id="email" maxlength="150" required>
                            <div ng-messages="registerForm.email.$error">
                                <div ng-message="required">required_I18N</div>
                                <div ng-message="email">email_error_I18N</div>
                            </div>
                        </div>
                        
                        <div class="form-group s-45" ng-cloak>
                            <label for="password">password_I18N</label>
                            <input class="fovea-input input-text" type="password" ng-model="Model.password" name="password" id="password" maxlength="255"  
                                    ng-pattern="/^((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])).{6,}$/" required>
                            <div ng-messages="registerForm.password.$error">
                                <div ng-message="required">required_I18N</div>
                                <div ng-message="pattern">password_error_I18N</div>
                            </div>
                            
                        </div>
                        <div class="form-group s-45">
                            <label for="password2">repeat_password_I18N</label>
                            <input class="fovea-input input-text" type="password" match="Model.password" name="password2" 
                                    ng-model="Model.password_confirm" id="password2" maxlength="255" required>
                            <div ng-messages="registerForm.password2.$error">
                                <div ng-message="required">required_I18N</div>
                                <div ng-message="match">password_error_matchI18N</div>
                            </div>
                        </div>

                        <div class="form-group s-45">
                            <label for="telefono">telefono_I18N</label>
                            <input class="fovea-input input-text"  id="telefono" ng-model="Model.telefono" name="telefono" maxlength="20" type="text">
                            <div ng-messages="registerForm.telefono.$error">
                                <div ng-message="required">required_I18N</div>
                            </div>
                        </div>

                        <div class="form-group row space-around-center s-45">
                         
                            <div class="S-50">
                                <md-checkbox  aria-label="terminos_condiciones_I18N" ng-model="Model.terms">
                                    <a href="/terminos" target="_blank" >terminos_condiciones_I18N</a>
                                </md-checkbox>
                                <div ng-messages >
                                    <div  ng-if="!Model.terms === true">required_I18N</div>
                                </div>
                            </div>

                            <div class="S-50">
                                <md-checkbox  aria-label="politica_privacidad_I18N" ng-model="Model.policy">
                                    <a href="/politicas" target="_blank" >politica_privacidad_I18N</a>
                                </md-checkbox>
                                <div ng-messages >
                                    <div  ng-if="!Model.policy === true">required_I18N</div>
                                </div>
                            </div>

                        </div>

                                       
                    </div>
                    
                    <h4>register_aditional_I18N</h4>
                    
                    <div class="row-wrap space-around-center" >
                      
                        
                        <div class="form-group s-45">
                            <label for="telefono">Departamento_I18N</label>      
                            <selector model="Model.state_id" change="cityFilter(newValue)" value-attr="ID" Label-attr="nombre" options="states"></selector>
                        </div>
                        
                        <div class="form-group s-45">
                            <label for="telefono">Ciudad_I18N</label>
                            <selector model="Model.city_id" value-attr="ID" Label-attr="nombre" options="cities"></selector>
                        </div> 

                        <div class="form-group s-45">
                            <label for="telefono">Conocimiento_pagina_I18N</label>      
                            <selector model="Model.conocimiento_pagina" options="conocimientoPagina" ></selector>
                        </div>
                        
                        <div class="form-group s-45">
                            <label for="telefono">Intereses_I18N</label>
                            <selector model="Model.intereses" options=" Intereses" multi="true"></selector>
                        </div> 

                        <div class="form-group s-45">
                            <label for="telefono">Ciudades a visitar_I18N</label>
                            <selector model="Model.city_active" value-attr="ID" Label-attr="nombre" multi="true" options="cities_active"></selector>
                        </div> 

                        <div class="row s-100 center-center" style="margin-top:20px;">
                            <div >
                                <button ng-click="submit()" ng-disabled="registerForm.$invalid" class="bttn default s-100">register_I18N</button>
                            </div>
                        </div>
                        

                    </div>

                </form>

                <form class="register form-show-hide" name="c_Form" ng-show="Model.rol === 'comerciante'" >

                    <h4>register_comerciante_I18N</h4>

                    <div class="row-wrap space-around-center" >

                        <div class="s-95">
                            
                            <div class="socials-buttons-auth row">
                                <div class="google ">Google</div>
                                <div class="facebook">Facebook</div>
                                <div class="instagram">Instagram</div>       
                            </div>
                            <div class="account-social"><h6>or_register_with_I18N</h6></div>
                        </div>


                        <div class="s-95" center-center">
                            <div class="profile-image-container">

                                <div><img id="img-profile2" class="img-profile"  ng-src="{{profile_photo}}"></div> 
                                <label class="photo-profile row center-center" for="photo-profile"><span class="icon_camera"></span></label>
                                <input type="file" id="photo-profile2" class="photo-profile" preview="profile_photo" style="display: none;" preview="img-profile2"  ng-model="photo" accept="image/png, image/jpeg" app-filereader > 

                            </div>
                        </div>

                        <div class="form-group s-45">
                            <label for="c_nombre">nombre_I18N<span class="required"  >*</span></label>
                            <input type="text" name="nombre" ng-model="Model.nombre" id="c_nombre" class="fovea-input input-text" maxlength="40" required>
                            <div ng-messages="c_Form.nombre.$error">
                                <div ng-message="required">required_I18N</div>
                            </div>
                        </div>
                        <div class="form-group s-45">
                            <label for="c_apellido">apellido_I18N<span class="required"  >*</span></label>
                            <input type="text" name="apellido" ng-model="Model.apellido" id="c_apellido" class="fovea-input input-text" maxlength="40" required>
                            <div ng-messages="c_Form.apellido.$error">
                                <div ng-message="required">required_I18N</div>
                            </div>
                        </div>
                       
                        <div class="form-group s-45">
                            <label for="c_birthdate">fecha_nacimiento_I18N</label>
                            <datepicker  date-format="yyyy-MM-dd" button-prev-title="previous month"  button-next-title="next month" date-year-title="Click aqui">
                                <input  ng-model="Model.birthday" name="birthdate" id="c_birthdate" type="text" required/>
                            </datepicker>
                            <div ng-messages="c_Form.birthdate.$error">
                                <div ng-message="required">required_I18N</div>
                            </div>
                          
                        </div>

                        <div class="form-group s-45">
                            <label for="c_email">email_I18N</label>
                            <input type="email" class="fovea-input input-text" ng-model="Model.email" name="email" id="c_email" maxlength="150" required>
                            <div ng-messages="c_Form.email.$error">
                                <div ng-message="required">required_I18N</div>
                                <div ng-message="email">email_error_I18N</div>
                            </div>
                        </div>
                        
                        <div class="form-group s-45" ng-cloak>
                            <label for="c_password">password_I18N</label>
                            <input class="fovea-input input-text" type="password" ng-model="Model.password" name="password" id="c_password" maxlength="255"  
                                    ng-pattern="/^((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])).{6,}$/" required>
                            <div ng-messages="c_Form.password.$error">
                                <div ng-message="required">required_I18N</div>
                                <div ng-message="pattern">password_error_I18N</div>
                            </div>
                            
                        </div>
                        <div class="form-group s-45">
                            <label for="c_password2">repeat_password_I18N</label>
                            <input class="fovea-input input-text" type="password" match="Model.password" name="password2" 
                                    ng-model="Model.password_confirm" id="c_password2" maxlength="255" required>
                            <div ng-messages="c_Form.password2.$error">
                                <div ng-message="required">required_I18N</div>
                                <div ng-message="match">password_error_matchI18N</div>
                            </div>
                        </div>

                        <div class="form-group s-45">
                            <label for="c_telefono">telefono_I18N</label>
                            <input class="fovea-input input-text"  id="c_telefono" ng-model="Model.telefono" name="telefono" maxlength="20" type="text">
                            <div ng-messages="c_Form.telefono.$error">
                                <div ng-message="required">required_I18N</div>
                            </div>
                        </div>                        

                        <div class="form-group row space-around-center s-45">
                         
                            <div class="S-50">
                                <md-checkbox  aria-label="terminos_condiciones_I18N" ng-model="Model.terms">
                                    <a href="/terminos" target="_blank" >terminos_condiciones_I18N</a>
                                </md-checkbox>
                                <div ng-messages >
                                    <div  ng-if="!Model.terms === true">required_I18N</div>
                                </div>
                            </div>

                            <div class="S-50">
                                <md-checkbox  aria-label="politica_privacidad_I18N" ng-model="Model.policy">
                                    <a href="/politicas" target="_blank" >politica_privacidad_I18N</a>
                                </md-checkbox>
                                <div ng-messages >
                                    <div  ng-if="!Model.policy === true">required_I18N</div>
                                </div>
                            </div>

                        </div>

                        <div class="form-group s-30">
                            <label >Tipo_documento_I18N</label>      
                            <selector model="Model.TipoDocumento" options="tipo_documento"></selector>
                        </div>

                        <div class="form-group s-32">
                            <label for="d_number">Numero_documento_I18N</label>      
                            <input type="text" name="apellido"   id="d_number" class="fovea-input input-text" maxlength="20" required>
                        </div>

                        <div class="form-group s-24">
                            <label >Fotocopia_documento_I18N</label>
                            <label for="fotocopia_documento" class="input-file-label">{{ !File1.name ? 'Seleccionar archivo': File1.name }} </label>      
                            <input type="file" ng-model="File1" accept="image/png, image/jpeg" app-filereader style="display:none;"  id="fotocopia_documento"></selector>
                            
                        </div>
                    
                    </div>
                    <h4>register_aditional_I18N</h4>
                    
                    <div class="row-wrap space-around-center" >

                        <div class="form-group s-45">
                            <label >Conocimiento_pagina_I18N</label>      
                            <selector model="Model.conocimiento_pagina" change="cityFilter(newValue)" options="Intereses"></selector>
                        </div>

                        <div class="form-group s-45">
                            <label >Ciudades a visitar_I18N</label>
                            <selector model="Model.city_active" value-attr="ID" Label-attr="nombre" multi="true" options="cities_active"></selector>
                        </div> 
                        
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
