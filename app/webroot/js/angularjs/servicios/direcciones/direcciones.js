app.service("direccionesService", [
	"$http",
	"$location",
	function ($http, $location) {
		this.registrarDireccion = function (formulario) {
			return $http({
				method: "POST",
				url: host + "direcciones/add_json",
				data: $.param(formulario),
			});
		};
		this.getDireccion = function (id) {
			var data = $http({
				method: "GET",
				url: host + "direcciones/edit_json/" + id,
			});
			return data;
		};
		this.getDireccionList = function () {
			var data = $http({
				method: "GET",
				url: host + "direcciones/listado_direcciones/",
			});
			return data;
		};
		this.getDireccionPorClienteId = function (cliente_id) {
			var data = $http({
				method: "GET",
				url: host + "direcciones/cliente_json/" + cliente_id,
			});
			return data;
		};
	},
]);
