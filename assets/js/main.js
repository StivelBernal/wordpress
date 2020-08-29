var offset_textarea = $("#comment").offset();

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

   
   

    

   // $('.reveal-category-item excerpt-category-item a').click(function(e){ e.preventDefault()})


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
    });

    
    var mySwiper = new Swiper ('.swiper-container-comercio', {
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
    });

  
  });
  if(document.querySelector('#search-results')){
    var offset = $('#search-results').offset();
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
                                +'<a itemprop="url" href="'+publicacion.permalink+'">'+publicacion.post_title+'</a>'
                            +'</h4>'
                            +'<div class="detalles-post-slider">'
                                +'<span class="author"> <i class="fa fa-user" aria-hidden="true"></i>'+publicacion.author+' </span>'
                                +'<span class="fecha"> <i class="fa fa-calendar-check-o" aria-hidden="true"></i> '+months[date.getMonth()]+' '+date.getDate()+', '+date.getFullYear()+'</span>'
                            +'</div>'
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
          +'<a itemprop="url" href="'+publicacion.permalink+'" title="'+publicacion.post_title+'">'
              +'<img width="1300" height="719" src="'+publicacion.thumbnail+'" class="attachment-full size-full wp-post-image" alt="m" > </a>'
      +'</div>'
      +'<div class="mkdf-bli-content">'
         +'<div class="mkdf-bli-info">'
              +'<div itemprop="dateCreated" class="mkdf-post-info-date entry-date published updated">'
                  +'<a >'
                      +'<div class="mkdf-post-date-wrap">'+months[date.getMonth()]+' '+date.getDate()+', '+date.getFullYear()+' </div>'
                  +'</a>'
              +'</div>'
          +'<h4 itemprop="name" class="entry-title mkdf-post-title">'
              +'<a itemprop="url" href="'+publicacion.permalink+'" title="'+publicacion.post_title+'">'
                  +publicacion.post_title+' </a>'
          +'</h4>'
          +'<div class="mkdf-bli-excerpt">'
              +'<div class="mkdf-post-read-more-button">'
                 +'<a itemprop="url" href="'+publicacion.permalink+'" target="_self" class="mkdf-btn mkdf-btn-medium mkdf-btn-simple mkdf-blog-list-button"> <span class="mkdf-btn-text">VER MÁS</span> </a> </div>'
          +'</div>'
      +'</div>'
  +'</div>';
  }

  
  
    $('#year_copy').html(new Date().getFullYear());


  $('.button-destinof').click(function(e){

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
            $('#post_reciente_alcaldia a').attr('href', data.alcaldia[0].permalink);
            $('#post_reciente_alcaldia h3').text(data.alcaldia[0].post_title);
            $('#post_reciente_alcaldia .mkdf-post-date-day').text(date.getDate());
            $('#post_reciente_alcaldia .mkdf-post-date-month').text(months[date.getMonth()]);
            $('#post_reciente_alcaldia .mkdf-post-excerpt').text(data.alcaldia[0].post_excerpt );
        }else{
            $('#post_reciente_alcaldia').hide();
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
    
    
    
    

    $('body').animate({ scrollTop: offset+500}, 1500);
    
    
    
  });


  function primer_destino() {
    
    var destino = $('#default_desdtino');

    $('#search-results .row-wrap').css('display', 'flex');
    var municipio = destino.attr('url')+'/';

    var form        =   {
        action:         'serlib_entries',
        alcaldia:       'ALL',
        gobernacion:    'ALL'
    };
   
    /**Llamar a las entradas de las alcaldias a mostrar */
    $.post( front_obj.ajax_url, form, function(data){
        
        var slides_alcaldia =  [], slides_gobernacion =  [];        

        if(data.alcaldia[0]){
            $('#entradas_alcaldia_fila').show();
            var date = new Date(data.alcaldia[0].post_date);
            $('#post_reciente_alcaldia img').attr('src', data.alcaldia[0].thumbnail);
            $('#post_reciente_alcaldia a').attr('href', data.alcaldia[0].permalink);
            $('#post_reciente_alcaldia h3').text(data.alcaldia[0].post_title);
            $('#post_reciente_alcaldia .mkdf-post-date-day').text(date.getDate());
            $('#post_reciente_alcaldia .mkdf-post-date-month').text(months[date.getMonth()]);
            $('#post_reciente_alcaldia .mkdf-post-excerpt').text(data.alcaldia[0].post_excerpt );
            
            for(var i = 1; i < data.alcaldia.length; i++){ 
             
                slides_alcaldia.push( item_blog(data.alcaldia[i], municipio) );
            }
        }else{
            
            $('#post_reciente_alcaldia').hide();
            $('#entradas_alcaldia').remove();
        }

       

        if(data.gobernacion[0]){
            
            $('#entradas_gobernacion_fila').show();
            var date = new Date(data.gobernacion[0].post_date);
            $('#post_reciente_gobernacion img').attr('src', data.gobernacion[0].thumbnail);
            $('#post_reciente_gobernacion a').attr('href', data.gobernacion[0].permalink);
            $('#post_reciente_gobernacion h3').text(data.gobernacion[0].post_title);
            $('#post_reciente_gobernacion .mkdf-post-date-day').text(date.getDate());
            $('#post_reciente_gobernacion .mkdf-post-date-month').text(months[date.getMonth()]);
            $('#post_reciente_gobernacion .mkdf-post-excerpt').text(data.gobernacion[0].post_excerpt );

            for(var i = 1; i < data.gobernacion.length; i++){ 
                slides_gobernacion.push( item_blog(data.gobernacion[i]) );
            }

        }else{
            $('#post_reciente_gobernacion').hide();
            $('#entradas_gobernacion').remove();

        }

        //console.log(slides_gobernacion);
        if(slides_gobernacion.length !== 0){

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
            swiper1.appendSlide(slides_gobernacion);

        }

        if(slides_alcaldia.length !== 0){
        
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

        }    

     });
    

    $('.item-servicio-home').each( (i, element) =>  $(element).attr('href', municipio+$(element).attr('base') ));
           
  }
 

  if (typeof(carrusel_instancia) !== 'undefined' ){
    primer_destino();
  }
  else{
     
    if (typeof(id_alcaldia) !== 'undefined' ){
        var id_alcaldia = 0;
    }

    if (typeof(id_gobernacion) !== 'undefined') {
        var id_gobernacion = 0;
    }

    $('#search-results .row-wrap').css('display', 'flex');

    var form        =   {
        action:         'serlib_entries',
        alcaldia:       id_alcaldia,
        gobernacion:    id_gobernacion,
        municipio:       $(this).attr('municipio'),
    };

    /**Llamar a las entradas de las alcaldias a mostrar */
    $.post( front_obj.ajax_url, form, function(data){
        
        if(data.error) return;

        var slides_alcaldia =  [], slides_gobernacion =  [];
        for(var i = 0; i < data.alcaldia.length; i++){ 
            
            slides_alcaldia.push( item_blog(data.alcaldia[i], municipio) );
        }
      

        for(var i = 0; i < data.gobernacion.length; i++){ 
            slides_gobernacion.push( item_blog(data.gobernacion[i]) );
        }

        if(slides_gobernacion.length !== 0){
       
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
           
            swiper1.appendSlide(slides_gobernacion);

        }

        if(slides_alcaldia.length !== 0){

        
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

            swiper2.appendSlide(slides_alcaldia);

        }
        
    
        



    });  

  }

  if(typeof(aliado_carrusel) !== 'undefined'){
       
    var swiper3 = new Swiper(".swiper-container-aliado", {            
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
  }
  
  


  $('.fovea-category-2').mouseover(function(){
     
    $(this).addClass('reveal');
  });

  $('.fovea-category-2').mouseout(function(){
    $(this).removeClass('reveal');
  });

  $('.stars_r_c img').click(function(){

    $('#img-comment-preview img').attr('src', $(this).attr('src'));
    $('#img-comment-preview ').fadeIn();

  });

  $('#img-comment-preview  .cerrar').click(function(){

    $('#img-comment-preview img').attr('src', '');
    $('#img-comment-preview').fadeOut();

  });

  $('.ser-shared-sn').click(function(){
    var url = '';
    switch ($(this).attr('red')) {
        case 'facebook':
            url = 'http://www.facebook.com/sharer.php?u=https://golfodemorrosquillo.com';
          break;
        case 'email':
            url = 'mailto:?subject=Visita%20este%20sitio%20en%20el%20golfo%20de%20morrosquillo&body==Echa%20un%20vistazo%20a%20este%20sitio%20en%20golfo%20de%20morrosquillo%20'+window.location;
        break;
    
        case 'whatsapp':
            url = 'https://api.whatsapp.com/send?text=Visita%20este%sitio%20en%Golfo%20de%20morrosquillo%20en%20'+window.location;
          break;
      
      }

      if(url !== ''){
          window.open(url,'sharer','toolbar=0,status=0,width=648,height=395,top=100,left=100');
      }

  });

   

  $('.history-back').click(function(){
    history.back();
  });

  $('.me_gusta_post').click(function(){
    
    $(this).addClass('load');
    var contador = $(this).children('.number');
   
    var form        =   {
        action:         'serlib_like_destino',
        ID: $(this).attr('id_post')
    };

    $.ajax({
        type: "POST",
        url: front_obj.ajax_url,
        data: form,
        success: function(data){
            
            contador.html(data);
            
        },
        error: function(error){
            if(error.status === 400)  alert('logueate para poder comentar esta publicación');
        }
      });

  });
  

})(jQuery);



