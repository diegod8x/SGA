app.service('clientesService', ["$http",'$location',  function($http, $location) {
	this.registrarCliente = function(formulario){
		var data = $http({
			method: 'POST',
			url: host+'clientes/add_json',
			data: $.param(formulario)
		});		
		return data;
	};
	this.getCliente = function(id){
		var data = $http({
			method: 'GET',
			url: host+'clientes/edit_json/'+id
		});		
		return data;
	};
}]);