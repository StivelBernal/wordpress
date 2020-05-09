NONCE_FIELD_PH
                       
<div ng-app="AUTHApp">
    <div class="row center-center auth">
        <div ng-controller="registerController" class="s-80 ng-cloak">
            <div class="ser-form" style="min-heigth:400px;">
                

                <form class="register form-show-hide " name="loginForm"  method="post">

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

                       
                        <div class="form-group s-95">
                            <label for="email">email_I18N</label>
                            <input type="email" class="fovea-input input-text" ng-model="Model.email" name="email" id="email" maxlength="150" required>
                            <div ng-messages="registerForm.email.$error">
                                <div ng-message="required">required_I18N</div>
                                <div ng-message="email">email_error_I18N</div>
                            </div>
                        </div>
                        
                        <div class="form-group s-95" >
                            <label for="password">password_I18N</label>
                            <input class="fovea-input input-text" type="password" ng-model="Model.password" name="password" id="password" maxlength="255"  
                                     required>
                            <div ng-messages="registerForm.password.$error">
                                <div ng-message="required">required_I18N</div>
                            </div>
                            
                        </div>
                                       
                    </div>
                    
                    <h4>register_aditional_I18N</h4>
                    
                    <div class="row-wrap space-around-center" >
                      
                        
                        <div class="form-group s-45">      
                            <selector model="Model.state_id" value-attr="ID" Label-attr="nombre" options="states"></selector>
                        </div>
                        
                        <div class="form-group s-45">
                            <selector model="ModelQuestions" value-attr="ID" Label-attr="nombre" options="cities"></selector>
                        </div> 

                        <div class="row s-100 center-center" style="margin-top:20px;">
                            <div >
                                <button ng-click="submit()" ng-disabled="registerForm.$invalid" class="bttn default s-100">register_I18N</button>
                            </div>
                        </div>
                        

                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

