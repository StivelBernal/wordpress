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


var app = angular.module('serAuth', ['SER.selector', 'ngMaterial', 'ngMessages', 'SER.match'])
    .config(function ($mdThemingProvider) {
        $mdThemingProvider.theme('default')
            .primaryPalette('light-green');
    })
    .config(['$compileProvider', function ($compileProvider) {
        $compileProvider.debugInfoEnabled(false);
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
                    $scope.Model = { remembermme: false, _wpnonce: angular.element('#_wpnonce').val() }

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


app.controller('registerController', ['$scope', '$http', '$controller',  
                ,function registerController($scope, $http, $controller ) {
        
        $controller('authSocialController', {
            $scope: $scope,
            Config: {
                action: 'register',
            }
        });
        /**Options */
        $scope.error  = false;
        $scope.user_created = false;
        $scope.is_submit = false;
        $scope.states = [];
        $scope.modo = 'directo';
        $scope.cities = [];
        $scope.Model = { modo: 'directo', token: '', _wpnonce: angular.element('#_wpnonce').val() };
        $scope.photo = [], $scope.files = [];
        $scope.profile_photo = 'https://golfodemorrosquillo.com/wp-content/uploads/2020/05/240_F_64676383_LdbmhiNM6Ypzb3FM4PPuFP9rHe7ri8Ju.jpg';
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

        
        if ( $scope.Model.rol === 'turista' && !$scope.registerForm.$valid ) return; 
        if ( $scope.Model.rol === 'comerciante' && $scope.c_Form.$valid ) return;
        
        $scope.submitFiles = function(id){
            
            var prom = 0
            
            if(hasValue($scope.photo) ) prom++;
            if(hasValue($scope.File) ) prom++;

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
              setTimeout(() => { window.location = "/gracias"; }, 2000);
        }

        $scope.submit = function(){
           if($scope.is_submit) return;
            $scope.is_submit = true;
            $scope.error  = false;

            $http( {
                method: 'POST',
                params: { action: 'serlib_auth_handler', 'create': ''},
                url:    front_obj.ajax_url,
                data:   $scope.Model,
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
app.controller('authSocialController', ['$scope', '$http', 'Config', function authSocialController($scope, $http,  Config) {
                         console.log('se cargo socials', Config);   
    $scope.AuthSocial = function(red){
                       

       // localStorage.setItem('social', 'objecto con los datos en caso de que no este registrado lo pedimos cuando cargue el registro')
        switch (red) {

            case 'google':
                

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
                        /** MOSTRAR ERROR DE QUE NO ESTA REGISTRADO  
                         * 
                         * Window.location = register;
                        */
                        alert('error');
                
                    }
                
                }

                function testApi(){

                    FB.api('/me?fields=id,name,email,picture',function(response){
                
                        if(response.email == null){

                        }else{

                            var email = response.email;
                            var nombre = response.name;
                            var foto = "http://graph.facebook.com/"+response.id+"/picture?type=large";
                            console.log(response);
                            
                        }

                    });
                }

                break;
            case 'Instagram':
        
                
                break;
        }
    }
                 
}]);