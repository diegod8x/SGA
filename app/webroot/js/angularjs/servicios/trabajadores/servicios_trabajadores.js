app.service('trabajadoresService', ["$http",'$location',  function($http, $location) {
	this.registrarTrabajadore = function(formulario){
		var data = $http({
			method: 'POST',
			url: host+'trabajadores/add_json',
			data: $.param(formulario)
		});		
		return data;
	};
	this.getTrabajadore = function(id){
		var data = $http({
			method: 'GET',
			url: host+'trabajadores/edit_json/'+id
		});		
		return data;
	};
	this.getTrabajadoreList = function(){
		var data = $http({
			method: 'GET',
			url: host+'trabajadores/listado_trabajadores/'
		});		
		return data;
	};

}]);