var search_app = angular.module('search', ['SER.selector', 'ngMaterial', 'ngMessages',])
    .config(['$compileProvider', function ($compileProvider) {
        $compileProvider.debugInfoEnabled(false);
    }])
   


search_app.controller('formController', ['$scope', '$http', 
    function formController($scope, $http) {
    
    $scope.options_ciudades = [];
    $scope.options_tipos = [];
    $scope.options_tags = [];


    $http({
        method: 'GET',
        params: { action: 'serlib_references', municipios: '', tipos: '', tags: '' },
        url:    front_obj.ajax_url
    }).then(function successCallback(response) {
        $scope.options_ciudades = response.data.municipios;
        $scope.options_tipos = response.data.tipos;
        $scope.options_tags = response.data.tags;
        
    }, function errorCallback(response) {
        console.log('fallo cargando referencias', response);            
    });


   
  
    $scope.submit = function(){
        
        if($scope.is_submit) return;
        $scope.is_submit = true;

        var slug = angular.element('#slug-search').attr('slug');
        
        if($scope.Model.ciudad){
            window.location = slug+$scope.Model.ciudad+'?busqueda='+$scope.Model.busqueda;
        }else if($scope.Model.tipo){
            window.location = slug+$scope.Model.tipo+'?busqueda='+$scope.Model.busqueda;
        }else if($scope.Model.tags){
            window.location = slug+'?busqueda='+$scope.Model.busqueda+'&tags='+$scope.Model.tags;
        }
       
    }

}]);


var comercio_page_app = angular.module('comercio_page', ['ngMaterial'])
    .config(function ($mdThemingProvider) {
        $mdThemingProvider.theme('default')
            .primaryPalette('light-green');
    })
   .controller('pageController', ['$scope', 
    function pageController($scope) {
    
     $scope.tab = 1;
    

}]).controller('commentsController', ['$scope',  '$http',
function commentsController($scope, $http) {
/**Aqui Guardaria el label y i para guardarlo */
/**Asignarle una calificación  tiene varias acciones hover y click para asignar el valor */
/**Colocar unos input para subir imagenes y validacion para enviar */

$scope.item_star = [];
$scope.item_selected = [];
$scope.reply_name = '';
$scope.comment_text = '';
$scope.reply_id = false;
$scope.galery = [];
$scope.preview_galery = [];
$scope.cal_total = cal_total;
$scope.is_submit = false;
$scope.preview_default = '/wp-content/plugins/ser_lib/assets/img/images.png'
$scope.error = '', $scope.success = '';
$scope.add_galery = function(){
    if($scope.galery.length  < 7){
        $scope.galery.push({text: ''});
    }
          
}



$scope.delete_image = function(index){
    
      $scope.galery.splice(index, 1);
      $scope.preview_galery.splice(index, 1);
}

$scope.set_star = function (value, j, label){
   
    $scope.item_selected[j] = [value, label]
   
}

/**Subida de archivos */
$scope.submitFiles = function(success_text, id_comment){
        
    var promises = 0;
   
    var files =  angular.copy($scope.galery).length;

    for(var i = 0; i < files; i++ ){
       
        if($scope.galery[i].name) {
           
            promises++;
            
            var formData = new FormData();
            formData.append('files', $scope.galery[i]);
            
            angular.element.ajax({
                type: 'POST',
                url: front_obj.ajax_url+'?action=serlib_uploader&destino=comments_media&id_comment='+id_comment,
                data: formData,
                contentType: false,
                cache: false,
                processData:false,
                success: function(response){

                    finally_promises();
                
                },
                error: function(error){
                    $scope.error =  error; 
                
                    finally_promises();
                }
            });
        }
    }

    if(promises === 0){
        $scope.success = success_text;
        setTimeout(() => { location.reload() }, 2000);
    }

    function finally_promises(){
        promises--;
         if(promises === 0){
             
            $scope.success = success_text;
            $scope.$apply();
            $scope.is_submit = false;
            setTimeout(() => { location.reload() }, 2000);
         }
    }
    
}



$scope.submit = function(){
        
        $scope.error = '', $scope.success = '';
        
        if($scope.is_submit === true){
            return;
        }

        $scope.is_submit = true;
        
        var sel_stars = angular.copy( $scope.item_selected ),
        stars_end = [];
        
        for(var i = 0; i < sel_stars.length; i++){
           
            if( sel_stars[i] ) {
                stars_end.push( { value: sel_stars[i][0], label: sel_stars[i][1]} ); 
            }
            
        }
        var data = {};
        data.text = $scope.comment_text;
        data.stars = stars_end;
        data.post_id = post_id;

        if($scope.reply_id){
            data.parent = $scope.reply_id;
        }

        $http({
            method: 'POST',
            params: { action: 'serlib_comments' },
            url:    front_obj.ajax_url,
            data: data
        }).then(function successCallback(response) {
            
            if(response.data.success){
            
                $scope.submitFiles(response.data.success, response.data.comment_ID);
             
                
            }else if( response.data.error ){
                $scope.error = response.data.error;
                $scope.is_submit = false;
            }else if(response.data == 0){
                response.data.error = 'Tú sessión a expiró';
            }
            
            

        }, function errorCallback(error) {
            
            $scope.is_submit = false;
            if(error.data == 0){
                $scope.error =  'Tú sessión a expiró';            
            }else{
                $scope.error = error.data;
            }
            
        });

};

$scope.reply = function(id_comment, name, $event){
    //console.log(offset_textarea.top,$($event.toElement).offset().top);
    //var offsetF = offset_textarea.top-$($event.toElement).offset().top-900;
    //console.log(offsetF);
    $scope.reply_id = id_comment;
    $scope.reply_name = name;
}

$scope.cancel_reply = function(){
    $scope.reply_id = false;
    $scope.reply_name = '';
}

$scope.delete_comment = function(id, $event, child = false){
   
    $http({
        method: 'DELETE',
        params: { action: 'serlib_comments', id_comment: id },
        url:    front_obj.ajax_url
    }).then(function successCallback(response) {
        
        if(response.data.success){
        
            angular.element($event.toElement).parent().parent().parent().fadeOut();
         
            
        }
        
        

    }, function errorCallback(error) {
        
        $scope.is_submit = false;
        $scope.error =  error.data;            
    });
}

}]).directive('appFilereader', function($q) {
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
            if(files.size > (1024*10)*1000){
                alert('el tamaño maximo permitido es 10MB')
                return;
            }
            ngModel.$setViewValue(files);
            var urlObject = URL.createObjectURL(files);
            
            if(attrs.preview){
                                                   
                scope.$parent[attrs.preview] = urlObject;
                
                scope.$apply() 
        
            }
            
            if(attrs.previewArray && attrs.indice){
                
                scope.$parent[attrs.previewArray][attrs.indice] = urlObject;
                scope.$apply() 
            }

        }); 


    } 
}; 
});


