app.service('empresasService', ["$http",'$location',  function($http, $location) {
	this.registrarEmpresa = function(formulario){
		var data = $http({
			method: 'POST',
			url: host+'empresas/add_json',
			data: $.param(formulario)
		});		
		return data;
	};
	this.getEmpresa = function(id){
		var data = $http({
			method: 'GET',
			url: host+'empresas/edit_json/'+id
		});		
		return data;
	};
	this.getEmpresaList = function(){
		var data = $http({
			method: 'GET',
			url: host+'empresas/listado_empresas/'
		});		
		return data;
	};
}]);