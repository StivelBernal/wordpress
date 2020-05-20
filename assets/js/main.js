(function($){
    $("#destino_rating").bind( 'rated', function(){
        
        $(this).rateit( 'readonly', true );

        var form        =   {
            action:         'serlib_rate_destino',
            rid:            $(this).data( 'rid' ),
            rating:         $(this).rateit( 'value' )
        };

        $.post( front_obj.ajax_url, form, function(data){
            
        });
    });
})(jQuery);

var app = angular.module('serAuth', ['SER.selector', 'ngMaterial', 'ngMessages', 'SER.match', 'socialLogin', '720kb.datepicker'])
    .config(function ($mdThemingProvider) {
        $mdThemingProvider.theme('default')
            .primaryPalette('light-green');
    })
    .config(['$compileProvider', function ($compileProvider) {
        $compileProvider.debugInfoEnabled(false);
    }])
    .config(['socialProvider', function (socialProvider) {
        socialProvider.setGoogleKey(google_key);
    }]);


app.controller('loginController', ['$scope', '$http', '$controller', 
                function loginController($scope, $http, $controller) {

                    $controller('authSocialController', {
                        $scope: $scope,
                        Config: {
                            action: 'login',
                        }
                    });
                    
                                       
                    $scope.error  = false;
                    $scope.user_login = false;
                    $scope.is_submit = false;
                    $scope.Model = { remembermme: false, _wpnonce: angular.element('#_wpnonce').val(), modo: 'directo' }

                    $scope.submit = function(){
                        if($scope.is_submit) return;
                        
                         $scope.is_submit = true;
                         $scope.error  = false;
                          
                         $http( {
                             method: 'POST',
                             params: { action: 'serlib_auth_handler', 'login': ''},
                             url:    front_obj.ajax_url,
                             data:   $scope.Model,
                         }).then(function successCallback(response) {
                             
                             if(response.data.success){
                                 $scope.user_login = true;
                                 setTimeout(() => { window.location = "/blog"; }, 1000);
                             }else if(response.data.error){
                                 $scope.error = response.data.error;
                                 $scope.is_submit = false;
                             }
                         }, function errorCallback(error) {
                             $scope.is_submit = false;
                             $scope.error =  error.data;            
                         });
             
                        
                     }

}]);

app.controller('recoverController', ['$scope', '$http', 
                function recoverController($scope, $http) {       
                                       
                    $scope.error  = false;
                    $scope.user_recover = false;
                    $scope.is_submit = false;
                    $scope.Model = { _wpnonce: angular.element('#_wpnonce').val(), email: '' }

                    $scope.submit = function(){
                        if($scope.is_submit) return;
                        
                         $scope.is_submit = true;
                         $scope.error  = false;
                          
                         $http( {
                             method: 'POST',
                             params: { action: 'serlib_auth_handler', 'recover': ''},
                             url:    front_obj.ajax_url,
                             data:   $scope.Model,
                         }).then(function successCallback(response) {

                             if(response.data.success){
                                 $scope.user_recover = true;
                             }else if(response.data.error){
                                 $scope.error = response.data.error;
                                 $scope.is_submit = false;
                             }
                         }, function errorCallback(error) {
                             $scope.is_submit = false;
                             $scope.error =  error.data;            
                         });
             
                        
                     }

}]);
app.controller('resetPass', ['$scope', '$http', 
                function resetPass($scope, $http) {       
                                       
                    $scope.error  = false;
                    $scope.user_recover = false;
                    $scope.is_submit = false;
                    $scope.Model = { _wpnonce: angular.element('#_wpnonce').val(), u: o.u, code: o.code }

                    $scope.submit = function(){

                        if($scope.is_submit) return;
                        
                         $scope.is_submit = true;
                         $scope.error  = false;
                          
                         $http( {
                             method: 'POST',
                             params: { action: 'serlib_auth_handler', 'reset_pass': ''},
                             url:    front_obj.ajax_url,
                             data:   $scope.Model,
                         }).then(function successCallback(response) {

                             if(response.data.success){
                                 window.location = '/';
                             }
                         }, function errorCallback(error) {
                             $scope.is_submit = false;
                             $scope.error =  error.data;            
                         });
             
                        
                     }

}]);


