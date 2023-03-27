app.service('listaRolesNombres', ["$http", function($http) {
	this.listaRolesNombres = function(id){
		var data = $http({
			method: 'GET',
			params: { idRoles:id },
			url: host+'roles/lista_roles_nombres_json'
		});
		return data;
	};
}]);