var comments_app = angular.module('comments', ['ngMaterial'])
    .config(function ($mdThemingProvider) {
        $mdThemingProvider.theme('default')
            .primaryPalette('light-green');
    })
   .controller('commentsController', ['$scope',  '$http',
    function commentsController($scope, $http) {
    /**Aqui Guardaria el label y i para guardarlo */
    /**Asignarle una calificación  tiene varias acciones hover y click para asignar el valor */
    /**Colocar unos input para subir imagenes y validacion para enviar */
    //var offset_textarea = $("#respond").offset();
    $scope.item_star = [];
    $scope.item_selected = [];
    $scope.comment_text = '';
    $scope.cal_total = cal_total;
    $scope.reply_id = false;
    $scope.reply_name = '';
    $scope.galery = [];
    $scope.preview_galery = [];
    $scope.is_submit = false;
    $scope.preview_default = '/wp-content/plugins/ser_lib/assets/img/images.png'
    $scope.error = '', $scope.success = '';
    $scope.add_galery = function(){
        if($scope.galery.length  < 7){
            $scope.galery.push({text: ''});
        }
              
    }

    $scope.delete_image = function(index){
        
          $scope.galery.splice(index, 1);
          $scope.preview_galery.splice(index, 1);
    }

    $scope.set_star = function (value, j, label){
       
        $scope.item_selected[j] = [value, label]
       
    }

    /**Subida de archivos */
    $scope.submitFiles = function(success_text, id_comment){
            
        var promises = 0;
       
        var files =  angular.copy($scope.galery).length;

        for(var i = 0; i < files; i++ ){
           
            if($scope.galery[i].name) {
               
                promises++;
                
                var formData = new FormData();
                formData.append('files', $scope.galery[i]);
                
                angular.element.ajax({
                    type: 'POST',
                    url: front_obj.ajax_url+'?action=serlib_uploader&destino=comments_media&id_comment='+id_comment,
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(response){

                        finally_promises();
                    
                    },
                    error: function(error){
                        $scope.error =  error; 
                    
                        finally_promises();
                    }
                });
            }
        }

        if(promises === 0){
            $scope.success = success_text;
            setTimeout(() => { location.reload() }, 2000);
        }

        function finally_promises(){
            promises--;
             if(promises === 0){
                 
                $scope.success = success_text;
                $scope.$apply();
                $scope.is_submit = false;
                setTimeout(() => { location.reload() }, 2000);
             }
        }
        
    }



    $scope.submit = function(){
            
            $scope.error = '', $scope.success = '';
            
            if($scope.is_submit === true){
                return;
            }

            $scope.is_submit = true;
            
            var sel_stars = angular.copy( $scope.item_selected ),
            stars_end = [];
            
            for(var i = 0; i < sel_stars.length; i++){
               
                if( sel_stars[i] ) {
                    stars_end.push( { value: sel_stars[i][0], label: sel_stars[i][1]} ); 
                }
                
            }
            var data = {};
            data.text = $scope.comment_text;
            data.stars = stars_end;
            data.post_id = post_id;

            if($scope.reply_id){
                data.parent = $scope.reply_id;
            }

            $http({
                method: 'POST',
                params: { action: 'serlib_comments' },
                url:    front_obj.ajax_url,
                data: data
            }).then(function successCallback(response) {
                
                if(response.data.success){
                
                    $scope.submitFiles(response.data.success, response.data.comment_ID);
                 
                    
                }else if( response.data.error ){
                                      
                    $scope.error = response.data.error;
                    $scope.is_submit = false;
                }else if( response.data == 0){
                    $scope.error = 'Tú sessión a expiró';
                    $scope.is_submit = false;
                }
                
                

            }, function errorCallback(error) {
                if(error.data == 0){
                    $scope.error = 'Tú sessión a expiró';
                }else{
                    $scope.error =  error.data;            
                }
                $scope.is_submit = false;
            });

    };

    $scope.reply = function(id_comment, name, $event){
        //console.log(offset_textarea.top,$($event.toElement).offset().top);
        //var offsetF = offset_textarea.top-$($event.toElement).offset().top-900;
        //console.log(offsetF);
        $scope.reply_id = id_comment;
        $scope.reply_name = name;
    }
    
    $scope.cancel_reply = function(){
        $scope.reply_id = false;
        $scope.reply_name = '';
    }
    

    $scope.delete_comment = function(id, $event, child = false){
       
        $http({
            method: 'DELETE',
            params: { action: 'serlib_comments', id_comment: id },
            url:    front_obj.ajax_url
        }).then(function successCallback(response) {
            
            if(response.data.success){
            
                angular.element($event.toElement).parent().parent().parent().fadeOut();
             
                
            }
            
            

        }, function errorCallback(error) {
            
            $scope.is_submit = false;
            $scope.error =  error.data;            
        });
    }

}]).directive('appFilereader', function($q) {
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
                if(files.size > (1024*10)*1000){
                    alert('el tamaño maximo permitido es 10MB')
                    return;
                }
                ngModel.$setViewValue(files);
               
                var urlObject = URL.createObjectURL(files);
                
                if(attrs.preview){
                                                       
                    scope.$parent[attrs.preview] = urlObject;
                    
                    scope.$apply() 
            
                }
                
                if(attrs.previewArray && attrs.indice){
                    
                    scope.$parent[attrs.previewArray][attrs.indice] = urlObject;
                    scope.$apply() 
                }

            }); 


        } 
    }; 
});

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
                       
                        var rol = response.data.success.roles[0];
                        
                        
                        if(rol === 'turista'){
                            setTimeout(() => { window.location = "/"; }, 2500);
                        }else if(rol === 'comerciante'){
                            setTimeout(() => { window.location = "/mi-cuenta#!/negocios/all"; }, 2500);
                        }else if(rol === 'alcaldia' || rol === 'gobernacion' || rol === 'aliado'){
                            setTimeout(() => { window.location = "mi-cuenta/#!/articulos/all"; }, 2500);
                        }else if(rol === 'staff' || rol === 'administrator'){
                            setTimeout(() => { window.location = "/wp-admin"; }, 2500);
                        }

                        $scope.user_login = true;
                       
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
                        $scope.is_submit = false;
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
                        alert('Tu contraseña ha sido cambiada');
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
            }else {
                

                $scope.profile_photo = hasValue($scope.Instance.picture) ? $scope.Instance.picture: $scope.profile_photo;
                
                if($scope.Instance.modo === 'instagram'){
                    
                    var instagramForm = JSON.parse(sessionStorage.getItem('auth_instagram'));       
                    $scope.Model = angular.merge(instagramForm, { modo: $scope.Instance.modo, nombre: $scope.Instance.username, photo_url: '', _wpnonce: angular.element('#_wpnonce').val() });
            
                }else{      
                    var Form = angular.copy($scope.Model);
                    $scope.Model = angular.merge( Form, { modo: $scope.Instance.modo, nombre: $scope.Instance.first_name, apellido: $scope.Instance.last_name, email: $scope.Instance.email, photo_url: '', _wpnonce: angular.element('#_wpnonce').val() } );
                    
                }
                
                if(sessionStorage.getItem('set_auth')){
                    sessionStorage.clear();
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
        $scope.tipo_documento = ['Cedula ciudadania', 'Pasaporte', 'Visa',  'Cedula Extranjera' ];      

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
            }else if($scope.Model.modo !== 'directo'){
                setTimeout(() => { window.location = "/blog"; }, 2000);
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
                var files = element.files[0];
                if(files.size > (1024*10)*1000){
                    alert('el tamaño maximo permitido es 10MB')
                    return;
                }
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
                    sessionStorage.setItem('set_auth', 0 );
                    sessionStorage.setItem('auth', JSON.stringify(datos) );
                    setTimeout(() => { window.location = '/auth/register'; }, 3000); 
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
                       
                    var rol = response.data.success.roles[0];
                    

                    if(rol === 'turista'){
                        setTimeout(() => { window.location = "/"; }, 2500);
                    }else if(rol === 'comerciante'){
                        setTimeout(() => { window.location = "/mi-cuenta#!/negocios/all"; }, 2500);
                    }else if(rol === 'alcaldia' || rol === 'gobernacion'){
                        setTimeout(() => { window.location = "/mi-cuenta#!/articulos/all"; }, 2500);
                    }else if(rol === 'staff' || rol === 'administrator'){
                        setTimeout(() => { window.location = "/wp-admin"; }, 2500);
                    }

                    $scope.user_login = true;
                   
                }else if(response.data.error){
                    $scope.error = response.data.error;
                    $scope.is_submit = false;
                    if( Config.action === 'login'){
                     
                        $scope.error = response.data.error;
                        $scope.redirect_register_social(datos);
                   
                    }else if(Config.action === 'register'){
                       $scope.Instance = datos;
                       $scope.UpdateInstance();
                    }

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
                
                FB.logout(function(response){

                    deleteCookie("fbsr_837676896763514");
                      
                });
  
                function deleteCookie(name){
  
                    document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                
                }

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
                        $scope.is_submit = false;
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

var admin_frontend = angular.module('admin_frontend', ['SER.selector', 'ngMaterial', 'ngMessages', 'ui.router', 'summernote'])
    .config(['$compileProvider', function ($compileProvider) {
        $compileProvider.debugInfoEnabled(false);
    }])
    .config(function ($mdThemingProvider) {
        $mdThemingProvider.theme('default')
            .primaryPalette('light-green');

          
    })
    .config(function ($sceDelegateProvider) {
        $sceDelegateProvider.resourceUrlWhitelist([
        // Allow same origin resource loads.
        'self',
        // Allow loading from our assets domain. **.
        'https://maps.google.com/**'
        ]);
    })
    .config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {

      
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
                Posts: ['$http', function ($http) {
                    return  $http({
                                    method: 'GET',
                                    params: { action: 'serlib_users_info', 'post_type': 'post'},
                                    url:    front_obj.ajax_url,
                                });
                }] 
            }
        })
      
        .state('publicaciones.create', {
            url: "/form",
            templateUrl: '../wp-content/plugins/ser_lib/assets/html/frontend/form.php',
            controller: 'BaseForm',
            resolve: {
                Instance: ['$stateParams', '$http', function ($stateParams, $http) {
                    return $http({
                        method: 'GET',
                        params: { action: 'serlib_users_info', categories: 'all'},
                        url:    front_obj.ajax_url,
                    });
                }],
                Config:  () => { return { redirectTo: 'publicaciones.all'}; }
            }
        })
        .state('publicaciones.update', {
            url: '/form/:ID',
            templateUrl: '../wp-content/plugins/ser_lib/assets/html/frontend/form.php',
            controller: 'BaseForm',
            resolve: {
                Instance: ['$stateParams', '$http', function ($stateParams, $http) {
                    return  $http({
                                method: 'GET',
                                params: { action: 'serlib_users_info', categories: 'all', post_type: 'post', ID: $stateParams.ID },
                                url:    front_obj.ajax_url,
                            });
                }],
                Config:  () => { return { redirectTo: 'publicaciones.all'}; }
            }
        })
        .state('negocios', {
            abstract: true,
            url: "/negocios",
            template: '<ui-view/>'
        })
        .state('negocios.all', {
            url: "/all",
            templateUrl: '../wp-content/plugins/ser_lib/assets/html/frontend/all-post-negocio.php',
            controller: 'BaseCrud',
            resolve: {
                Posts: ['$http', function ($http) {
                    return  $http({
                                    method: 'GET',
                                    params: { action: 'serlib_users_info', 'post_type': 'post'},
                                    url:    front_obj.ajax_url,
                                });
                }] 
            }
        })
        .state('negocios.create', {
            url: "/form",
            templateUrl: '../wp-content/plugins/ser_lib/assets/html/frontend/form-negocio.php',
            controller: 'FormComerciante',
            resolve: {
                Instance: ['$stateParams', '$http', function ($stateParams, $http) {
                    return $http({
                        method: 'GET',
                        params: { action: 'serlib_users_info', tipos: 'all',  municipios: 'all'},
                        url:    front_obj.ajax_url,
                    });
                }],
                Config:  () => { return { redirectTo: 'negocios.all'}; }
            }
        })
        .state('negocios.update', {
            url: '/form/:ID',
            templateUrl: '../wp-content/plugins/ser_lib/assets/html/frontend/form-negocio.php',
            controller: 'FormComerciante',
            resolve: {
                Instance: ['$stateParams', '$http', function ($stateParams, $http) {
                    return  $http({
                                method: 'GET',
                                params: { action: 'serlib_users_info',  tipos: 'all',  municipios: 'all', post_type: 'post', ID: $stateParams.ID },
                                url:    front_obj.ajax_url,
                            });
                }],
                Config:  () => { return { redirectTo: 'negocios.all'}; }
            }
        })
        
        .state('articulos', {
            abstract: true,
            url: "/articulos",
            template: '<ui-view/>'
        })
        .state('articulos.all', {
            url: "/all",
            templateUrl: '../wp-content/plugins/ser_lib/assets/html/frontend/all-post-gobierno.php',
            controller: 'BaseCrud',
            resolve: {
                Posts: ['$http', function ($http) {
                    return  $http({
                                    method: 'GET',
                                    params: { action: 'serlib_users_info', 'post_type': 'post'},
                                    url:    front_obj.ajax_url,
                                });
                }] 
            }
        })
        .state('articulos.create', {
            url: "/form",
            templateUrl: '../wp-content/plugins/ser_lib/assets/html/frontend/form-gobierno.php',
            controller: 'BaseFormGobierno',
            resolve: {
                Instance: ['$stateParams', '$http', function ($stateParams, $http) {
                    return $http({
                        method: 'GET',
                        params: { action: 'serlib_users_info', tipos: 'all',  municipios: 'all'},
                        url:    front_obj.ajax_url,
                    });
                }],
                Config:  () => { return { redirectTo: 'articulos.all'}; }
            }
        })
        .state('articulos.update', {
            url: '/form/:ID',
            templateUrl: '../wp-content/plugins/ser_lib/assets/html/frontend/form-gobierno.php',
            controller: 'BaseFormGobierno',
            resolve: {
                Instance: ['$stateParams', '$http', function ($stateParams, $http) {
                    return  $http({
                                method: 'GET',
                                params: { action: 'serlib_users_info',  tipos: 'all',  municipios: 'all', post_type: 'post', ID: $stateParams.ID },
                                url:    front_obj.ajax_url,
                            });
                }],
                Config:  () => { return { redirectTo: 'articulos.all'}; }
            }
        })
        .state('profile', {
            url: "/profile",
            templateUrl: '../wp-content/plugins/ser_lib/assets/html/frontend/profile.php',
            controller: 'BaseProfile'
        })
        .state('root', {
            url: "",
            templateUrl: '../wp-content/plugins/ser_lib/assets/html/frontend/profile.php',
            controller: 'BaseProfile'
        });

        $urlRouterProvider.otherwise("/profile");

    }]);


