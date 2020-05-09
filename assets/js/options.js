var app = angular.module('serApp', ['ngMaterial'])
    .config(function ($mdThemingProvider) {
        $mdThemingProvider.theme('default')
            .primaryPalette('light-green');
    })
    .config(['$compileProvider', function ($compileProvider) {
        $compileProvider.debugInfoEnabled(false);
    }]);

app.controller('stateController', ['$scope', '$http', '$mdDialog' 
                ,function stateController($scope, $http, $mdDialog) {
    
    console.log('cargado');
    
    $scope.states = [];
    
    $scope.getList = function(){
        $http({
            method: 'GET',
            params: { action: 'serlib_options_handler', table: 'states', mod: 'GET' },
            url: back_obj.ajax_url
        }).then(function successCallback(response) {
            $scope.states = response.data;
            
        }, function errorCallback(response) {
            console.log('fallo cargando states', response);            
        });
    }

    $scope.create = function(ev) {
        $mdDialog.show({
          controller: DialogController,
          templateUrl: '../wp-content/plugins/ser_library/assets/html/dialog-admin.html',
          parent: angular.element(document.body),
          locals: { Instance: null, table: 'states' }, 
          targetEvent: ev,
          clickOutsideToClose:true
        })
        .then(function(answer) {
            $scope.status = 'You said the information was "' + answer + '".';
        }, function() {
            $scope.status = 'You cancelled the dialog.';
        });
      };

      $scope.getList();
	   
  

}]); 

function DialogController($scope, $mdDialog, $http, Instance, table) {
    
    $scope.Model = {};
    
    if(hasValue(Instance)){ 
        $scope.title = 'Editar'
    }else{ 
        $scope.title = 'Crear';
    }
    
    $scope.submit = function() {
        $http( {
            method: 'POST',
            params: { action: 'serlib_options_handler', table: 'states', mod: 'POST' },
            url: back_obj.ajax_url,
            data: $scope.Model,
		}).then(function successCallback(response) {
			$scope.send = false;
           $scope.message = response.data + ' correos enviados';
		}, function errorCallback(response) {
			console.log('fallo cargando contactos', response);            
		});
    };

    $scope.cancel = function() {
      $mdDialog.cancel();
    };

    
}