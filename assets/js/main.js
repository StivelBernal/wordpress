(function($){ 
    
   
    $("#destino_rating").bind( 'rated', function(){
        
        $(this).rateit( 'readonly', true );

        var form        =   {
            action:         'serlib_rate_destino',
            rid:            $(this).data( 'rid' ),
            rating:         $(this).rateit( 'value' )
        };

        $.post( front_obj.ajax_url, form, function(data){
            console.log('datos', data);
        });
    });
    /**Carruseles */
  $(document).ready(function () {
    //initialize swiper when document ready
    var mySwiper = new Swiper ('.swiper-container', {
        speed: 400,
        spaceBetween: 0,
        loop: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: false
        },
        speed: 500,
        breakpoints: {
            200: {
              slidesPerView: 1
            },
            700: {
              slidesPerView: 2
            },
            1000: {
              slidesPerView: 3
            }
        }
    })
  });
  if(document.querySelector('#search-results')){
    var offset = $('#search-results').offset().top;
  }
  const media_url = '';
  const months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

  function item_blog(publicacion, municipio){
    var date = new Date(publicacion.post_date);
  
    return '<div class="swiper-slide mkdf-team mkdf-item-space info-hover">'
        +'<div class="mkdf-team-inner">'
            +'<div class="mkdf-team-image">'
                +'<img style="width:100%;" src="'+publicacion.thumbnail+'" class="attachment-post-thumbnail size-post-thumbnail wp-post-image" >'
                +'<div class="mkdf-team-info-tb">'
                    +'<div class="mkdf-team-info-tc">'
                        +'<div class="mkdf-team-title-holder">'
                            +'<h4 itemprop="name" class="mkdf-team-name entry-title">'
                                +'<a itemprop="url" href="'+municipio+publicacion.post_name+'">'+publicacion.post_title+'</a>'
                            +'</h4>'
                            +'<h6>'+months[date.getMonth()]+' '+date.getDay()+', '+date.getFullYear()+'</h6>'
                        +'</div>'
                    +'</div>'
                +'</div>'
            +'</div>'
        +'</div>'
    +'</div>'
  }
  
  function item_blog2(publicacion){
      var date = new Date(publicacion.post_date);
    
      return '<div class="swiper-slide mkdf-bli-inner">'
      +'<div class="mkdf-post-image">'
          +'<a itemprop="url" href="'+publicacion.post_title+'" title="My Experience">'
              +'<img width="1300" height="719" src="'+publicacion.thumbnail+'" class="attachment-full size-full wp-post-image" alt="m" > </a>'
      +'</div>'
      +'<div class="mkdf-bli-content">'
         +'<div class="mkdf-bli-info">'
              +'<div itemprop="dateCreated" class="mkdf-post-info-date entry-date published updated">'
                  +'<a >'
                      +'<div class="mkdf-post-date-wrap">'+months[date.getMonth()]+' '+date.getDay()+', '+date.getFullYear()+' </div>'
                  +'</a>'
              +'</div>'
          +'<h4 itemprop="name" class="entry-title mkdf-post-title">'
              +'<a itemprop="url" href="'+publicacion.post_title+'" title="'+publicacion.post_title+'">'
                  +publicacion.post_title+' </a>'
          +'</h4>'
          +'<div class="mkdf-bli-excerpt">'
              +'<div class="mkdf-post-read-more-button">'
                 +'<a itemprop="url" href="'+publicacion.post_title+'" target="_self" class="mkdf-btn mkdf-btn-medium mkdf-btn-simple mkdf-blog-list-button"> <span class="mkdf-btn-text">VER MÁS</span> </a> </div>'
          +'</div>'
      +'</div>'
  +'</div>';
  }


  $('.button-destino').click(function(e){

    e.preventDefault();   
    
    /**Aqui toca pegarle a wordpress y traer las entradas correspondiente a estos users Ids*/
    $('#results-home-extracto').html($(this).attr('excerpt'));
    $('#results-home-departamento').html($(this).attr('departamento'));
    $('#results-home-municipio').html($(this).attr('municipio'));

    $('#search-results .row-wrap').css('display', 'flex');
    var municipio = $(this).attr('url')+'/';

    var form        =   {
        action:         'serlib_entries',
        alcaldia:       $(this).attr('alcaldia'),
        gobernacion:    $(this).attr('gobernacion')
    };
   
    /**Llamar a las entradas de las alcaldias a mostrar */
    $.post( front_obj.ajax_url, form, function(data){
        $('#entradas_gobernacion_fila').show();
        $('#entradas_alcaldia_fila').show();
        
        var slides_alcaldia =  [], slides_gobernacion =  [];
        for(var i = 1; i < data.alcaldia.length; i++){ 
             
            slides_alcaldia.push( item_blog(data.alcaldia[i], municipio) );
        }

        if(data.alcaldia[0]){
            var date = new Date(data.alcaldia[0].post_date);
            $('#post_reciente_alcaldia img').attr('src', data.alcaldia[0].thumbnail);
            $('#post_reciente_alcaldia h3').text(data.alcaldia[0].post_title);
            $('#post_reciente_alcaldia .mkdf-post-date-day').text(date.getDay());
            $('#post_reciente_alcaldia .mkdf-post-date-month').text(months[date.getMonth()]);
            $('#post_reciente_alcaldia .mkdf-post-excerpt').text(data.alcaldia[0].post_excerpt );
        }

        for(var i = 0; i < data.gobernacion.length; i++){ 
            slides_gobernacion.push( item_blog2(data.gobernacion[i]) );
        }

        var swiper1 = new Swiper('.swiper-container-gobernacion', {            
            spaceBetween: 10,
            loop: true,
            autoplay: {
                delay: 2000,
                disableOnInteraction: true
            },
            speed: 1500,
            breakpoints: {
                200: {
                slidesPerView: 1
                },
                700: {
                slidesPerView: 2
                },
                1000: {
                slidesPerView: 3
                }
            }
        });
        swiper1.removeAllSlides();
        swiper1.appendSlide(slides_gobernacion);

        
        var swiper2 = new Swiper('.swiper-container-alcaldia', {            
            spaceBetween: 10,
            loop: true,
            autoplay: {
                delay: 2000,
                disableOnInteraction: true
            },
            speed: 1500,
            breakpoints: {
                200: {
                slidesPerView: 1
                },
                700: {
                slidesPerView: 2
                },
                1000: {
                slidesPerView: 3
                }
            }
        });
        swiper2.removeAllSlides();
        swiper2.appendSlide(slides_alcaldia);

        
        
        
        /**Aqui se invocaria el carrusel y se colocaria la primera entrada de la alcaldia*/


     });
    
    $('.item-servicio-home').each( (i, element) =>  $(element).attr('href', municipio+$(element).attr('base') ));
    
    

    $('body').animate({ scrollTop: offset}, 1500);
    
    
    
  });

  

})(jQuery);