admin_frontend.controller('AppCtrl', ['$scope', 
    function AppCtrl($scope) {
    $scope.name =  userinfo.name;
    $scope.rol =  userinfo.rol;
    $scope.img_profile = userinfo.img_profile;

    $scope.remove_side = function(){
        $('#admin_frontend .sidebar_profile').removeClass('showside');
        $('#back-side').hide();
    }

}]);

admin_frontend.controller('BaseProfile', ['$scope', '$http',
    function BaseProfile($scope, $http ) {
        
        $scope.Model =  userinfo;
        var img_default = 'https://golfodemorrosquillo.com/wp-content/uploads/2020/05/240_F_64676383_LdbmhiNM6Ypzb3FM4PPuFP9rHe7ri8Ju.jpg';
        $scope.profile_photo = $scope.Model.img_profile ? $scope.Model.img_profile: img_default;
        $scope.photo = []; 
        var id =  $scope.Model.ID;
        $scope.loader = false;

        $scope.toogle_side = function(){
            $('#back-side').show();
            $('#admin_frontend .sidebar_profile').toggleClass('showside');
        }
        
        $scope.submitFiles = function(){
            $scope.loader = true;
            if( hasValue($scope.photo) &&  $scope.photo !== [] ) {
                                
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
                        $scope.submit();
                    },
                    error: function(error){
                        $scope.error =  error; 
                        $scope.submit();
                    }
                });

            }else{
                $scope.submit();
            }

        }

        $scope.submit = function(){

            var params =  { action: 'serlib_users_info' };
            var data = angular.copy($scope.Model);
            data._wpnonce = angular.element('#_wpnonce').val();
            $http({
                method: 'PUT',
                params: params,
                url:    front_obj.ajax_url,
                data: data
            }).then(function successCallback(response) {
                
                $scope.loader = false;     
                if(response.data.user_update){
                     location.reload();
                }           
              
            }, function errorCallback(error) {
                $scope.loader = false;
                location.reload();
                $scope.error =  error.data;            
            });
        }


}]);

