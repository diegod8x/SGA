app.service("clientesService", [
	"$http",
	"$location",
	function ($http, $location) {
		this.registrarCliente = function (formulario) {
			return $http({
				method: "POST",
				url: host + "clientes/add_json",
				data: $.param(formulario),
			});
		};
		this.getCliente = function (id, contratoId = null) {
			return $http({
				method: "GET",
				//url: host+'clientes/edit_json/'+id
				url: `${host}/clientes/edit_json/${id}/${contratoId}`,
			});
		};
		this.getClientes = function () {
			return $http({
				method: "GET",
				url: host + "clientes/listado_clientes",
			});
		};
		this.getClienteRut = function (rut) {
			return $http({
				method: "GET",
				url: host + "clientes/reporte_json/" + rut,
			});
		};
	},
]);
