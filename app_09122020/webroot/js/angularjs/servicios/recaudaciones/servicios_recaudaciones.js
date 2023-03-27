app.service('recaudacioneService', ["$http",'$location',  function($http, $location) {
    this.getCobros = function(){
        var data = $http({
            method: 'GET',
            url: host+'recaudaciones/index_json/'
        }); 
        return data;
    };
    this.registrarPagos = function(formulario){
        var data = $http({
            method: 'POST',
            url: host+'recaudaciones/registrar_pagos',
            data: $.param(formulario)
        });
        return data;
    };
}]);