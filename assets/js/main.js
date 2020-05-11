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


app.controller('loginController', ['$scope', '$http', '$mdDialog' 
                ,function baseCrud($scope, $http, $mdDialog) {
        
    console.log('cargado');

}]);


app.controller('registerController', ['$scope', '$http', '$mdDialog' 
                ,function baseCrud($scope, $http, $mdDialog) {
    
        $scope.states = [];
        $scope.cities = [];
        $scope.profile_photo = 'https://golfodemorrosquillo.com/wp-content/uploads/2020/05/240_F_64676383_LdbmhiNM6Ypzb3FM4PPuFP9rHe7ri8Ju.jpg';
        $scope.conocimientoPagina = [ 'Volante' , 'Correo Electrónico', 'Amigo', 'Redes Sociales', 'Otro' ],
        $scope.Intereses = ['Hospedaje', 'Gastronomía', 'Sitios', 'Diversión', 'Cultura', 'Transporte' ];      

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
    

}]);

