app.service('serviciosService', ["$http",'$location',  function($http, $location) {

	this.getRegiones = function(){
		var data = $http({
			method: 'POST',
			url: host+'servicios/regiones'
		});
		return data;
	};
	this.getComunas = function(id){
		var data = $http({
			method: 'POST',
			url: host+'servicios/comunas/'+id
		});
		return data;
	};
	this.validaRut = function(nmControlador,nrRut){
		var data = $http({
			method: 'GET',
			url: host+'servicios/valida_rut',
			params : { rut : nrRut, controlador: nmControlador }
		});		
		return data;
	};

}]);