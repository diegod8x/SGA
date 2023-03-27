app.service("actividadesService", [
	"$http",
	"$location",
	function ($http, $location) {
		this.getData = function () {
			return $http({
				method: "GET",
				url: host + "actividades/data_json/",
			});
		};
		this.registrarActividade = function (formulario) {
			return $http({
				method: "POST",
				url: host + "actividades/add_actividad",
				data: $.param(formulario),
			});
		};
		this.getActividade = function (id) {
			return $http({
				method: "GET",
				url: host + "actividades/edit_json/" + id,
			});
		};

		this.getActividadeTrabajador = function (fcInicio, fcTermino) {
			return $http({
				method: "GET",
				url:
					host + "actividades/listado_trabajador/" + fcInicio + "/" + fcTermino,
			});
		};

		this.getActividadeConsolidado = function (fcInicio, fcTermino) {
			return $http({
				method: "GET",
				url:
					host +
					"actividades/listado_consolidado/" +
					fcInicio +
					"/" +
					fcTermino,
			});
		};
	},
]);
