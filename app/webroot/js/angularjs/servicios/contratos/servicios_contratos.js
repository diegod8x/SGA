app.service("contratosService", [
	"$http",
	"$location",
	function ($http, $location) {
		this.registrarContrato = function (formulario) {
			var data = $http({
				method: "POST",
				url: host + "contratos/add_json",
				data: $.param(formulario),
			});
			return data;
		};
		this.getContrato = function (id) {
			var data = $http({
				method: "GET",
				url: host + "contratos/edit_json/" + id,
			});
			return data;
		};
		this.getContratoRut = function (rut) {
			var data = $http({
				method: "GET",
				url: host + "contratos/reporte_clientes_json/" + rut,
			});
			return data;
		};
		this.getContratoList = function () {
			var data = $http({
				method: "GET",
				url: host + "contratos/listado_contratos/",
			});
			return data;
		};

		this.getData = function () {
			var data = $http({
				method: "GET",
				url: host + "contratos/data_json/",
			});
			return data;
		};
		this.correoCliente = function (idContrato) {
			console.log("idContrato", idContrato);
			var data = $http({
				method: "POST",
				url: host + "contratos/enviar_correo_cliente/" + idContrato.Contrato.id,
				data: $.param(idContrato),
			});
			return data;
		};
	},
]);
