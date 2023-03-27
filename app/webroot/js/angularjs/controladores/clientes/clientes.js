app.controller("clientesIndex", [
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
			exporterCsvFilename: "listado_clientes.csv",
			exporterCsvLinkElement: angular.element(
				document.querySelectorAll(".custom-csv-link-location")
			),
			onRegisterApi: function (gridApi) {
				$scope.gridApi = gridApi;
			},
		};
		$scope.gridOptions.columnDefs = [
			{ name: "id", displayName: "id", visible: false, minWidth: 110 },
			{ name: "rut", displayName: "Rut", minWidth: 75 },
			{ name: "nombre", displayName: "Nombre Cliente", minWidth: 130 },
			{ name: "tipo_contrato", displayName: "Contrato", minWidth: 110 },
			{ name: "nombre_empresa", displayName: "Empresa", minWidth: 110 },
			{ name: "telefono", displayName: "Teléfono", minWidth: 110 },
			{ name: "email", displayName: "Email", visible: false, minWidth: 90 },
			{ name: "observaciones", minWidth: 110 },
		];
		$scope.confirmacion = function () {
			window.location.href = host + "clientes/delete/" + $scope.id;
		};

		$http.get(host + "clientes/listado_clientes").success(function (data) {
			$scope.loader = false;
			$scope.tablaDetalle = true;
			$scope.gridOptions.data = data;
			$scope.gridApi.selection.on.rowSelectionChanged($scope, function (row) {
				if (angular.isDefined(row.entity.id)) {
					$scope.btnclientesview = false;
					$scope.btnclientesedit = false;
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
	},
]);

app.controller(
	"clientesAdd",
	function (
		$scope,
		$http,
		clientesService,
		empresasService,
		serviciosService,
		Flash,
		$filter,
		$window,
		$location,
		$rootScope,
		$anchorScroll,
		RutHelper
	) {
		$scope.loader = true;
		$scope.cargador = loader;
		$scope.formClientes = false;
		$scope.obtDatos = function () {
			$scope.formulario = { Cliente: { Direccione: {} } };
			promesas = function () {
				empresasService.getEmpresaList().success(function (data) {
					$scope.empresas = data;
				});
				serviciosService.getRegiones().success(function (data) {
					$scope.regiones = data;
				});
			};
			promesas();
			$scope.loader = false;
			$scope.formClientes = true;
		};
		$scope.obtComunas = function (id) {
			if (angular.isDefined(id)) {
				serviciosService.getComunas(id).success(function (data) {
					$scope.comunas = data;
				});
			} else {
				$scope.comunas = undefined;
				$scope.formulario.Cliente.comuna_id = undefined;
			}
		};
		$scope.registrarCliente = function () {
			$scope.deshabilita = true;
			$scope.formulario.Cliente.rut = RutHelper.format(
				$scope.formulario.Cliente.rut
			);
			clientesService
				.registrarCliente($scope.formulario)
				.success(function (data) {
					if (data.estado == 1) {
						Flash.create("success", data.mensaje, "customAlert");
						$window.location = host + "clientes";
					} else if (data.estado == 0) {
						Flash.create("danger", data.mensaje, "customAlert");
					}
				});
		};
		$scope.validaRut = function () {
			if (angular.isDefined($scope.formulario.Cliente.rut)) {
				$scope.formulario.Cliente.rut = RutHelper.format(
					$scope.formulario.Cliente.rut
				);
				serviciosService
					.validaRut("Cliente", $scope.formulario.Cliente.rut)
					.success(function (data) {
						if (data.estado == 1) {
							angular.element("#clientesRut").focus();
							$scope.formulario.Cliente.rut = undefined;
							Flash.create("danger", data.mensaje, "customAlert");
						}
					});
			}
		};
		$scope.$watch(
			"formulario.Cliente.Direccione.nombre",
			function (valor, nuevo) {
				if (!angular.isDefined(valor) || valor === "") {
					$scope.formulario.Cliente.Direccione = {};
				}
			}
		);
	}
);

app.controller(
	"clientesEdit",
	function (
		$scope,
		$http,
		clientesService,
		empresasService,
		serviciosService,
		Flash,
		$filter,
		$window,
		$location,
		$rootScope,
		$anchorScroll,
		RutHelper
	) {
		$scope.loader = true;
		$scope.cargador = loader;
		$scope.formClientes = false;

		$scope.formulario = { Cliente: {} };
		var rutOriginal;
		$scope.obtDatos = function (idCliente) {
			clientesService.getCliente(idCliente).success(function (data) {
				empresasService.getEmpresaList().success(function (dataEmp) {
					$scope.empresas = dataEmp;
				});
				//$scope.obtRegiones();
				//$scope.obtComunas(data.Regione.id);
				$scope.formulario = data.data;
				rutOriginal = $scope.formulario.Cliente.rut;
				$scope.loader = false;
				$scope.formClientes = true;
			});
		};
		/*$scope.obtRegiones = function () {
			serviciosService.getRegiones().success(function (data) {
				$scope.regiones = data;
				$scope.loader = false;
				$scope.formClientes = true;
			});
		};
		$scope.obtComunas = function (id) {
			if (angular.isDefined(id)) {
				serviciosService.getComunas(id).success(function (data) {
					$scope.comunas = data;
				});
			} else {
				$scope.comunas = undefined;
				$scope.formulario.Cliente.comuna_id = undefined;
			}
		};*/
		$scope.registrarCliente = function () {
			$scope.deshabilita = true;
			$scope.formulario.Cliente.rut = RutHelper.format(
				$scope.formulario.Cliente.rut
			);
			clientesService
				.registrarCliente($scope.formulario)
				.success(function (data) {
					if (data.estado == 1) {
						Flash.create("success", data.mensaje, "customAlert");
						$window.location = host + "clientes";
					} else if (data.estado == 0) {
						Flash.create("danger", data.mensaje, "customAlert");
					}
				});
		};
		$scope.validaRut = function () {
			if (angular.isDefined($scope.formulario.Cliente.rut)) {
				$scope.formulario.Cliente.rut = RutHelper.format(
					$scope.formulario.Cliente.rut
				);
				if ($scope.formulario.Cliente.rut != rutOriginal) {
					serviciosService
						.validaRut("Cliente", $scope.formulario.Cliente.rut)
						.success(function (data) {
							if (data.estado == 1) {
								angular.element("#clientesRut").focus();
								$scope.formulario.Cliente.rut = undefined;
								Flash.create("danger", data.mensaje, "customAlert");
							}
						});
				}
			}
		};
	}
);

app.controller("reporteClientes", [
	"$scope",
	"$rootScope",
	"$http",
	"$filter",
	"$location",
	"uiGridConstants",
	"i18nService",
	"clientesService",
	"RutHelper",
	"serviciosService",
	"Flash",
	function (
		$scope,
		$rootScope,
		$http,
		$filter,
		$location,
		uiGridConstants,
		i18nService,
		clientesService,
		RutHelper,
		serviciosService,
		Flash
	) {
		$scope.loader = true;
		$scope.tablaDetalle = false;

		$scope.cargador = loader;
		$scope.langs = i18nService.getAllLangs();
		$scope.lang = "es";
		//contratos x cliente
		$scope.gridOptionsContratos = {
			enableFiltering: true,
			//useExternalFiltering: true,
			flatEntityAccess: true,
			showGridFooter: true,
			enableRowSelection: true,
			enableRowHeaderSelection: true,
			multiSelect: false,
			enableSorting: true,
			enableGridMenu: true,
			exporterCsvColumnSeparator: ";",
			exporterMenuPdf: false,
			exporterCsvFilename: "contratos.csv",
			exporterCsvLinkElement: angular.element(
				document.querySelectorAll(".custom-csv-link-location")
			),
			onRegisterApi: function (gridApi) {
				$scope.gridApi = gridApi;
			},
			columnDefs: [
				{
					name: "id",
					displayName: "#",
					width: 50,
					sort: {
						direction: uiGridConstants.ASC,
						priority: 1,
					},
				},
				{
					name: "ds_estado",
					displayName: "Estado",
					sort: {
						direction: uiGridConstants.DESC,
						priority: 0,
					},
				},
				{ name: "tipo_contrato", displayName: "Tipo", minWidth: 110 },
				{ name: "fecha_inicio", displayName: "Fecha inicio" },
				{ name: "fecha_termino", displayName: "Fecha término" },
				{
					name: "fecha_cobro",
					displayName: "Día cobro",
					cellTemplate:
						'<div style="text-align:center;"  class="ngCellText">{{row.entity.fecha_cobro | number:0}}</div>',
				},
				{
					name: "cantidad_productos",
					displayName: "Cant. Productos",
					cellTemplate:
						'<div style="text-align:center;"  class="ngCellText">{{row.entity.cantidad_productos | number:0}}</div>',
				},
				{
					name: "subtotal",
					displayName: "Precio",
					cellTemplate:
						'<div style="text-align:right;"  class="ngCellText">{{row.entity.subtotal | number:0}}</div>',
				},
				{
					name: "descuento",
					displayName: "Descuento",
					cellTemplate:
						'<div style="text-align:right;"  class="ngCellText">{{row.entity.descuento | number:0}}</div>',
				},
				{
					name: "garantia",
					displayName: "Garantía",
					cellTemplate:
						'<div style="text-align:right;"  class="ngCellText">{{row.entity.garantia | number:0}}</div>',
				},
				{
					name: "costo_despacho",
					displayName: "Despacho",
					cellTemplate:
						'<div style="text-align:right;"  class="ngCellText">{{row.entity.costo_despacho | number:0}}</div>',
				},
				{
					name: "precio_total",
					displayName: "Total",
					cellTemplate:
						'<div style="text-align:right;"  class="ngCellText">{{row.entity.precio_total | number:0}}</div>',
				},
				{ name: "ds_usuario_crea", displayName: "Creado por" },
				{ name: "created", displayName: "Fecha creación" },
				{ name: "ds_usuario_mod", displayName: "Modificado por" },
				{ name: "modified", displayName: "Fecha modificación" },
			],
		};
		//productos x cliente
		$scope.gridOptionsProductos = {
			enableFiltering: true,
			useExternalFiltering: false,
			flatEntityAccess: true,
			showGridFooter: true,
			enableRowSelection: true,
			enableRowHeaderSelection: true,
			multiSelect: false,
			enableSorting: true,
			enableGridMenu: true,
			exporterCsvColumnSeparator: ";",
			exporterMenuPdf: false,
			exporterCsvFilename: "productos.csv",
			exporterCsvLinkElement: angular.element(
				document.querySelectorAll(".custom-csv-link-location")
			),
			onRegisterApi: function (gridApi) {
				$scope.gridApi = gridApi;
			},
			columnDefs: [
				{
					name: "contrato_id",
					displayName: "# Contrato",
					minWidth: 80,
					sort: {
						direction: uiGridConstants.ASC,
						priority: 1,
					},
				},
				{
					name: "ds_estado",
					displayName: "Estado",
					minWidth: 90,
					sort: {
						direction: uiGridConstants.DESC,
						priority: 0,
					},
				},
				{ name: "nombre", displayName: "Nombre", minWidth: 150 },
				{ name: "observaciones", displayName: "Observaciones", minWidth: 110 },
				{
					name: "precio_arriendo",
					displayName: "Precio Arriendo",
					minWidth: 110,
				},
				{ name: "precio_venta", displayName: "Precio Venta", minWidth: 110 },
				{ name: "subtotal", displayName: "Subtotal", minWidth: 110 },
			],
		};
		//pagos x cliente
		$scope.gridOptionsPagos = {
			enableFiltering: true,
			useExternalFiltering: false,
			flatEntityAccess: true,
			showGridFooter: true,
			enableRowSelection: true,
			enableRowHeaderSelection: true,
			multiSelect: false,
			enableSorting: true,
			enableGridMenu: true,
			exporterCsvColumnSeparator: ";",
			exporterMenuPdf: false,
			exporterCsvFilename: "listado_clientes.csv",
			exporterCsvLinkElement: angular.element(
				document.querySelectorAll(".custom-csv-link-location")
			),
			onRegisterApi: function (gridApi) {
				$scope.gridApi = gridApi;
			},
			columnDefs: [
				{ name: "contrato_id", displayName: "# Contrato", minWidth: 110 },
				{ name: "mes_cobro", displayName: "Mes cobro", minWidth: 110 },
				{
					name: "ds_estado",
					displayName: "Estado",
					minWidth: 110,
					cellClass: function (grid, row, col, rowRenderIndex, colRenderIndex) {
						return grid.getCellValue(row, col) == "Pagado"
							? "angular_aprobado_s"
							: "angular_pendiente_g";
					},
				},

				{ name: "fecha_cobro", displayName: "Fecha cobro", minWidth: 130 },
				{ name: "fecha_pago", displayName: "Fecha pago", minWidth: 110 },
				{
					name: "tipo_documento",
					displayName: "Tipo documento",
					minWidth: 110,
				},
				{ name: "nro_documento", displayName: "Nro. documento", minWidth: 110 },

				{
					name: "subtotal",
					displayName: "Subtotal",
					visible: false,
					minWidth: 110,
				},
				{
					name: "descuento",
					displayName: "Descuento",
					visible: false,
					minWidth: 110,
				},
				{
					name: "despacho",
					displayName: "Despacho",
					visible: false,
					minWidth: 110,
				},

				{ name: "total_cobrado", displayName: "Monto cobrado", minWidth: 110 },
				{ name: "total_pagado", displayName: "Monto pagado", minWidth: 110 },
			],
		};

		$scope.loader = false;
		$scope.tablaDetalle = true;
		$scope.clientesRut = "";
		$scope.formulario = {};

		$scope.buscarCliente = function () {
			$scope.formulario = {};
			$scope.gridOptionsContratos.data = [];
			$scope.gridOptionsProductos.data = [];
			$scope.gridOptionsPagos.data = [];
			$scope.validaRut($scope.clientesRut);

			if (angular.isDefined($scope.clientesRut)) {
				clientesService
					.getClienteRut($scope.clientesRut)
					.success(function (data) {
						if (data.error) {
							Flash.create("danger", data.error, "customAlert");
						} else {
							console.log("data", data);
							$scope.formulario = data;
							$scope.gridOptionsContratos.data = data.Contrato;
							$scope.gridOptionsProductos.data = data.Producto;
							$scope.gridOptionsPagos.data = data.PagosCobro;
						}
					});
			}

			$scope.loader = false;
			$scope.tablaDetalle = true;
		};

		$scope.validaRut = function () {
			console.log("entra");
			if (angular.isDefined($scope.clientesRut)) {
				$scope.clientesRut = RutHelper.format($scope.clientesRut);
			}
		};
	},
]);
