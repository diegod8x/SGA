app.service('listaRoles', ["$http", function($http) {
	this.listaRoles = function(){
		var data = $http({
			method: 'GET',
			url: host+'roles/lista_roles_json'
		});
		return data;
	};

	this.delete = function (id){
		return $http({
			method: "POST",
			url: host+"roles/delete",
			data: $.param({ id: id})
		});
	}
}]);