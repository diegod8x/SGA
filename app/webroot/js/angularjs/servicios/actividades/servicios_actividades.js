app.service('actividadesService', ["$http",'$location',  function($http, $location) {
    this.getData = function(){
        var data = $http({
            method: 'GET',
            url: host+'actividades/data_json/'
        });     
        return data;
    };
	this.registrarActividade = function(formulario){
		var data = $http({
			method: 'POST',
			url: host+'actividades/add_actividad',
			data: $.param(formulario)
		});
		return data;
	};
	this.getActividade = function(id){
		var data = $http({
			method: 'GET',
			url: host+'actividades/edit_json/'+id
		});
		return data;
	};
	
	this.getActividadeTrabajador = function(fcInicio,fcTermino){
		var data = $http({
			method: 'GET',
			url: host+'actividades/listado_trabajador/'+fcInicio+'/'+fcTermino
		});		
		return data;
	};

	this.getActividadeConsolidado = function(fcInicio,fcTermino){
		var data = $http({
			method: 'GET',
			url: host+'actividades/listado_consolidado/'+fcInicio+'/'+fcTermino
		});		
		return data;
	};
}]);