admin_frontend.controller('BaseCrud', ['$scope', 'Posts', '$http', '$mdDialog',
    function BaseCrud($scope, Posts,  $http, $mdDialog ) {
    $scope.rol =  userinfo.rol;
    $scope.ObjectList = Posts.data.posts;

    $scope.toogle_side = function(){
        $('#back-side').show();
        $('#admin_frontend .sidebar_profile').toggleClass('showside');
    }

    $scope.delete = function(ID, ev){
        
        var data = { ID: ID};
        var templateForm = '../wp-content/plugins/ser_lib/assets/html/frontend/confirm_action.html';
        var controllerForm =  DialogForm;
        $mdDialog.show({
            controller:           controllerForm,
            templateUrl:          templateForm,
            parent:               angular.element(document.body),
            locals:               { Instance: ID }, 
            targetEvent:          ev,
            clickOutsideToClose:  true
        })
        .then(function(response) {
            
            if(response == true ){
                data._wpnonce = angular.element('#_wpnonce').val();
       
                $http({
                    method: 'DELETE',
                    params:  { action: 'serlib_users_info'},
                    url:    front_obj.ajax_url,
                    data: data
                }).then(function successCallback(response) {
                    
                    window.location.reload();
        
                }, function errorCallback(error) {
                    window.location.reload();      
                });
                
            }
        }, function(error) {
            $scope.error =  error.data;
        });

    }
    
}]);

