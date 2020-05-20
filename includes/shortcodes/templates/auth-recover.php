NONCE_FIELD_PH
                       
<div ng-app="serAuth">
    <div class="row center-center auth">
        <div ng-controller="recoverController" class="s-50 ng-cloak">
            <div class="ser-form">  

                <form class="form-show-hide" name="recoverForm" style="padding-bottom:20px;">

                    <h4>recover_account_I18N</h4>

                    <div class="row-wrap " >
                                             
                        <div class="form-group s-100">
                            <label for="email">email_I18N</label>
                            
                            <input type="email" class="fovea-input input-text"  autocomplete="on" ng-model="Model.email" name="email" id="email" maxlength="150" required>
                            <div class="row-wrap" ng-messages="recoverForm.email.$error">
                                <div ng-message="required">required_I18N</div>
                                <div style="margin-left:10px;" ng-message="email">email_error_I18N</div>
                            </div>
                        </div>
                        
                        
                        <div class="row s-100 center-center" style="margin-top:20px;">
                            <div>
                                <button ng-click="submit()" ng-disabled="recoverForm.$invalid" class="bttn default s-100">
                                <div ng-if="is_submit" class="lds-ripple-small"><div></div><div></div></div>recover_I18N</button>
                            </div>
                        </div>

                        <div ng-if="error" class="s-100">
                            <p style="text-align:center; color:red;">{{error}}</p>
                        </div>
                        <div ng-if="user_recover"  class="s-100">
                            <p style="text-align:center; color:green;">email_info_I18N</p>
                        </div>
                                       
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