app.controller('registerController', ['$scope', '$http', '$controller',  
                function registerController($scope, $http, $controller ) {
        
        $controller('authSocialController', {
            $scope: $scope,
            Config: {
                action: 'register',
            }
        });
        
        $scope.profile_photo = 'https://golfodemorrosquillo.com/wp-content/uploads/2020/05/240_F_64676383_LdbmhiNM6Ypzb3FM4PPuFP9rHe7ri8Ju.jpg';
       
        $scope.Instance = JSON.parse(sessionStorage.getItem('auth'));
        
        $scope.UpdateInstance = function(){
          
            if( !hasValue($scope.Instance ) ){
                $scope.Model = { modo: 'directo', _wpnonce: angular.element('#_wpnonce').val() };
            }else{
                
                $scope.profile_photo = hasValue($scope.Instance.picture) ? $scope.Instance.picture: $scope.profile_photo;
                
                if($scope.Instance.modo === 'instagram'){
               
                    var instagramForm = JSON.parse(sessionStorage.getItem('auth_instagram'));       
                    $scope.Model = angular.merge(instagramForm, { modo: $scope.Instance.modo, nombre: $scope.Instance.username, photo_url: '', _wpnonce: angular.element('#_wpnonce').val() });
            
                }else{      
                    $scope.Model = angular.merge( $scope.Model, { modo: $scope.Instance.modo, nombre: $scope.Instance.first_name, apellido: $scope.Instance.last_name, email: $scope.Instance.email, photo_url: '', _wpnonce: angular.element('#_wpnonce').val() } );
                    
                }

            }
            
        }
        
        $scope.UpdateInstance();

        /**Options */
        $scope.error  = false;
        $scope.user_created = false;
        $scope.is_submit = false;
        $scope.states = [];
        $scope.modo = 'directo';
        $scope.cities = [];
        $scope.photo = [], $scope.files = [];
        $scope.conocimientoPagina = [ 'Volante' , 'Correo Electrónico', 'Amigo', 'Redes Sociales', 'Otro' ],
        $scope.Intereses = ['Hospedaje', 'Gastronomía', 'Sitios', 'Diversión', 'Cultura', 'Transporte' ];  
        $scope.tipo_documento = ['Cedula ciudadania', 'Pasaporte', 'Visa',  'Cedula Extrangera' ];      

        $http({
            method: 'GET',
            params: { action: 'serlib_auth_handler' },
            url:    front_obj.ajax_url
        }).then(function successCallback(response) {
           
           $scope.cities_active = response.data.cities_active;
           $scope.states = response.data.states;
            
        }, function errorCallback(response) {
            console.log('fallo cargando states', response);            
        });

        $scope.cityFilter = function(newValue){
            $scope.Model.city_id = null;
            $scope.cities = newValue.cities; 
        }
        
        $scope.submitFiles = function(id){
            
            var prom = 0;         

            if(hasValue($scope.photo) ) prom++;
            if(hasValue($scope.File) ) prom++;

            if(prom === 0) {
                $scope.finish();
                return;
            }
            
            $scope.afterSubmit = function(){
                prom--;
                if(prom === 0){
                    $scope.finish();
                }
            }

            if(hasValue($scope.photo) ){
                                
                var formData = new FormData();
                formData.append('files', $scope.photo);
            
                angular.element.ajax({
                    type: 'POST',
                    url: front_obj.ajax_url+'?action=serlib_uploader&destino=photo_profile&id='+id,
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(response){
                        if(response.success){
                            
                        }else if(response.data.error){
                            $scope.error =  response.error; 
                        }
                        $scope.afterSubmit();
                    },
                    error: function(error){
                        $scope.error =  error; 
                        $scope.afterSubmit();
                    }
                });

            }

            if(hasValue($scope.File) ){

                var formData = new FormData();
                formData.append('files', $scope.File);

                angular.element.ajax({
                    type: 'POST',
                    url: front_obj.ajax_url+'?action=serlib_uploader&destino=file_document&id='+id,
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(response){
                        if(response.success){
                            
                        }else if(response.error){
                            $scope.error =  response.error; 
                            
                        }
                        $scope.afterSubmit();
                    },
                    error: function(error){
                        $scope.error =  error; 
                        $scope.afterSubmit();
                    }
                });
            }
            
        }

        $scope.finish = function(){
           
            $scope.user_created = true;

            if($scope.Model.modo === 'directo'){  
                setTimeout(() => { window.location = "/gracias?pending="+$scope.Model.rol; }, 2000);
            }else{
                setTimeout(() => { window.location = "/gracias"; }, 2000);
            }       
        }

        $scope.submit = function(){
            
            if($scope.is_submit) return;
            
            /**Validamos si no se hizo cambios para guardar la url de la red social */
            if($scope.Instance.picture === $scope.profile_photo){
                $scope.Model.photo_url = $scope.profile_photo;
            }
           
            $scope.is_submit = true;
            $scope.error  = false;

            $http( {
                method: 'POST',
                params: { action: 'serlib_auth_handler', 'create': ''},
                url:    front_obj.ajax_url,
                data:   angular.copy($scope.Model),
            }).then(function successCallback(response) {
                
                if(response.data.success){
                    $scope.submitFiles(response.data.success);
                  
                }else if(response.data.error){
                    $scope.error = response.data.error;
                    $scope.is_submit = false;
                }
            }, function errorCallback(error) {
                $scope.is_submit = false;
                $scope.error =  error.data;            
            });

           
        }
    

}])
.directive('appFilereader', function($q) {
    var slice = Array.prototype.slice;

    return {
        restrict: 'A',
        require: '?ngModel',
        scope: { preview: '@' },
        link: function(scope, element, attrs, ngModel) {
           
            if (!ngModel && attrs.type !== 'file') return;

            ngModel.$render = function() {};
            element.bind('change', function(e) {
                
                var element = e.target;
                var files = element.files[0]
                ngModel.$setViewValue(files);
                
                if(attrs.preview){
                   
                    var urlObject = URL.createObjectURL(files);
                                      
                    scope.$parent[attrs.preview] = urlObject;
                    
                    scope.$apply() 
            
                }
                
            }); 


        } 
    }; 
});