admin_frontend.controller('BaseForm', ['$scope', '$state', 'Config', 'Instance', '$http',
    function BaseForm($scope, $state, Config, Instance, $http) {
        
        $scope.categories = [];
        $scope.loader = false;
        $scope.Instance = Instance.data;
        $scope.is_submit = 0;
        $scope.featured = '../wp-content/plugins/ser_lib/assets/img/images.png'
        
        $scope.toogle_side = function(){
            $('#back-side').show();
            $('#admin_frontend .sidebar_profile').toggleClass('showside');
        }

        var params = {};
        $scope.Model = {};

        $scope.options = {
            height: 450,
            shortcuts: false,
            lang: "es-ES",
            maximumImageFileSize: 2000*1024,
            placeholder: '...',
            dialogsInBody: true,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
               
            ],
            callbacks : {
                onImageUpload: function(image) {
                    uploadImage(image[0]);
                },
                onImageUploadError: function(msg){
                    alert('La imagen no puede exceder (2 MB)');
                }
            }
            
        };


        function uploadImage(image) {
            var data = new FormData();
            data.append("files",image);
            $('#summernote').addClass('load_images');
            angular.element.ajax({
                type: 'POST',
                url: front_obj.ajax_url+'?action=serlib_uploader&destino=image',
                data: data,
                contentType: false,
                cache: false,
                processData:false,
                success: function(url) {
                    
                    angular.element('#summernote').summernote('editor.insertImage', url, function ($image) {
                        $image.css('width', '50%');
                        $image.attr('data-filename', 'retriever');
                      });
                      $('#summernote').removeClass('load_images');

                },
                error: function(data) {
                    console.log(data);
                    $('#summernote').removeClass('load_images');
                }
            });
        }


        params =  { action: 'serlib_users_info', post_type: 'post', id_featured: 0 };
        
        if($scope.Instance.post){
            $scope.Model = $scope.Instance.post;  
            if($scope.Model.thumbnail) $scope.featured = $scope.Model.thumbnail;
            
        }

        $scope.categories = $scope.Instance.categories;

        /**Subida de archivos */
        $scope.submitFiles = function(){
            
            if($scope.is_submit !== 0) return;
           
            $scope.is_submit = 1;
            $scope.loader = true;

            if(hasValue($scope.featured_file) ){
                                
                var formData = new FormData();
                formData.append('files', $scope.featured_file);
            
                angular.element.ajax({
                    type: 'POST',
                    url: front_obj.ajax_url+'?action=serlib_uploader&destino=featured',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(response){
                        if(response.success){
                            $scope.submit(response.success);
                        }else if(response.data.error){
                            $scope.error =  response.error; 
                            $scope.submit();

                        }
                       
                    },
                    error: function(error){
                        $scope.error =  error; 
                        $scope.submit();
                    }
                });

            }else{
                $scope.submit();
            }
            
        }


        /**Validaciones de campos no llenos imagen destacada poder subir inmagenes si es comerciante si no colcoar un limite 
         * lo podemos hacer en la funcion de subir imagenes 
        */    
        $scope.submit = function(id_featured = false){
          
            if(id_featured){
                params.id_featured = id_featured;
            }    
        
            var data = angular.copy($scope.Model);
            data._wpnonce = angular.element('#_wpnonce').val();
            
            $http({
                method: 'POST',
                params: params,
                url:    front_obj.ajax_url,
                data: data
            }).then(function successCallback(response) {
                
                if(response.data.status === 1 ){
                    $scope.error = true;
                }
                if(response.data.status === 2 ){
                   /// response.data.status
                   
                   alert('Gracias revisaremos tu publicación para ser aprobada');
                    $scope.revition = true;
                    $state.go(Config.redirectTo);
                    /**Ahi que enviar a la url de edicion */
                }
                if(response.data.status === 3 ){
                    $scope.send = true;
                }
                $scope.loader = false;
                $scope.is_submit = 0;
                

            }, function errorCallback(error) {
                $scope.loader = false;
                $scope.is_submit = 0;
                $scope.error =  error.data;            
            });

        }


}]);
/**Agregarle los estados necesarios para hacer unos pasos en el formulario y modificar la visual */
admin_frontend.controller('BaseFormGobierno', ['$scope', '$state', 'Config', 'Instance', '$http',
    function BaseFormGobierno($scope, $state, Config, Instance, $http) {
        
        $scope.tipos = [];
        $scope.municipios = [];
        $scope.loader = false;
        $scope.Instance = Instance.data;
        $scope.step = 1;
        $scope.busqueda_mapa = '';
        $scope.is_submit = 0;
        $scope.featured = '../wp-content/plugins/ser_lib/assets/img/images.png';

        $scope.toogle_side = function(){
            $('#back-side').show();
            $('#admin_frontend .sidebar_profile').toggleClass('showside');
        }

       
        $scope.validated_step = false;

        $scope.set_step = function(step, invalid = true){
            /**Aqui colocar las validaciones si se requieren y pasar el mensaje al status */
            if(!invalid){
                $scope.step = step;
                $scope.validated_step = true;
            }else{
                $scope.validated_step = true;
                alert('por favor llena todo los campos obligatorios')
            }
        } 
        
        $scope.set_map_src = function(src){
            if(src === '') src = 'golfo%20de%20morrosquillo';
            $scope.busqueda = src;
        
        }

        var params = {};
        $scope.Model = {};

        $scope.options = {
            height: 450,
            shortcuts: false,
            lang: "es-ES",
            maximumImageFileSize: 2000*1024,
            placeholder: '...',
            dialogsInBody: true,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
               
            ],
            callbacks : {
                onImageUpload: function(image) {
                    uploadImage(image[0]);
                },
                onImageUploadError: function(msg){
                    alert('La imagen no puede exceder (2 MB)');
                }
            }
            
        };


        function uploadImage(image) {
            var data = new FormData();
            data.append("files",image);
            $('#summernote').addClass('load_images');
            angular.element.ajax({
                type: 'POST',
                url: front_obj.ajax_url+'?action=serlib_uploader&destino=image',
                data: data,
                contentType: false,
                cache: false,
                processData:false,
                success: function(url) {
                    
                    $('#summernote').summernote('editor.insertImage', url, function ($image) {
                        $image.css('width', '50%');
                        $image.attr('data-filename', 'retriever');
                      });
                    
                    $('#summernote').removeClass('load_images');

                },
                error: function(data) {
                    $('#summernote').removeClass('load_images');
                    console.log(data);
                }
            });
        }


        params =  { action: 'serlib_users_info', post_type: 'post', id_featured: 0 };
        
        if($scope.Instance.post){
            $scope.Model = $scope.Instance.post;  
         
            if($scope.Model.mapa_negocio){  $scope.busqueda_mapa = $scope.Model.mapa_negocio; $scope.busqueda = $scope.Model.mapa_negocio;}
            if($scope.Model.thumbnail) $scope.featured = $scope.Model.thumbnail;
            
        }


        $scope.tipos = $scope.Instance.tipos;
        $scope.municipios = $scope.Instance.municipios;

        /**Subida de archivos */
        $scope.submitFiles = function(){
            
            if($scope.is_submit !== 0) return;
           
            $scope.is_submit = 1;
            $scope.loader = true;

            if(hasValue($scope.featured_file) ){
                                
                var formData = new FormData();
                formData.append('files', $scope.featured_file);
                
                angular.element.ajax({
                    type: 'POST',
                    url: front_obj.ajax_url+'?action=serlib_uploader&destino=featured',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(response){
                        if(response.success){
                            $scope.submit(response.success);
                        }else if(response.data.error){
                            $scope.error =  response.error; 
                            $scope.submit();

                        }
                       
                    },
                    error: function(error){
                        $scope.error =  error; 
                        $scope.submit();
                    }
                });

            }else{
                $scope.submit();
            }
            
        }


        /**Validaciones de campos no llenos imagen destacada poder subir inmagenes si es comerciante si no colcoar un limite 
         * lo podemos hacer en la funcion de subir imagenes 
        */    
        $scope.submit = function(id_featured = false){
          
            if(id_featured){
                params.id_featured = id_featured;
            }    

            var obj =  {
                mapa: angular.copy($scope.busqueda)
            }; 

            var data = angular.merge(angular.copy($scope.Model), obj) ;
        
            data._wpnonce = angular.element('#_wpnonce').val();
            
            $http({
                method: 'POST',
                params: params,
                url:    front_obj.ajax_url,
                data: data
            }).then(function successCallback(response) {
                
                if(response.data.status === 1 ){
                    $scope.error = true;
                }
                if(response.data.status === 2 ){
                   /// response.data.status
                    $scope.revition = true;
                                      
                    $state.go(Config.redirectTo);
                    /**Ahi que enviar a la url de edicion */
                }
                if(response.data.status === 3 ){
                    $scope.send = true;
                }
                $scope.loader = false;
                $scope.is_submit = 0;
                

            }, function errorCallback(error) {
                $scope.loader = false;
                $scope.is_submit = 0;
                $scope.error =  error.data;            
            });

        }


}]);

