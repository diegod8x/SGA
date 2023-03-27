app.controller("actividadesIndex", [
	"$scope",
	"$rootScope",
	"$http",
	"$filter",
	"$location",
	"uiGridConstants",
	"actividadesService",
	"Flash",
	"i18nService",
	function (
		$scope,
		$rootScope,
		$http,
		$filter,
		$location,
		uiGridConstants,
		actividadesService,
		Flash,
		i18nService
	) {
		$scope.loader = true;
		$scope.tablaDetalle = false;
		$scope.cargador = loader;
		$scope.langs = i18nService.getAllLangs();
		$scope.lang = "es";
		angular.element("#fechaInicio, #fechaTermino").datepicker({
			format: "yyyy-mm-dd",
			language: "es",
			multidate: false,
			autoclose: true,
			required: true,
			weekStart: 1,
			orientation: "auto",
		});
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
			exporterCsvFilename: "listado_actividades.csv",
			exporterCsvLinkElement: angular.element(
				document.querySelectorAll(".custom-csv-link-location")
			),
			onRegisterApi: function (gridApi) {
				$scope.gridApi = gridApi;
			},
		};
		$scope.getCellFilterDate = function () {
			return "date:'dd-MM-yyyy'";
		};
		$scope.gridOptions.columnDefs = [
			{ name: "id", displayName: "id", visible: false, minWidth: 110 },
			{
				name: "nombre_trabajador",
				displayName: "Trabajador Asignado",
				visible: false,
				minWidth: 110,
			},
			{ name: "fecha_ingreso", displayName: "Fecha Actividad", minWidth: 110 }, //, cellFilter: $scope.getCellFilterDate('{{row.getProperty(col.field)}}')
			{ name: "tipo_actividad", displayName: "Actividad", minWidth: 110 },
			{ name: "nombre_cliente", displayName: "Cliente", minWidth: 110 },
			{ name: "observaciones", displayName: "Observaciones", minWidth: 130 },
			{ name: "estado", displayName: "Estado", minWidth: 110 },
			{
				name: "comentarios",
				displayName: "Comentarios trabajador",
				minWidth: 120,
			},
			/*{
				name: "direccion_completa",
				displayName: "Dirección",
				visible: false,
				minWidth: 110,
			},
			{ name: "gps", displayName: "GPS", visible: false, minWidth: 110 },*/
		];
		$http.get(host + "actividades/listado_trabajador").success(function (data) {
			if (angular.isDefined(data[0])) {
				$scope.nombreTrabajador = data[0].nombre_trabajador;
			}
			$scope.loader = false;
			$scope.tablaDetalle = true;
			$scope.gridOptions.data = data;
			$scope.gridApi.selection.on.rowSelectionChanged($scope, function (row) {
				if (angular.isDefined(row.entity.id)) {
					if (row.entity.estado_actividade_id == 2) {
						$scope.btnactividadesedit_act = true;
					} else {
						$scope.btnactividadesedit_act = false;
					}

					$scope.btnactividadesadd = false;
					$scope.btnactividadesedit = false;
					$scope.boton = true;
					$scope.id = row.entity.id;
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
		});
		$scope.buscarActividades = function (fcInicio, fcTermino) {
			$scope.msgSinResultados = false;
			if (angular.isDefined(fcInicio) && angular.isDefined(fcTermino)) {
				actividadesService
					.getActividadeTrabajador(fcInicio, fcTermino)
					.success(function (datas) {
						if (datas.length > 0) {
							$scope.gridOptions.data = datas;
						} else {
							$scope.gridOptions.data = datas;
							$scope.msgSinResultados = true;
						}
						$scope.refreshData = function (termObj) {
							$scope.gridOptions.data = datas;
							while (termObj) {
								var oSearchArray = termObj.split(" ");
								$scope.gridOptions.data = $filter("filter")(
									$scope.gridOptions.data,
									oSearchArray[0],
									undefined
								);
								oSearchArray.shift();
								termObj =
									oSearchArray.length !== 0 ? oSearchArray.join(" ") : "";
							}
						};
					});
			}
		};
	},
]);

app.controller("actividadesConsolidado", [
	"$scope",
	"$rootScope",
	"$http",
	"$filter",
	"$location",
	"uiGridConstants",
	"actividadesService",
	"i18nService",
	function (
		$scope,
		$rootScope,
		$http,
		$filter,
		$location,
		uiGridConstants,
		actividadesService,
		i18nService
	) {
		$scope.loader = true;
		$scope.tablaDetalle = false;
		$scope.cargador = loader;
		$scope.langs = i18nService.getAllLangs();
		$scope.lang = "es";
		angular.element("#fechaInicio, #fechaTermino").datepicker({
			format: "yyyy-mm-dd",
			language: "es",
			multidate: false,
			autoclose: true,
			required: true,
			weekStart: 1,
			orientation: "auto",
		});
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
			exporterCsvFilename: "listado_consolidado.csv",
			exporterCsvLinkElement: angular.element(
				document.querySelectorAll(".custom-csv-link-location")
			),
			onRegisterApi: function (gridApi) {
				$scope.gridApi = gridApi;
			},
		};
		$scope.getCellFilterDate = function () {
			return "date:'dd-MM-yyyy'";
		};
		$scope.gridOptions.columnDefs = [
			{ name: "id", displayName: "id", visible: false, minWidth: 110 },
			{ name: "fecha_ingreso", displayName: "Fecha Actividad", minWidth: 110 }, //, cellFilter: $scope.getCellFilterDate('{{row.getProperty(col.field)}}')
			{
				name: "nombre_trabajador",
				displayName: "Trabajador Asignado",
				minWidth: 120,
			},
			{ name: "tipo_actividad", displayName: "Actividad", minWidth: 110 },
			{ name: "nombre_cliente", displayName: "Cliente", minWidth: 120 },
			{ name: "observaciones", displayName: "Observaciones", minWidth: 130 },
			{ name: "estado", displayName: "Estado", minWidth: 110 },
			{
				name: "comentarios",
				displayName: "Comentarios trabajador",
				minWidth: 110,
			},
			/*{
				name: "direccion_completa",
				displayName: "Dirección",
				visible: false,
				minWidth: 110,
			},*/
			//{ name: "gps", displayName: "GPS", visible: false, minWidth: 110 },
		];
		$http
			.get(host + "actividades/listado_consolidado")
			.success(function (data) {
				$scope.loader = false;
				$scope.tablaDetalle = true;
				$scope.gridOptions.data = data;
				$scope.gridApi.selection.on.rowSelectionChanged($scope, function (row) {
					if (angular.isDefined(row.entity.id)) {
						if (row.entity.estado_actividade_id == 2) {
							$scope.btnactividadesedit_act = true;
						} else {
							$scope.btnactividadesedit_act = false;
						}
						$scope.btnactividadesadd = false;
						$scope.btnactividadesedit = false;
						$scope.boton = true;
						$scope.id = row.entity.id;
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
			});

		$scope.buscarActividades = function (fcInicio, fcTermino) {
			$scope.msgSinResultados = false;
			if (angular.isDefined(fcInicio) && angular.isDefined(fcTermino)) {
				actividadesService
					.getActividadeConsolidado(fcInicio, fcTermino)
					.success(function (datas) {
						if (datas.length > 0) {
							$scope.gridOptions.data = datas;
						} else {
							$scope.gridOptions.data = datas;
							$scope.msgSinResultados = true;
						}
						$scope.refreshData = function (termObj) {
							$scope.gridOptions.data = datas;
							while (termObj) {
								var oSearchArray = termObj.split(" ");
								$scope.gridOptions.data = $filter("filter")(
									$scope.gridOptions.data,
									oSearchArray[0],
									undefined
								);
								oSearchArray.shift();
								termObj =
									oSearchArray.length !== 0 ? oSearchArray.join(" ") : "";
							}
						};
					});
			}
		};
	},
]);

app.controller(
	"actividadesAdd",
	function (
		$scope,
		$http,
		$q,
		actividadesService,
		serviciosService,
		clientesService,
		direccionesService,
		Flash,
		$filter,
		$window,
		$location,
		$rootScope,
		$anchorScroll,
		$timeout
	) {
		$scope.loader = true;
		$scope.cargador = loader;
		$scope.formActividades = false;
		$scope.limitTitleSearch = 200;
		$scope.disableCliente = false;
		$scope.checkTitle = function (lettersTyped) {
			if (lettersTyped.length > 2) {
				$scope.limitTitleSearch = 60;
			} else {
				$scope.limitTitleSearch = 0;
			}
		};

		angular.element("#fechaActividad").datepicker({
			format: "dd-mm-yyyy",
			language: "es",
			multidate: false,
			autoclose: true,
			required: true,
			weekStart: 1,
			orientation: "bottom auto",
		});

		$scope.obtDatos = function (idContrato, idCliente, productos) {
			var productosNuevos = $location.url().substr(1).split("/");
			if (productosNuevos.length > 0) {
				$scope.productosNuevos = {};
				angular.forEach(productosNuevos, function (valor, key) {
					$scope.productosNuevos[key] = valor;
				});
			}

			$scope.formulario = { Actividade: {} };
			const promesas = [];
			promesas.push(actividadesService.getData());
			promesas.push(clientesService.getCliente(idCliente, idContrato));
			$q.all(promesas).then(function (data) {
				$scope.clientes = data[0].data.Clientes;
				$scope.trabajadores = data[0].data.Trabajadore;
				const contratosArray = Object.values(data[0].data.ContratosCliente);
				$scope.tipoActividades = data[0].data.TipoActividade;
				$scope.loader = false;
				$scope.formActividades = true;

				if (idCliente && idContrato) {
					$scope.formulario.Actividade.contrato_id = idContrato;
					const cliente = data[1].data.data.Cliente;
					$scope.formulario.Actividade.cliente_id = {
						id: cliente.id,
						nombre: cliente.nombre,
					};
					$scope.disableCliente = true;
					const contrato = contratosArray.find(
						(obj) => obj.id === idContrato.toString()
					);
					$scope.formulario.Actividade.direccione_id = contrato.direccione_id;

					direccionesService
						.getDireccionPorClienteId(idCliente)
						.success(function (data) {
							$scope.direcciones = data;
						});
				} else {
					$scope.$watch(
						"formulario.Actividade.cliente_id",
						function (anterior, nuevo) {
							$scope.direcciones = [];
							if (angular.isDefined(anterior)) {
								direccionesService
									.getDireccionPorClienteId(anterior)
									.success(function (data) {
										$scope.direcciones = data;
									});
							}
						}
					);
				}
				$scope.$watch(
					"formulario.Actividade.fecha_ingreso",
					function (anterior, nuevo) {
						if (angular.isDefined(nuevo) && !angular.isDefined(anterior)) {
							angular.element("#fechaActividad").datepicker("setDate", nuevo);
						}
					}
				);
			});
		};

		$scope.getContratos = function (idCliente) {
			$scope.contratos = contratosList[idCliente];
		};
		$scope.obtComunas = function (id) {
			if (angular.isDefined(id)) {
				serviciosService.getComunas(id).success(function (data) {
					$scope.comunas = data;
				});
			} else {
				$scope.comunas = undefined;
				$scope.formulario.Actividade.comuna_id = undefined;
			}
		};
		$scope.registrarActividade = function () {
			$scope.deshabilita = true;
			if ($scope.formulario.Actividade.fecha_ingreso.split("-")[0].length == 2)
				$scope.formulario.Actividade.fecha_ingreso =
					$scope.formulario.Actividade.fecha_ingreso
						.split("-")
						.reverse()
						.join("-");

			$scope.formulario.productosNuevos = $scope.productosNuevos;

			actividadesService
				.registrarActividade($scope.formulario)
				.success(function (data) {
					if (data.estado == 1) {
						Flash.create("success", data.mensaje, "customAlert");
						$window.location = host + "actividades/consolidado";
					} else if (data.estado == 0) {
						Flash.create("danger", data.mensaje, "customAlert");
					}
				});
		};
	}
);

app.controller(
	"actividadesEdit",
	function (
		$q,
		$scope,
		$http,
		actividadesService,
		serviciosService,
		direccionesService,
		Flash,
		$filter,
		$window,
		$location,
		$rootScope,
		$anchorScroll
	) {
		$scope.formActividades = false;
		$scope.loader = true;
		$scope.cargador = loader;
		angular.element("#fechaActividad").datepicker({
			format: "dd-mm-yyyy",
			language: "es",
			multidate: false,
			autoclose: true,
			required: true,
			weekStart: 1,
			orientation: "bottom auto",
		});
		$scope.checkTitle = function (lettersTyped) {
			if (lettersTyped.length > 2) {
				$scope.limitTitleSearch = 60;
			} else {
				$scope.limitTitleSearch = 0;
			}
		};

		$scope.obtDatos = function (idActividad) {
			$scope.formulario = {};
			const promesas = [];
			promesas.push(actividadesService.getActividade(idActividad));
			promesas.push(actividadesService.getData());

			$q.all(promesas).then(function (data) {
				$scope.clientes = data[1].data.Clientes;
				$scope.trabajadores = data[1].data.Trabajadore;
				$scope.tipoActividades = data[1].data.TipoActividade;
				$scope.estadoActividades = data[1].data.EstadoActividade;
				$scope.formulario.Actividade = data[0].data.actividad;

				if ($scope.formulario.Actividade.cliente_id) {
					const cliente = $scope.clientes.find(
						(cli) => cli.id === $scope.formulario.Actividade.cliente_id
					);
					$scope.formulario.Actividade.cliente_id = {
						id: cliente.id,
						nombre: cliente.nombre,
					};
					direccionesService
						.getDireccionPorClienteId(cliente.id)
						.success(function (data) {
							$scope.direcciones = data;
						});
				}

				$scope.$watch(
					"formulario.Actividade.cliente_id",
					function (anterior, nuevo) {
						$scope.direcciones = [];
						if (angular.isDefined(anterior)) {
							if (anterior && typeof anterior === "object") {
								console.log(anterior)
								anterior = anterior.id;
								console.log(anterior)
							}
							direccionesService
								.getDireccionPorClienteId(anterior)
								.success(function (data) {
									$scope.direcciones = data;
								});
						}
					}
				);

				angular
					.element("#fechaActividad")
					.datepicker(
						"update",
						$filter("date")(data[0].data.actividad.fecha_ingreso, "dd-MM-yyyy")
					);

				if (
					angular.isDefined($scope.formulario.Actividade.regione_id) &&
					$scope.formulario.Actividade.regione_id != null
				) {
					$scope.obtComunas($scope.formulario.Actividade.regione_id);
				}
				$scope.loader = false;
				$scope.formActividades = true;
				$scope.$watch(
					"formulario.Actividade.fecha_ingreso",
					function (anterior, nuevo) {
						if (angular.isDefined(nuevo) && !angular.isDefined(anterior)) {
							angular.element("#fechaActividad").datepicker("setDate", nuevo);
						}
					}
				);
			});
		};

		$scope.getContratos = function (idCliente) {
			$scope.contratos = contratosList[idCliente];
		};

		$scope.obtComunas = function (id) {
			if (angular.isDefined(id)) {
				serviciosService.getComunas(id).success(function (data) {
					$scope.comunas = data;
				});
			} else {
				$scope.comunas = undefined;
				$scope.formulario.Actividade.comuna_id = undefined;
			}
		};

		$scope.registrarActividade = function () {
			$scope.deshabilita = true;
			if ($scope.formulario.Actividade.fecha_ingreso.split("-")[0].length == 2)
				$scope.formulario.Actividade.fecha_ingreso =
					$scope.formulario.Actividade.fecha_ingreso
						.split("-")
						.reverse()
						.join("-");

			actividadesService
				.registrarActividade($scope.formulario)
				.success(function (data) {
					console.log("data >>>>>", data)
					if (data.estado == 1) {
						Flash.create("success", data.mensaje, "customAlert");
						window.history.back();
					} else if (data.estado == 0) {
						Flash.create("danger", data.mensaje, "customAlert");
					}
					$scope.deshabilita = false;
				});
		};
	}
);