/**Registro con facebook - google - instagram */
app.controller('authSocialController', ['$scope', '$rootScope', '$http', 'Config', 
                 function authSocialController($scope, $rootScope, $http,  Config) {
    
    /**Escucha la directiva de google */
    $rootScope.$on('event:social-sign-in-success', function(event, userDetails){
        $scope.AuthSocial('google', userDetails);
        
    });

    $scope.AuthSocial = function(red, profile = null){
        
        $scope.is_submit = true;

        $scope.redirect_register_social = function(datos){
            switch ( datos.modo ){
                case 'facebook':                
                case 'google':
                case 'instagram':

                    sessionStorage.setItem('auth', JSON.stringify(datos) );
                    window.location = '/auth/register';
                    break;
                    
            }
        }

        $scope.ValidateUser = function(datos){
            
            $http( {
                method: 'POST',
                params: { action: 'serlib_auth_handler', 'login': ''},
                url:    front_obj.ajax_url,
                data:   datos,
            }).then(function successCallback(response) {
                 
                if(response.data.success){
                    $scope.user_login = true;
                    setTimeout(() => { window.location = "/blog"; }, 1000);
                   
                }else if(response.data.error){
                    if( Config.action === 'login'){
                        $scope.error = response.data.error;
                        $scope.redirect_register_social(datos);
                   
                    }else if(Config.action === 'register'){
                       $scope.Instance = datos;
                       $scope.UpdateInstance();
                    }
                    
                    $scope.is_submit = false;
                }

            }, function errorCallback(error) {
                $scope.is_submit = false;
                $scope.error =  error.data;            
            });
            

        }

        switch (red) {

            case 'google':
                  
                $scope.ValidateUser( 
                    {  _wpnonce: angular.element('#_wpnonce').val(),
                      modo: 'google', first_name: profile.firstName,
                      last_name: profile.lastName,
                      email: profile.email, picture: profile.imageUrl
                    }
                );

                break;
            
            case 'facebook':
                
                FB.login(function(response){
                    validarUsuario();
                }, {scope: 'public_profile, email'})

                function validarUsuario(){
                    FB.getLoginStatus(function(response){
                        statusChangeCallback(response);
                    })
                }

                function statusChangeCallback(response){
                    if(response.status === 'connected'){
                        testApi();
                    }else{
                        $scope.error = 'hubo un error con facebook por favor intente nuevamente';
                    }
                }

                function testApi(){
                    FB.api('/me?fields=id,first_name,last_name,email,picture,birthday',function(response){
                        if(response.email !== null){
                            var picture = "http://graph.facebook.com/"+response.id+"/picture?type=large";    
                                                        
                            $scope.ValidateUser( 
                                {  _wpnonce: angular.element('#_wpnonce').val(),
                                 modo: 'facebook', first_name: response.first_name,
                                 last_name: response.last_name,
                                  email: response.email, picture: picture
                                }
                            );
                        }
                    });
                }

                break;
            case 'instagram':

                $scope.ValidateUser( 
                    {  _wpnonce: angular.element('#_wpnonce').val(),
                      modo: 'instagram', email: '', password:'', username: profile.username,
                      id: profile.id
                    }
                );

                break;
                
    }

   

    }
    
    $scope.InstagramRedirect = function(){

        if( Config.action === 'register'){
            sessionStorage.setItem('auth_instagram', JSON.stringify( angular.copy( $scope.Model ) ) );
        }

        var CLIENT_ID = "1117533245288400";
        var REDIRECT_URI = "https://golfodemorrosquillo.com/auth"; 
        var url = "https://api.instagram.com/oauth/authorize/?client_id="+ CLIENT_ID + "&redirect_uri="+REDIRECT_URI+"&response_type=code&scope=user_profile";
        window.location = url;
            
    }    

    /** La Instancia es solo para instagram */
    if( Config.action === 'login'){
       if(Inst && hasValue(Inst)){
        $scope.AuthSocial('instagram', Inst );
       }
    }       
}]);