admin_frontend.controller('FormComerciante', ['$scope', '$state', 'Config', 'Instance', '$http',
    function FormComerciante($scope, $state, Config, Instance, $http) {
        
        $scope.tipos = [];
        $scope.municipios = [];
        $scope.loader = false;
        $scope.step = 1;
        $scope.busqueda_mapa = '';
        $scope.Instance = Instance.data;
        $scope.is_submit = 0;
        $scope.featured = '../wp-content/plugins/ser_lib/assets/img/images.png';
        $scope.preview_default = '../wp-content/plugins/ser_lib/assets/img/images.png';
        $scope.galery = [];
        $scope.busqueda = 'golfo%20de%20morrosquillo';
        $scope.galery_ids = [];
        $scope.preview_galery = [];
        $scope.servicios = [];
        var params = {};
        $scope.Model = {};

        $scope.toogle_side = function(){
            $('#back-side').hide();
            $('#admin_frontend .sidebar_profile').toggleClass('showside');
        }

        $scope.validated_step = false;

        $scope.set_step = function(step, invalid = true){
            /**Aqui colocar las validaciones si se requieren y pasar el mensaje al status */
            if(!invalid){
                $scope.step = step;
                $scope.validated_step = true;
            }else{
                $scope.validated_step = true;
                alert('por favor llena todo los campos obligatorios')
            }
        }   

        $scope.add_service = function(){
            /**Aqui colocar las validaciones si se requieren y pasar el mensaje al status */
            $scope.servicios.push({title: '', text: '', price: ''});
        }

        $scope.delete_service = function(index){
            /**Aqui colocar las validaciones si se requieren y pasar el mensaje al status */
            $scope.servicios.splice(index, 1);
        }

        $scope.set_map_src = function(src){
            if(src === '') src = 'golfo%20de%20morrosquillo';
            $scope.busqueda = src;
        
        }


        $scope.options = {
            height: 450,
            shortcuts: false,
            lang: "es-ES",
            placeholder: '...',
            maximumImageFileSize: 2000*1024,
            dialogsInBody: true,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['height', ['height']]
            ],
            callbacks : {
                onImageUpload: function(image) {
                    uploadImage(image[0]);
                },
                onImageUploadError: function(msg){
                    alert('La imagen no puede exceder (2 MB)');
                }
            }
            
        };

        function uploadImage(image) {
            var data = new FormData();
            data.append("files",image);
            $('#summernote').addClass('load_images');
            angular.element.ajax({
                type: 'POST',
                url: front_obj.ajax_url+'?action=serlib_uploader&destino=image',
                data: data,
                contentType: false,
                cache: false,
                processData:false,
                success: function(url) {
                    
                    $('#summernote').summernote('editor.insertImage', url, function ($image) {
                        $image.css('width', '50%');
                        $image.attr('data-filename', 'retriever');
                      });
                      $('#summernote').removeClass('load_images');

                },
                error: function(data) {
                    console.log(data);
                    $('#summernote').removelass('load_images');
                }
            });
        }

        params =  { action: 'serlib_users_info', post_type: 'post', id_featured: 0 };
        
        if($scope.Instance.post){
            $scope.Model = $scope.Instance.post;  
            if($scope.Model.thumbnail) $scope.featured = $scope.Model.thumbnail;
            if($scope.Model.mapa_negocio){  $scope.busqueda_mapa = $scope.Model.mapa_negocio; $scope.busqueda = $scope.Model.mapa_negocio;}
            if($scope.Model.galery_ids){ 
                $scope.galery = $scope.Model.galery_ids;
                $scope.galery_ids = angular.copy($scope.Model.galery_ids);
                for(var i = 0; i < $scope.Model.galery.length; i++){
                 
                    $scope.preview_galery.push(($scope.Model.galery[i]));
                } 
            }
            if($scope.Model.servicios){ 
                $scope.servicios = $scope.Model.servicios;
            }
           
            
        }

        $scope.tipos = $scope.Instance.tipos;
        $scope.municipios = $scope.Instance.municipios;
        $scope.tags = $scope.Instance.tags;
        $scope.mapa_option = $scope.Instance.mapa_option;
        

        $scope.add_galery = function(){
            /**Aqui colocar las validaciones si se requieren y pasar el mensaje al status */
            $scope.galery.push({text: ''});
        }

        $scope.delete_image = function(index){
            if(Instance) $scope.galery_ids.splice(index, 1);
              $scope.galery.splice(index, 1);
              $scope.preview_galery.splice(index, 1);
        }


        /**Subida de archivos */
        $scope.submitFiles = function(){
            
            if($scope.is_submit !== 0) return;
            $scope.is_submit = 1;
           
            $scope.loader = true;

            var promises = 0;
            var featured = false;
            var files =  angular.copy($scope.galery).length;
            var ids =  angular.copy($scope.galery_ids);
            for(var i = 0; i < files; i++ ){
               
                if($scope.galery[i].name) {
                   
                    promises++;
                    var formData = new FormData();
                    formData.append('files', $scope.galery[i]);
                    
                    angular.element.ajax({
                        type: 'POST',
                        url: front_obj.ajax_url+'?action=serlib_uploader&destino=featured&order='+i,
                        data: formData,
                        contentType: false,
                        cache: false,
                        processData:false,
                        success: function(response){

                            if(response.success){
                                ids[response.success.order] = response.success.id;
                            }

                            finally_promises();
                        
                        },
                        error: function(error){
                            $scope.error =  error; 
                        
                            finally_promises();
                        }
                    });
                }
            }

            if(hasValue($scope.featured_file) ){
               
                promises++;
                                
                var formData = new FormData();
                formData.append('files', $scope.featured_file);
            
                angular.element.ajax({
                    type: 'POST',
                    url: front_obj.ajax_url+'?action=serlib_uploader&destino=featured',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData:false,
                    success: function(response){
                        if(response.success){
                            featured = response.success;
                        }else if(response.data.error){
                            $scope.error =  response.error; 
                        }
                        
                        finally_promises();
                       
                    },
                    error: function(error){
                        $scope.error =  error; 
                       
                        finally_promises();
                    }
                });

            }

            if(promises === 0){
                promises++;
                finally_promises();
            }

            function finally_promises(){
                promises--;
                 if(promises === 0){
                       $scope.submit(featured, ids);
                 }
            }
            
        }


        /**Validaciones de campos no llenos imagen destacada poder subir inmagenes si es comerciante si no colcoar un limite 
         * lo podemos hacer en la funcion de subir imagenes 
        */    
        $scope.submit = function(id_featured = false, galery_ids){
         
            if(id_featured){
                params.id_featured = id_featured;
            }    
          
            var obj =  {
                        servicios: angular.copy($scope.servicios),
                        galery_ids: galery_ids,
                        mapa: angular.copy($scope.busqueda)
                    }; 
        
            var data = angular.merge(angular.copy($scope.Model), obj) ;
            
            data._wpnonce = angular.element('#_wpnonce').val();
            
            $http({
                method: 'POST',
                params: params,
                url:    front_obj.ajax_url,
                data: data
            }).then(function successCallback(response) {
                
                if(response.data.status === 1 ){
                    $scope.error = true;
                }
                if(response.data.status === 2 ){
                   /// response.data.status
                    $scope.revition = true;
                    alert('Gracias revisaremos tu publicación para ser aprobada');
                    $state.go(Config.redirectTo);
                    /**Ahi que enviar a la url de edicion */
                }
                if(response.data.status === 3 ){
                    $scope.send = true;
                }
                $scope.loader = false;
                $scope.is_submit = 0;
                

            }, function errorCallback(error) {
                $scope.loader = false;
                $scope.is_submit = 0;
                $scope.error =  error.data;            
            });

        }

}]);

