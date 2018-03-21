(function () {
    'use strict';
    
    angular.module('app.almacen')
    .controller('IndexCtrl',['$scope','$http','$uibModal',IndexCtrl])
    .controller('InputCtrl',['$scope','$http',InputCtrl]);
    
    function InputCtrl($scope,$http)
    {
        
    }
    
    function IndexCtrl($scope,$http,$uibModal)
    {
        $scope.productos = productos;
        $scope.open_add  = function()
        {
             var modalInstance = $uibModal.open({
                            animation: $scope.animationsEnabled,
                            templateUrl: 'modalAdd.html',
                            controller: 'InputCtrl',
                  
                            resolve: {
                                 //user: function () {
                                   // return user;
                                 //}
                            }
                      });
        }
    }
    
})();