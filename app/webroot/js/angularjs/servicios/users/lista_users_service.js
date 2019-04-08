app.service('listaUsers', ["$http", function($http) {
	this.listaUsers = function(){
		var data = $http({
			method: 'GET',
			url: host+'users/lista_usuarios_json'
		});
		return data;
	};

	this.rolesUsuario = function(idUsuario){
		var data = $http({
			method: 'GET',
			params: {usuarioId :idUsuario},
			url: host+'users/roles_usuario'
		});
		return data;
	}; 

	this.getUser = function(idUsuario){
		var data = $http({
			method: 'GET',
			url: host+'users/edit_json/'+idUsuario
		});
		return data;
	}; 

	this.getRolesList = function(){
		var data = $http({
			method: 'GET',
			url: host+'roles/lista_roles_json'
		});
		return data;
	}; 
	
	this.addUserRol = function(idUsuario, idRoles){
		var data = $http({
			method: 'GET',
			params: {usuarioId :idUsuario, rolesId: idRoles},
			url: host+'users/add_roles_usuarios'
		});
		return data;
	};

	this.registrarUser = function(formulario){
		var data = $http({
			method: 'POST',
			url: host+'users/add_json',
			data: $.param(formulario)
		});		
		return data;
	};

	this.botonesPorPagina = function(idPagina){
		var data = $http({
			method: 'GET',
			params: {paginaId :idPagina},
			url: host+'paginas/lista_botones_json'
		});
		return data;
	};

	this.addBotonesPaginas = function(idBotones, idPagina, idRol){
		var data = $http({
			method: 'GET',
			params: {botonesId :idBotones, paginaId : idPagina, rolId: idRol},
			url: host+'paginas_botones/add'
		});
		return data;
	};

	this.deleteBotonesPaginas = function(idBotones, idPagina, idRol){
		var data = $http({
			method: 'GET',
			//cache: false,
			//replace: true,
			params: {botonesId :idBotones, paginaId : idPagina, rolId: idRol},
			url: host+'paginas_botones/delete'
		});
		return data;
	};

	this.botonesRol = function(idPagina, idRol){
		var data = $http({
			method: 'GET',
			//cache: false,
			//replace: true,
			params: {paginaId: idPagina, rolId: idRol},
			url: host+'paginas_botones/botones_roles'
		});
		return data;
	};

	this.delete = function(id){
		usuario = {
			User : {
				id : id,
				estado : 0
			}
		}
		return $http({
			method : "POST",
			url : host+"users/delete",
			data : $.param(usuario)
		});
	}
}]);
