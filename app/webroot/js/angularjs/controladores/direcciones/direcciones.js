/* eslint-disable no-undef */
app.controller("direccionesIndex", [
	"$scope",
	"$rootScope",
	"$http",
	"$filter",
	"$location",
	"uiGridConstants",
	"i18nService",
	function (
		$scope,
		$rootScope,
		$http,
		$filter,
		$location,
		uiGridConstants,
		i18nService
	) {
		$scope.loader = true;
		$scope.tablaDetalle = false;
		// @ts-ignore
		$scope.cargador = loader;
		$scope.langs = i18nService.getAllLangs();
		$scope.lang = "es";
		$scope.gridOptions = {
			enableFiltering: false,
			useExternalFiltering: true,
			flatEntityAccess: true,
			showGridFooter: true,
			enableRowSelection: true,
			enableRowHeaderSelection: true,
			multiSelect: false,
			enableSorting: true,
			enableGridMenu: true,
			exporterCsvColumnSeparator: ";",
			exporterMenuPdf: false,
			exporterCsvFilename: "listado_direcciones.csv",
			// @ts-ignore
			exporterCsvLinkElement: angular.element(
				document.querySelectorAll(".custom-csv-link-location")
			),
			onRegisterApi: function (gridApi) {
				$scope.gridApi = gridApi;
			},
		};

		$scope.gridOptions.columnDefs = [
			{ name: "id", displayName: "id", visible: false, minWidth: 110 },
			{ name: "cliente", minWidth: 110 },
			{ name: "rut", minWidth: 110 },
			{ name: "direccion", displayName: "Dirección", minWidth: 110 },
			{ name: "comuna", minWidth: 110 },
			{ name: "region", displayName: "Región", minWidth: 110 },
			{ name: "estado", minWidth: 110 },
		];

		// $scope.obtData = function (id) {
		// let clienteId;
		// clienteId = id;

		$http
			.get(host + "direcciones/listado_direcciones")
			.success(function (data) {
				$scope.loader = false;
				$scope.tablaDetalle = true;
				$scope.gridOptions.data = data;
				// let cliente;
				// if (clienteId) {
				// 	cliente = data.find((cli) => cli.cliente_id == clienteId);
				// }
				$scope.gridApi.selection.on.rowSelectionChanged($scope, function (row) {
					if (row.isSelected) {
						$scope.btndireccionesadd = false;
						$scope.btndireccionesedit = false;
						$scope.boton = true;
						$scope.id = row.entity.id;
					} else {
						$scope.btndireccionesedit = true;
						$scope.boton = false;
						$scope.id = false;
					}
				});

				$scope.refreshData = function (termObj) {
					$scope.gridOptions.data = data;
					while (termObj) {
						var oSearchArray = termObj.split(" ");
						$scope.gridOptions.data = $filter("filter")(
							$scope.gridOptions.data,
							oSearchArray[0],
							undefined
						);
						oSearchArray.shift();
						termObj = oSearchArray.length !== 0 ? oSearchArray.join(" ") : "";
					}
				};
				// if (cliente) {
				// 	console.log(cliente, window.location.href);
				// 	const url = window.location.href.split("/");
				// 	const path = url.slice(0, -2).join("/");
				// 	$scope.refreshData(cliente.rut);
				// 	console.log(path);
				// }
			});
		// };
	},
]);

