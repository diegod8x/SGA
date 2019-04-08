app.service('listaPaginas', ["$http", function($http) {
	this.listaPaginas = function(){
		var data = $http({
			method: 'GET',
			url: host+'paginas/lista_paginas_json'
		});
		return data;
	};
}]);