admin_frontend.directive('appFilereader', function($q) {
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
                var files = element.files[0];
                if(files.size > (1024*10)*1000){
                    alert('el tamaño maximo permitido es 10MB')
                    return;
                }
                ngModel.$setViewValue(files);
                
                var urlObject = URL.createObjectURL(files);
                
                if(attrs.preview){
                                                       
                    scope.$parent[attrs.preview] = urlObject;
                    
                    scope.$apply() 
            
                }
                
                if(attrs.previewArray && attrs.indice){

                    scope.$parent[attrs.previewArray][attrs.indice] = urlObject;
                    scope.$apply() 
                }

            }); 


        } 
    }; 
});

function DialogForm($scope, $mdDialog, Instance) {
    
    $scope.Model = {};
    
    if(hasValue(Instance)){ 
        $scope.title    =   'Eliminar Publicación';
        $scope.action   =   'Si, eliminar';
    }else{ 
        $scope.title    =   'Eliminar Publicación';
        $scope.action   =   'Si, eliminar';
    }
    
    $scope.confirm = function() {
        $mdDialog.hide(true);
    };

    $scope.cancel = function() {
      $mdDialog.cancel();
    };

    
}


(function($) {
    if($.summernote){
        $.extend($.summernote.lang, {
        'es-ES': {
            font: {
            bold: 'Negrita',
            italic: 'Cursiva',
            underline: 'Subrayado',
            clear: 'Eliminar estilo de letra',
            height: 'Altura de línea',
            name: 'Tipo de letra',
            strikethrough: 'Tachado',
            subscript: 'Subíndice',
            superscript: 'Superíndice',
            size: 'Tamaño de la fuente',
            sizeunit: 'Unidad del tamaño de letra',
            },
            image: {
            image: 'Imagen',
            insert: 'Insertar imagen',
            resizeFull: 'Redimensionar a tamaño completo',
            resizeHalf: 'Redimensionar a la mitad',
            resizeQuarter: 'Redimensionar a un cuarto',
            resizeNone: 'Tamaño original',
            floatLeft: 'Flotar a la izquierda',
            floatRight: 'Flotar a la derecha',
            floatNone: 'No flotar',
            shapeRounded: 'Forma: Redondeado',
            shapeCircle: 'Forma: Círculo',
            shapeThumbnail: 'Forma: Miniatura',
            shapeNone: 'Forma: Ninguna',
            dragImageHere: 'Arrastre una imagen o texto aquí',
            dropImage: 'Suelte una imagen o texto',
            selectFromFiles: 'Seleccione un fichero (Max: 2MB)',
            maximumFileSize: 'Tamaño máximo del fichero',
            maximumFileSizeError: 'Superado el tamaño máximo de fichero.',
            url: 'URL de la imagen',
            remove: 'Eliminar la imagen',
            original: 'Original',
            },
            video: {
            video: 'Vídeo',
            videoLink: 'Enlace del vídeo',
            insert: 'Insertar un vídeo',
            url: 'URL del vídeo',
            providers: '(YouTube, Vimeo, Instagram)',
            },
            link: {
            link: 'Enlace',
            insert: 'Insertar un enlace',
            unlink: 'Quitar el enlace',
            edit: 'Editar',
            textToDisplay: 'Texto a mostrar',
            url: '¿A qué URL lleva este enlace?',
            openInNewWindow: 'Abrir en una nueva ventana',
            useProtocol: 'Usar el protocolo predefinido',
            },
            table: {
            table: 'Tabla',
            addRowAbove: 'Añadir una fila encima',
            addRowBelow: 'Añadir una fila debajo',
            addColLeft: 'Añadir una columna a la izquierda',
            addColRight: 'Añadir una columna a la derecha',
            delRow: 'Borrar la fila',
            delCol: 'Borrar la columna',
            delTable: 'Borrar la tabla',
            },
            hr: {
            insert: 'Insertar una línea horizontal',
            },
            style: {
            style: 'Estilo',
            p: 'Normal',
            blockquote: 'Cita',
            pre: 'Código',
            h1: 'Título 1',
            h2: 'Título 2',
            h3: 'Título 3',
            h4: 'Título 4',
            h5: 'Título 5',
            h6: 'Título 6',
            },
            lists: {
            unordered: 'Lista',
            ordered: 'Lista numerada',
            },
            options: {
            help: 'Ayuda',
            fullscreen: 'Pantalla completa',
            codeview: 'Ver el código fuente',
            },
            paragraph: {
            paragraph: 'Párrafo',
            outdent: 'Reducir la sangría',
            indent: 'Aumentar la sangría',
            left: 'Alinear a la izquierda',
            center: 'Centrar',
            right: 'Alinear a la derecha',
            justify: 'Justificar',
            },
            color: {
            recent: 'Último color',
            more: 'Más colores',
            background: 'Color de fondo',
            foreground: 'Color del texto',
            transparent: 'Transparente',
            setTransparent: 'Establecer transparente',
            reset: 'Restablecer',
            resetToDefault: 'Restablecer a los valores predefinidos',
            cpSelect: 'Seleccionar',
            },
            shortcut: {
            shortcuts: 'Atajos de teclado',
            close: 'Cerrar',
            textFormatting: 'Formato de texto',
            action: 'Acción',
            paragraphFormatting: 'Formato de párrafo',
            documentStyle: 'Estilo de documento',
            extraKeys: 'Teclas adicionales',
            },
            help: {
            insertParagraph: 'Insertar un párrafo',
            undo: 'Deshacer la última acción',
            redo: 'Rehacer la última acción',
            tab: 'Tabular',
            untab: 'Eliminar tabulación',
            bold: 'Establecer estilo negrita',
            italic: 'Establecer estilo cursiva',
            underline: 'Establecer estilo subrayado',
            strikethrough: 'Establecer estilo tachado',
            removeFormat: 'Limpiar estilo',
            justifyLeft: 'Alinear a la izquierda',
            justifyCenter: 'Alinear al centro',
            justifyRight: 'Alinear a la derecha',
            justifyFull: 'Justificar',
            insertUnorderedList: 'Insertar lista',
            insertOrderedList: 'Insertar lista numerada',
            outdent: 'Reducir sangría del párrafo',
            indent: 'Aumentar sangría del párrafo',
            formatPara: 'Cambiar el formato del bloque actual a párrafo (etiqueta P)',
            formatH1: 'Cambiar el formato del bloque actual a H1',
            formatH2: 'Cambiar el formato del bloque actual a H2',
            formatH3: 'Cambiar el formato del bloque actual a H3',
            formatH4: 'Cambiar el formato del bloque actual a H4',
            formatH5: 'Cambiar el formato del bloque actual a H5',
            formatH6: 'Cambiar el formato del bloque actual a H6',
            insertHorizontalRule: 'Insertar una línea horizontal',
            'linkDialog.show': 'Mostrar el panel de enlaces',
            },
            history: {
            undo: 'Deshacer',
            redo: 'Rehacer',
            },
            specialChar: {
            specialChar: 'CARACTERES ESPECIALES',
            select: 'Seleccionar caracteres especiales',
            },
            output: {
            noSelection: '¡No ha seleccionado nada!',
            },
        },
        });
    }

  

  })(jQuery);