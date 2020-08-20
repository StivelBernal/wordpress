NONCE_FIELD_PH
                       
<div ng-app="serAuth">
    <div class="row center-center auth">
        <div ng-controller="loginController" class="s-50 ng-cloak">
            <div class="ser-form" style="min-height:400px;">  

                <form class="register form-show-hide " name="loginForm">

                    <h4>login_I18N</h4>

                    <div class="row-wrap " >
                                             
                        <div class="form-group s-100">
                            <label for="email">email_I18N</label>
                            
                            <input autocomplete="on" type="email" class="fovea-input input-text"  ng-model="Model.email" name="email" id="email" maxlength="150" required>
                            <div class="row-wrap" ng-messages="loginForm.email.$error">
                                <div ng-message="required">required_I18N</div>
                                <div style="margin-left:10px;" ng-message="email">email_error_I18N</div>
                            </div>
                        </div>
                        
                        <div class="form-group s-100" style="margin-top:10px;">
                            <label for="password">password_I18N</label>
                            <input class="fovea-input input-text" type="password" ng-model="Model.password" name="password" id="password" maxlength="255"  
                                     required>
                            <div class="row-wrap" ng-messages="loginForm.password.$error">
                                <div  ng-message="required">required_I18N</div>
                            </div>
                            
                        </div>
                        <div class="s-100 options-login row space-around-center">
                           
                            <md-checkbox class="margin-0 md-primary" ng-model="Model.remembermme">
                                Remember_me_I18N
                            </md-checkbox>
                              
                            <p class=" margin-0 register-login lost_password">
                                <a href="/auth/recover-account/">Lost_your_pass_I18N</a>
                            </p>
                        </div>
                        
                        <div class="row s-100 center-center" style="margin-top:20px;">
                            <div>
                                <button ng-click="submit()" ng-disabled="loginForm.$invalid" class="bttn default s-100">
                                <div ng-if="is_submit" class="lds-ripple-small"><div></div><div></div></div>login_I18N</button>
                            </div>
                        </div>

                        <div ng-if="error" class="s-100">
                            <p style="text-align:center; color:red;">{{error}}</p>
                        </div>
                        <div ng-if="user_login"  class="s-100">
                            <p style="text-align:center; color:green;">Inicio_de_session_I18N</p>
                        </div>
                         
                        <div class="s-100" style="margin-top:20px; margin:0 10px;">
                            
                            <div class="account-social"><h6>or_login_with_I18N</h6></div>
                            <div class="socials-buttons-auth row">
                                <div class="google" g-login>Google</div>
                                <div ng-click="AuthSocial('facebook')" class="facebook">Facebook</div>
                                <?php /*<div ng-click="InstagramRedirect()" class="instagram">Instagram</div> */ ?>      
                            </div>
                        </div>

                        <div class="s-100 options-login row space-around-center">
                                                       
                            <p>
                                <span class="no-have-account" >No_tienes_cuenta_I18N </span> <a class="register-login"  href="/auth/register/">Registerme_I18N</a>
                            </p>
                        </div>

                                       
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

