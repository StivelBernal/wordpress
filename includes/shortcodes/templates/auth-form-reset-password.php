NONCE_FIELD_PH
                       
<div ng-app="serAuth">
    <div class="row center-center auth">
        <div ng-controller="resetPass" class="s-50 ng-cloak">
            <div class="ser-form">  

                <form class="form-show-hide" name="recoverForm" style="padding-bottom:20px;">

                    <h2 style="text-align:center;">reset_pass_I18N</h2>

                    <div class="row-wrap " >
                                             
                        <div class="form-group s-100">
                            <label for="password">password1_I18N</label>
                            <input  class="fovea-input input-text" type="password" ng-model="Model.password" name="password" id="password" maxlength="255"  
                                    ng-pattern="/^((?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])).{6,}$/" required>
                            <div ng-messages="recoverForm.password.$error">
                                <div ng-message="required">required_I18N</div>
                                <div ng-message="pattern">'password_error_I18N'</div>
                            </div>
                            
                        </div>

                        <div class="form-group s-100">
                            <label for="password2">repeat_password_I18N</label>
                            <input class="fovea-input input-text" type="password" match="Model.password" name="password2" 
                                    ng-model="Model.password_confirm" id="password2" maxlength="255" required>
                            <div ng-messages="recoverForm.password2.$error">
                                <div ng-message="required">required_I18N</div>
                                <div ng-message="match">password_error_matchI18N</div>
                            </div>
                        </div>
                        
                        
                        <div class="row s-100 center-center" style="margin-top:20px;">
                            <div>
                                <button ng-click="submit()" ng-disabled="recoverForm.$invalid" class="bttn default s-100">
                                <div ng-if="is_submit" class="lds-ripple-small"><div></div><div></div></div>reset_pass_I18N</button>
                            </div>
                        </div>

                        <div ng-if="error" class="s-100">
                            <p style="text-align:center; color:red;">{{error}}</p>
                        </div>
                                       
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