var search_app = angular.module('search', ['SER.selector', 'ngMaterial', 'ngMessages',])
    .config(['$compileProvider', function ($compileProvider) {
        $compileProvider.debugInfoEnabled(false);
    }])
   


search_app.controller('formController', ['$scope', '$http', 
    function formController($scope, $http) {
    
 
    $scope.options_ciudades = [ 'Lorica', 'San Onofre', 'Tolú Viejo', 'Santiago de Tolú', 'Cobeñas', 'Moñitos', 'San Bernardo del viento', 'San Antero' ]
  
    $scope.submit = function(){
        
        if($scope.is_submit) return;
        $scope.is_submit = true;
        window.location = $scope.Model.ciudad+'?busqueda='+$scope.Model.busqueda;
        //$("html,body").animate({ scrollTop: $('#search-results').offset().top+200}, 1500);
       
    }

}]);


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
                        setTimeout(() => { window.location = "/blog"; }, 2500);
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
        
        $scope.UpdateInstance = function(load = false){
            if(load) $scope.Model = {};
            if( !hasValue($scope.Instance ) ){
                $scope.Model = { modo: 'directo', _wpnonce: angular.element('#_wpnonce').val() };
            }else{
                
                $scope.profile_photo = hasValue($scope.Instance.picture) ? $scope.Instance.picture: $scope.profile_photo;
                
                if($scope.Instance.modo === 'instagram'){
               
                    var instagramForm = JSON.parse(sessionStorage.getItem('auth_instagram'));       
                    $scope.Model = angular.merge(instagramForm, { modo: $scope.Instance.modo, nombre: $scope.Instance.username, photo_url: '', _wpnonce: angular.element('#_wpnonce').val() });
            
                }else{      
                    var Form = angular.copy($scope.Model);
                    $scope.Model = angular.merge( Form, { modo: $scope.Instance.modo, nombre: $scope.Instance.first_name, apellido: $scope.Instance.last_name, email: $scope.Instance.email, photo_url: '', _wpnonce: angular.element('#_wpnonce').val() } );
                    
                }

            }
            
        }

        $scope.UpdateInstance(true);

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

            sessionStorage.removeItem('auth');

            if($scope.Model.modo === 'directo' || $scope.Model.rol === 'comerciante'){  
                setTimeout(() => { window.location = "/gracias?pending="+$scope.Model.rol; }, 2000);
            }else{
                setTimeout(() => { window.location = "/gracias"; }, 2000);
            }       
        }

        $scope.submit = function(){
            
            if($scope.is_submit) return;
            
            /**Validamos si no se hizo cambios para guardar la url de la red social */
            if(hasValue($scope.Instance)){
                if($scope.Instance.picture === $scope.profile_photo) $scope.Model.photo_url = $scope.profile_photo;
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



var admin_frontend = angular.module('admin_frontend', ['SER.selector', 'ngMaterial', 'ngMessages','ui.router'])
    .config(['$compileProvider', function ($compileProvider) {
        $compileProvider.debugInfoEnabled(false);
    }])
    .config(['$stateProvider', function ($stateProvider) {

        $stateProvider.state('publicaciones', {
            abstract: true,
            url: "/publicaciones",
            template: '<ui-view/>'
        })
        .state('publicaciones.all', {
            url: "/all",
            templateUrl: '../wp-content/plugins/ser_lib/assets/html/frontend/all-post.php',
            controller: 'BaseCrud',
            resolve: {
                Posts: ['Posts', function (Model) {
                    return  Model;
                }] 
            }
        })
        .state('publicaciones.form', {
            url: "/form",
            templateUrl: '../wp-content/plugins/ser_lib/assets/html/frontend/form.php',
            controller: 'BaseCrud'
        })
        .state('profile', {
            url: "/profile",
            templateUrl: '../wp-content/plugins/ser_lib/assets/html/frontend/form.php',
            controller: 'BaseCrud'
        });

    }]);


admin_frontend.controller('AppCtrl', ['$scope', '$timeout', 
    function AppCtrl($scope, $timeout) {
        
      

}]);

admin_frontend.controller('BaseCrud', ['$scope', '$timeout', 
    function BaseCrud($scope, $timeout) {
        
      

}]);

admin_frontend.factory('Posts', ['$http', function ($http) {

    var posts = [];
   
    $http({
        method: 'GET',
        params: { action: 'serlib_users_info', 'post_type': 'post'},
        url:    front_obj.ajax_url,
    }).then(function successCallback(response) {
        posts = response.data;
        
    }, function errorCallback(response) {
        console.log('fallo cargando states', response);            
    });

    return 'algo';

}]);