// @ts-ignore
// eslint-disable-next-line no-undef
app.controller(
	"direccionesAdd",
	function (
		$scope,
		$http,
		direccionesService,
		serviciosService,
		clientesService,
		Flash,
		$filter,
		$window,
		$location,
		$rootScope,
		$anchorScroll,
		RutHelper,
		$q
	) {
		$scope.loader = true;
		// @ts-ignore
		$scope.cargador = loader;
		$scope.formDirecciones = false;
		$scope.limitTitleSearch = 200;
		$scope.formulario = { Direccione: { cliente_id: undefined } };
		$scope.checkTitle = function (lettersTyped) {
			if (lettersTyped.length > 2) {
				$scope.limitTitleSearch = 60;
			} else {
				$scope.limitTitleSearch = 0;
			}
		};

		$scope.obtData = function (cliente_id) {
			$q.all([
				serviciosService.getRegiones(),
				clientesService.getClientes(),
			]).then(function (data) {
				$scope.regiones = data[0].data;
				$scope.clientes = data[1].data;
				if (cliente_id) {
					const obj1 = $scope.clientes.find(
						(obj) => obj.id === cliente_id.toString()
					);
					$scope.formulario.Direccione.cliente_id = {
						id: obj1.id,
						nombre: obj1.nombre,
					};
				}

				$scope.loader = false;
				$scope.formDirecciones = true;
			});
		};
		$scope.obtComunas = function (id) {
			// @ts-ignore
			if (angular.isDefined(id)) {
				serviciosService.getComunas(id).success(function (data) {
					$scope.comunas = data;
				});
			} else {
				$scope.comunas = undefined;
				$scope.formulario.Direccione.comuna_id = undefined;
			}
		};
		$scope.$watch("formulario.Direccione.regione_id", function (anterior) {
			// @ts-ignore
			if (angular.isDefined(anterior)) {
				$scope.obtComunas(anterior);
				$scope.formulario.Direccione.comuna_id = undefined;
			}
		});
		$scope.registrarDireccion = function () {
			$scope.deshabilita = true;
			direccionesService
				.registrarDireccion($scope.formulario)
				.success(function (data) {
					if (data.estado == 1) {
						Flash.create("success", data.mensaje, "customAlert");
						// @ts-ignore
						$window.location = host + "direcciones";
					} else if (data.estado == 0) {
						Flash.create("danger", data.mensaje, "customAlert");
					}
				});
		};
	}
);

// @ts-ignore
app.controller(
	"direccionesEdit",
	function (
		$scope,
		$q,
		$http,
		direccionesService,
		serviciosService,
		clientesService,
		Flash,
		$filter,
		$window,
		$location,
		$rootScope,
		$anchorScroll,
		RutHelper
	) {
		$scope.loader = true;
		// @ts-ignore
		$scope.cargador = loader;
		$scope.formDirecciones = false;
		$scope.formulario = {};
		$scope.estados = [
			{ id: 0, nombre: "INACTIVO" },
			{ id: 1, nombre: "ACTIVO" },
		];
		$scope.checkTitle = function (lettersTyped) {
			if (lettersTyped.length > 2) {
				$scope.limitTitleSearch = 60;
			} else {
				$scope.limitTitleSearch = 0;
			}
		};
		$scope.obtData = (id) => {
			$q.all([
				serviciosService.getRegiones(),
				clientesService.getClientes(),
				direccionesService.getDireccion(id),
			]).then(function (data) {
				$scope.regiones = data[0].data;
				$scope.clientes = data[1].data;
				if (data[2].data.estado) {
					serviciosService
						.getComunas(data[2].data.data.Direccione.regione_id)
						.then((comunas) => {
							$scope.comunas = comunas.data;
							$scope.formulario.Direccione = data[2].data.data.Direccione;
							$scope.loader = false;
							$scope.formDirecciones = true;
						});
				} else {
					Flash.create("danger", data[2].data.mensaje, "customAlert");
					setTimeout(function () {
						// @ts-ignore
						$window.location = host + "direcciones";
					}, 1500);
				}
			});
		};

		$scope.obtComunas = function (id) {
			// @ts-ignore
			if (angular.isDefined(id)) {
				serviciosService.getComunas(id).success(function (data) {
					$scope.comunas = data;
				});
			} else {
				$scope.comunas = undefined;
				$scope.formulario.Direccione.comuna_id = undefined;
			}
		};
		$scope.registrarDireccion = function () {
			$scope.deshabilita = true;
			direccionesService
				.registrarDireccion($scope.formulario)
				.success(function (data) {
					if (data.estado == 1) {
						Flash.create("success", data.mensaje, "customAlert");
						// @ts-ignore
						$window.location = host + "direcciones";
					} else if (data.estado == 0) {
						Flash.create("danger", data.mensaje, "customAlert");
					}
				});
		};
	}
);
