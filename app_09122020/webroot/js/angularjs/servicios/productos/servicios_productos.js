app.service('productosService', ["$http",'$location',  function($http, $location) {
    this.registrarProducto = function(formulario){
        var data = $http({
            method: 'POST',
            url: host+'productos/add_json',
            data: $.param(formulario)
        });     
        return data;
    };
    this.getProducto = function(id){
        var data = $http({
            method: 'GET',
            url: host+'productos/edit_json/'+id
        });     
        return data;
    };
}]);