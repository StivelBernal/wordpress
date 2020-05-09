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
        
    $scope.ObjectList = [];
    $scope.error = '';
    var $table = 'states',
        $templateForm = '../wp-content/plugins/ser_library/assets/html/dialog-admin.html';
    
    $scope.getList = function(){
        $scope.ObjectList = [];
        $http({
            method: 'GET',
            params: { action: 'serlib_options_handler', table: $table },
            url:    back_obj.ajax_url
        }).then(function successCallback(response) {
            $scope.ObjectList = response.data;
            
        }, function errorCallback(response) {
            console.log('fallo cargando states', response);            
        });
    }

    $scope.create = function(ev) {
        $mdDialog.show({
          controller:           DialogController,
          templateUrl:          $templateForm,
          parent:               angular.element(document.body),
          locals:               { Instance: null, table: $table }, 
          targetEvent:          ev,
          clickOutsideToClose:  true
        })
        .then(function(response) {
            if(response.data == 1 ){
                $scope.getList();
            }

        }, function(error) {
           $scope.error =  error.data;
        });
    };

    $scope.update = function(ev, state) {
        $mdDialog.show({
          controller:           DialogController,
          templateUrl:          $templateForm,
          parent:               angular.element(document.body),
          locals:               { Instance: state, table: $table }, 
          targetEvent:          ev,
          clickOutsideToClose:  true
        })
        .then(function(response) {
            if(response.data == 1 ){
                $scope.getList();
            }
        }, function(error) {
            $scope.error =  error.data;
        });
    };

    $scope.toggleActive = function(object){
        
        $http( {
            method: 'PUT',
            params: { action: 'serlib_options_handler', table: $table, mod: 'active' },
            url:    back_obj.ajax_url,
            data:   object,
		}).then(function successCallback(response) {
            if(response.data == 1){
                console.log(response);
            }
		}, function errorCallback(error) {
			$scope.error =  error.data;            
        });
    }

    $scope.delete = function(object, $index){
        
        $http( {
            method: 'DELETE',
            params: { action: 'serlib_options_handler', table: $table },
            url:    back_obj.ajax_url,
            data:   object,
		}).then(function successCallback(response) {
            if(response.data == 1){
                $scope.ObjectList.splice($index, 1);
            }
		}, function errorCallback(error) {
			$scope.error =  error.data;           
        });
        
    }

    $scope.getList();

}]); 

function DialogController($scope, $mdDialog, $http, Instance, table) {
    
    $scope.Model = {};
    
    if(hasValue(Instance)){ 
        $scope.title    =   'Editar'
        $params         =   { action: 'serlib_options_handler', table: table};
        $scope.Model    =   angular.copy(Instance);
        $method         =   'PUT';
    }else{ 
        $scope.title    =   'Crear';
        $params         =   { action: 'serlib_options_handler', table: table }
        $scope.Model    =   {};
        $method         =   'POST';
    }
    
    $scope.submit = function() {
        $http( {
            method: $method,
            params: $params,
            url:    back_obj.ajax_url,
            data:   $scope.Model,
		}).then(function successCallback(response) {
			$mdDialog.hide(response);
		}, function errorCallback(response) {
			alert('fallo server', response.data);            
		});
    };

    $scope.cancel = function() {
      $mdDialog.cancel();
    };

    
}