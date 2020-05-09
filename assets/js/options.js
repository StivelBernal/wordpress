var app = angular.module('serApp', ['ngMaterial'])
    .config(function ($mdThemingProvider) {
        $mdThemingProvider.theme('default')
            .primaryPalette('light-green');
    })
    .config(['$compileProvider', function ($compileProvider) {
        $compileProvider.debugInfoEnabled(false);
    }]);


app.controller('BaseCrud', ['$scope', 'Config', '$http', '$mdDialog' 
                ,function baseCrud($scope, Config, $http, $mdDialog) {
        
    $scope.ObjectList = [];
    $scope.error = '';
    var $table = Config.table,
        $templateForm = Config.templateForm,
        $DialogController = Config.controllerForm;
    
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
          controller:           $DialogController,
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
          controller:           $DialogController,
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
        console.log(object, $index);
        $http( {
            method: 'DELETE',
            params: { action: 'serlib_options_handler', table: $table },
            url:    back_obj.ajax_url,
            data:   object,
		}).then(function successCallback(response) {
            if(response.data == 1){
                angular.element('#objectlist'+object).fadeOut();
            }
		}, function errorCallback(error) {
			$scope.error =  error.data;           
        });
        
    }

    $scope.getList();

}]);

app.controller('cityController', ['$scope', '$controller' 
                ,function cityController($scope, $controller) {
        
    $controller('BaseCrud', {
        $scope: $scope,
        Config: {
            table: 'cities',
            templateForm: '../wp-content/plugins/ser_library/assets/html/dialog-admin-cities.html',
            controllerForm: DialogCities
        }
    });

}]);

app.controller('stateController', ['$scope', '$controller' 
             ,function stateController($scope, $controller) {

    $controller('BaseCrud', {
        $scope: $scope,
        Config: {
            table: 'states',
            templateForm: '../wp-content/plugins/ser_library/assets/html/dialog-admin-states.html',
            controllerForm: DialogForm
        }
    });

}]);


function DialogForm($scope, $mdDialog, $http, Instance, table) {
    
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
			$scope.error =  response.data;            
		});
    };

    $scope.cancel = function() {
      $mdDialog.cancel();
    };

    
}

function DialogCities($scope, $mdDialog, $http, Instance, table) {
    
    $scope.Model = {};   
    $scope.FormData = [];

    $http({
        method: 'GET',
        params: { action: 'serlib_options_handler', table: 'states' },
        url:    back_obj.ajax_url
    }).then(function successCallback(response) {
        
        $scope.FormData = response.data;
        $scope.formInit()
    }, function errorCallback(response) {
        console.log('fallo cargando states', response);            
    });
    $scope.formInit = function(){
       
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
			$scope.error = 'fallo server: '+ response.data;            
		});
    };

    $scope.cancel = function() {
      $mdDialog.cancel();
    };

    
}