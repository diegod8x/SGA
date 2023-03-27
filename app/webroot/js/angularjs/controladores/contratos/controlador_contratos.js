app.controller("contratosIndex", [
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
			exporterCsvFilename: "listado_contratos.csv",
			exporterCsvLinkElement: angular.element(
				document.querySelectorAll(".custom-csv-link-location")
			),
			onRegisterApi: function (gridApi) {
				$scope.gridApi = gridApi;
				//$scope.$apply();
			},
		};

		$scope.gridOptions.columnDefs = [
			{ name: "id", displayName: "#", width: 70 },
			{ name: "tipo_contrato", displayName: "Contrato", minWidth: 90 },
			{ name: "ds_estado", displayName: "Estado", minWidth: 80 },
			{ name: "nombre_cliente", displayName: "Cliente", minWidth: 110 },
			{
				name: "cantidad_productos",
				displayName: "Cant. Productos",
				cellTemplate:
					'<div style="text-align:center;"  class="ngCellText">{{row.entity.cantidad_productos}}</div>',
				minWidth: 110,
			},
			{
				name: "subtotal",
				displayName: "Mensualidad",
				cellTemplate:
					'<div style="text-align:right;"  class="ngCellText">{{row.entity.subtotal | number:0}}</div>',
				minWidth: 110,
			},
			{
				name: "descuento",
				displayName: "Descuento -",
				cellTemplate:
					'<div style="text-align:right;"  class="ngCellText">{{row.entity.descuento | number:0}}</div>',
				minWidth: 110,
			},
			{
				name: "garantia",
				displayName: "Garantía",
				cellTemplate:
					'<div style="text-align:right;"  class="ngCellText">{{row.entity.garantia | number:0}}</div>',
				minWidth: 110,
			},
			{
				name: "costo_despacho",
				displayName: "Despacho",
				cellTemplate:
					'<div style="text-align:right;"  class="ngCellText">{{row.entity.costo_despacho | number:0}}</div>',
				minWidth: 110,
			},
			{
				name: "precio_total",
				displayName: "Total",
				cellTemplate:
					'<div style="text-align:right;"  class="ngCellText">{{row.entity.precio_total | number:0}}</div>',
				minWidth: 110,
			},
		];

		$http.get(host + "contratos/listado_contratos").success(function (data) {
			$scope.loader = false;
			$scope.tablaDetalle = true;
			$scope.gridOptions.data = data;
			$scope.gridApi.selection.on.rowSelectionChanged($scope, function (row) {
				console.log("#", row, row.entity.id);
				if (angular.isDefined(row.entity.id)) {
					if (row.entity.contrato_id == 1 && row.entity.estado == 1) {
						$scope.btncontratosview = false;
						$scope.btncontratosedit = false;
						$scope.btncontratosasigna_act = false;
						$scope.boton = true;
						$scope.id = row.entity.id + "/" + row.entity.cliente_id;
					} else {
						$scope.btncontratosview = false;
						$scope.btncontratosasigna_act = false;
						$scope.btncontratosedit = true;
						$scope.boton = true;
						$scope.id = row.entity.id + "/" + row.entity.cliente_id;
					}
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
	"contratosAdd",
	function (
		$scope,
		$http,
		contratosService,
		serviciosService,
		productosService,
		direccionesService,
		Flash,
		$filter,
		$window,
		$location,
		$rootScope,
		$anchorScroll
	) {
		console.log("entraaaaaa  ADD");
		$scope.loader = true;
		$scope.cargador = loader;
		$scope.formContratos = false;

		$scope.limitTitleSearch = 200;
		$scope.checkTitle = function (lettersTyped) {
			if (lettersTyped.length > 2) {
				$scope.limitTitleSearch = 60;
			} else {
				$scope.limitTitleSearch = 0;
			}
		};

		angular.element("#fechaInicio").datepicker({
			format: "dd-mm-yyyy",
			language: "es",
			multidate: false,
			autoclose: true,
			required: true,
			weekStart: 1,
			orientation: "auto",
		});
		$scope.obtDatos = function () {
			//var Contrato;
			$scope.numeroCuota = 1;
			$scope.formulario = { Contrato: {} };
			$scope.formulario.ContratosProducto = [];
			$scope.formulario.Contrato.cantidad_productos = 0;
			$scope.formulario.Contrato.subtotal = 0;
			$scope.formulario.Contrato.descuento = 0;
			$scope.formulario.Contrato.garantia = 0;
			$scope.formulario.Contrato.costo_despacho = 0;
			$scope.formulario.Contrato.precio_total = 0;

			contratosService.getData().success(function (data) {
				//console.log(data);
				$scope.clientes = data.clientes;
				$scope.cuotas = data.cuotas;
				$scope.direcciones = [];

				$scope.tipo_contratos = data.tipo_contrato;
				$scope.productos = data.productos;
				angular
					.element("#fechaInicio")
					.datepicker("setDate", data.fecha_inicio);
				$scope.formulario.Contrato.fecha_cobro = data.fecha_cobro;
				$scope.loader = false;
				$scope.formContratos = true;
				$scope.showCuotas = false;
			});

			$scope.$watch("formulario.Contrato.tipo_contrato_id", function () {
				if ($scope.formulario.Contrato.tipo_contrato_id == 1) {
					$scope.arriendo = true;
					$scope.venta = false;
					$scope.showCuotas = false;
					$scope.formulario.Contrato.precio_venta = 0;
				} else {
					$scope.arriendo = false;
					$scope.venta = true;
					$scope.showCuotas = true;
					$scope.formulario.Contrato.precio_arriendo = 0;
					$scope.formulario.Contrato.numero_cuota_id = 1;
				}
			});

			$scope.$watch(
				"formulario.Contrato.fecha_inicio",
				function (anterior, nuevo) {
					if (angular.isDefined(anterior))
						$scope.formulario.Contrato.fecha_cobro = anterior.substring(0, 2);
					else if (angular.isDefined(nuevo)) {
						angular.element("#fechaInicio").datepicker("setDate", nuevo);
					}
				}
			);

			$scope.$watch("formulario.Contrato.fecha_cobro", function (anterior) {
				if (angular.isDefined(anterior))
					if (anterior > 28) $scope.formulario.Contrato.fecha_cobro = "";
			});

			$scope.$watchGroup(
				[
					"formulario.Contrato.descuento",
					"formulario.Contrato.garantia",
					"formulario.Contrato.costo_despacho",
					"formulario.Contrato.subtotal",
					"formulario.Contrato.numero_cuota_id",
				],
				function (cant) {
					if (angular.isDefined($scope.formulario.Contrato.costo_despacho))
						$scope.formulario.Contrato.costo_despacho = parseInt(
							$scope.formulario.Contrato.costo_despacho
						);
					if (angular.isDefined($scope.formulario.Contrato.garantia))
						$scope.formulario.Contrato.garantia = parseInt(
							$scope.formulario.Contrato.garantia
						);
					if (angular.isDefined($scope.formulario.Contrato.descuento))
						$scope.formulario.Contrato.descuento = parseInt(
							$scope.formulario.Contrato.descuento
						);

					if (angular.isDefined($scope.formulario.Contrato.numero_cuota_id)) {
						angular.forEach($scope.cuotas, function (numCuota) {
							if (numCuota.id == $scope.formulario.Contrato.numero_cuota_id)
								$scope.numeroCuota = numCuota.numero;
						});
					}

					$scope.formulario.Contrato.precio_total =
						$scope.formulario.Contrato.subtotal -
						$scope.formulario.Contrato.descuento +
						$scope.formulario.Contrato.garantia +
						$scope.formulario.Contrato.costo_despacho;
					$scope.formulario.Contrato.valor_cuota =
						Math.round(
							(Number($scope.formulario.Contrato.precio_total) /
								Number($scope.numeroCuota)) *
								100
						) / 100;
				}
			);

			$scope.$watch(
				"formulario.Contrato.cliente_id",
				function (anterior, nuevo) {
					console.log("valores:", anterior, nuevo);
					if (angular.isDefined(anterior)) {
						direccionesService
							.getDireccionPorClienteId(anterior)
							.success(function (data) {
								console.log(data);
								$scope.direcciones = data;
							});
					}
				}
			);
		};
		$scope.setProducto = function (idProducto) {
			productosService.getProducto(idProducto).success(function (data) {
				$scope.Producto = {};
				$scope.Producto = data.Producto;
				$scope.Producto.producto_id = data.Producto.id;
				$scope.formulario.Contrato.cantidad_productos = 0;
				$scope.formulario.Contrato.precio_total = 0;
				$scope.formulario.Contrato.subtotal = 0;

				delete $scope.Producto.id;
				var valores = [];

				$scope.$watchGroup(
					[
						"Producto.precio_venta",
						"Producto.precio_arriendo",
						"Producto.cantidad",
					],
					function (data) {
						if (angular.isDefined($scope.Producto)) {
							angular.forEach(data, function (ingreso, key) {
								if (angular.isNumber(ingreso) || !angular.isDefined(ingreso))
									valores[key] = parseInt(ingreso);
							});
							$scope.Producto.cantidad = valores[2];
							if ($scope.arriendo) {
								$scope.Producto.precio_arriendo = valores[1];
								$scope.Producto.precio_venta = 0;
								if (
									angular.isDefined($scope.Producto.cantidad) &&
									angular.isDefined($scope.Producto.precio_arriendo)
								)
									$scope.Producto.subtotal =
										Number($scope.Producto.precio_arriendo) *
										Number($scope.Producto.cantidad);
							} else {
								$scope.Producto.precio_venta = valores[0];
								$scope.Producto.precio_arriendo = 0;
								if (
									angular.isDefined($scope.Producto.cantidad) &&
									angular.isDefined($scope.Producto.precio_venta)
								)
									$scope.Producto.subtotal =
										Number($scope.Producto.precio_venta) *
										Number($scope.Producto.cantidad);
							}
						}
					}
				);

				$scope.Producto.cantidad = 1;
			});
		};
		$scope.cambiaEstadoContrato = function (valor) {
			console.log(valor);
			if (valor == "0") {
				$scope.close = function (dialog) {
					angular.element("#" + dialog).modal("hide");
				};
			}
		};
		$scope.recalcular = function (form) {
			$scope.formulario.ContratosProducto = form;
			$scope.formulario.Contrato.cantidad_productos = 0;
			$scope.formulario.Contrato.precio_total = 0;
			$scope.formulario.Contrato.subtotal = 0;
			console.log("entra");
			angular.forEach(
				$scope.formulario.ContratosProducto,
				function (value, id) {
					console.log("entra2");
					console.log(value);
					$scope.formulario.Contrato.cantidad_productos =
						Number($scope.formulario.Contrato.cantidad_productos) +
						Number(value.cantidad);
					$scope.formulario.Contrato.subtotal =
						Number($scope.formulario.Contrato.subtotal) +
						Number(value.subtotal);
				}
			);
		};
		$scope.addProductoCarro = function (producto) {
			delete producto.estado;
			delete producto.existencias;
			producto.pendiente = 1;
			console.log(producto);
			$scope.formulario.ContratosProducto.push(producto);
			$scope.recalcular($scope.formulario.ContratosProducto);
			$scope.Producto = undefined;
		};
		$scope.eliminarProductoCarro = function (index) {
			$scope.formulario.ContratosProducto.splice(index, 1);
			$scope.recalcular($scope.formulario.ContratosProducto);

			console.log($scope.formulario.ContratosProducto);
		};
		$scope.registrarContrato = function () {
			$scope.deshabilita = true;
			delete $scope.formulario.Contrato.precio_venta;
			delete $scope.formulario.Contrato.precio_arriendo;
			angular.forEach(
				$scope.formulario.ContratosProducto,
				function (value, id) {
					delete $scope.formulario.ContratosProducto[id].$$hashKey;
				}
			);
			var productosNuevos = [];
			angular.forEach(
				$scope.formulario.ContratosProducto,
				function (value, id) {
					if (value.pendiente == 1) productosNuevos.push(value.producto_id);
				}
			);
			contratosService
				.registrarContrato($scope.formulario)
				.success(function (data) {
					if (data.estado == 1) {
						$scope.formulario.Contrato.id = data.id;
						Flash.create("success", data.mensaje, "customAlert");
						$scope.btnAgregarActividad = true;
						$scope.productosNew = productosNuevos.join("/");
					} else if (data.estado == 0) {
						Flash.create("danger", data.mensaje, "customAlert");
					}
				});
		};

		$scope.close = function (dialog) {
			angular.element("#" + dialog).modal("hide");
		};

		$scope.open = function (dialog) {
			angular.element("#" + dialog).modal("show");
		};
	}
);

app.controller(
	"contratosEdit",
	function (
		$scope,
		$http,
		contratosService,
		productosService,
		serviciosService,
		Flash,
		$filter,
		$window,
		$location,
		$rootScope,
		$anchorScroll
	) {
		$scope.loader = true;
		$scope.cargador = loader;
		$scope.formContratos = false;
		var Contrato;
		$scope.formulario = { Contrato: {} };
		$scope.showCuotas = false;
		$scope.numeroCuota = 1;
		$scope.obtDatos = function (idContrato) {
			contratosService.getContrato(idContrato).success(function (data) {
				console.log(data);
				$scope.formulario = data.data;
				$scope.numeroCuota = data.data.NumeroCuota.numero;
				$scope.direcciones = data.direccionesCliente;
				console.log($scope.formulario);
				$scope.formulario.Contrato.fecha_inicio =
					data.data.Contrato.fecha_inicio.split("-").reverse().join("-");
				if ($scope.formulario.Contrato.tipo_contrato_id == 1) {
					$scope.arriendo = true;
					$scope.venta = false;
					$scope.formulario.Contrato.precio_venta = 0;
					$scope.showCuotas = false;
				} else {
					$scope.arriendo = false;
					$scope.venta = true;
					$scope.formulario.Contrato.precio_arriendo = 0;
					$scope.showCuotas = true;
				}
				$scope.productos = data.listadoProductos;
				$scope.loader = false;
				$scope.formContratos = true;

				var valores = [];
				$scope.$watchGroup(
					[
						"formulario.Contrato.subtotal",
						"formulario.Contrato.costo_despacho",
						"formulario.Contrato.descuento",
						"formulario.Contrato.garantia",
						"formulario.Contrato.numero_cuota_id",
					],
					function (cant) {
						angular.forEach(cant, function (ingreso, key) {
							valores[key] = Number(ingreso);
						});
						$scope.formulario.Contrato.subtotal = valores[0];
						$scope.formulario.Contrato.costo_despacho = valores[1];
						$scope.formulario.Contrato.descuento = valores[2];
						$scope.formulario.Contrato.garantia = valores[3];

						if (
							angular.isDefined($scope.formulario.Contrato.subtotal) &&
							angular.isDefined($scope.formulario.Contrato.costo_despacho) &&
							angular.isDefined($scope.formulario.Contrato.descuento) &&
							angular.isDefined($scope.formulario.Contrato.garantia)
						)
							$scope.formulario.Contrato.precio_total =
								Number($scope.formulario.Contrato.subtotal) +
								Number($scope.formulario.Contrato.costo_despacho) +
								Number($scope.formulario.Contrato.garantia) -
								Number($scope.formulario.Contrato.descuento);
						$scope.formulario.Contrato.valor_cuota =
							Math.round(
								(Number($scope.formulario.Contrato.precio_total) /
									Number($scope.numeroCuota)) *
									100
							) / 100;
					}
				);
			});
		};

		$scope.setProducto = function (idProducto) {
			productosService.getProducto(idProducto).success(function (data) {
				$scope.Producto = {};
				$scope.Producto = data.Producto;
				$scope.Producto.producto_id = data.Producto.id;
				$scope.Producto.contrato_id = $scope.formulario.Contrato.id;
				delete $scope.Producto.id;
				var valores = [];

				$scope.$watchGroup(
					[
						"Producto.precio_venta",
						"Producto.precio_arriendo",
						"Producto.cantidad",
					],
					function (data) {
						if (angular.isDefined($scope.Producto)) {
							angular.forEach(data, function (ingreso, key) {
								if (angular.isNumber(ingreso) || !angular.isDefined(ingreso))
									valores[key] = parseInt(ingreso);
							});
							$scope.Producto.cantidad = valores[2];
							if ($scope.arriendo) {
								$scope.Producto.precio_arriendo = valores[1];
								$scope.Producto.precio_venta = 0;
								if (
									angular.isDefined($scope.Producto.cantidad) &&
									angular.isDefined($scope.Producto.precio_arriendo)
								)
									$scope.Producto.subtotal =
										Number($scope.Producto.precio_arriendo) *
										Number($scope.Producto.cantidad);
							} else {
								$scope.Producto.precio_venta = valores[0];
								$scope.Producto.precio_arriendo = 0;
								if (
									angular.isDefined($scope.Producto.cantidad) &&
									angular.isDefined($scope.Producto.precio_venta)
								)
									$scope.Producto.subtotal =
										Number($scope.Producto.precio_venta) *
										Number($scope.Producto.cantidad);
							}
						}
					}
				);

				$scope.Producto.cantidad = 1;
			});
		};

		$scope.recalcular = function (form) {
			$scope.formulario.ContratosProducto = form;
			$scope.formulario.Contrato.cantidad_productos = 0;
			$scope.formulario.Contrato.precio_total = 0;
			$scope.formulario.Contrato.subtotal = 0;
			angular.forEach(
				$scope.formulario.ContratosProducto,
				function (value, id) {
					if (value.estado == 1 || value.pendiente == 1) {
						$scope.formulario.Contrato.cantidad_productos =
							Number($scope.formulario.Contrato.cantidad_productos) +
							Number(value.cantidad);
						$scope.formulario.Contrato.subtotal =
							Number($scope.formulario.Contrato.subtotal) +
							Number(value.subtotal);
					}
				}
			);
		};

		$scope.addProductoCarro = function (producto) {
			delete producto.estado;
			delete producto.existencias;
			producto.pendiente = 1;

			$scope.formulario.ContratosProducto.push(producto);

			$scope.recalcular($scope.formulario.ContratosProducto);
			$scope.Producto = undefined;
			console.log($scope.formulario.ContratosProducto);
		};

		$scope.eliminarProductoCarro = function (index) {
			if (
				angular.isDefined($scope.formulario.ContratosProducto[index].pendiente)
			)
				$scope.formulario.ContratosProducto.splice(index, 1);
			else $scope.formulario.ContratosProducto[index].estado = 0;

			$scope.recalcular($scope.formulario.ContratosProducto);
		};

		$scope.registrarContrato = function () {
			$scope.deshabilita = true;
			if ($scope.formulario.Contrato.estado == 0) {
				var d = new Date();
				var n = d.toISOString();
				$scope.formulario.Contrato.fecha_termino = n.slice(0, 10);
				angular.forEach(
					$scope.formulario.ContratosProducto,
					function (value, id) {
						$scope.formulario.ContratosProducto[id].estado = 0;
					}
				);
			} else {
				var productosNuevos = [];
				angular.forEach(
					$scope.formulario.ContratosProducto,
					function (value, id) {
						if (value.pendiente == 1) productosNuevos.push(value.producto_id);
					}
				);
			}

			contratosService
				.registrarContrato($scope.formulario)
				.success(function (data) {
					if (data.estado == 1) {
						Flash.create("success", data.mensaje, "customAlert");
						$scope.btnAgregarActividad = true;
						$scope.productosNew = productosNuevos.join("/");
					} else if (data.estado == 0) {
						Flash.create("danger", data.mensaje, "customAlert");
					}
				});
		};

		$scope.close = function (dialog) {
			angular.element("#" + dialog).modal("hide");
		};

		$scope.contratoCliente = function () {
			$scope.desabilita = true;
			contratosService
				.correoCliente($scope.formulario)
				.success(function (data) {
					if (data.estado == 1) {
						Flash.create("success", data.mensaje, "customAlert");
						$scope.desabilita = false;
					} else if (data.estado == 0) {
						Flash.create("danger", data.mensaje, "customAlert");
						$scope.desabilita = false;
					}
				});
		};
	}
);

app
	.controller("reporteContratos", [
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
			$scope.lang = "es";
			$scope.gridOptions = {
				enableFiltering: true,
				useExternalFiltering: false,
				flatEntityAccess: true,
				showGridFooter: true,
				enableRowSelection: false,
				enableRowHeaderSelection: false,
				multiSelect: false,
				enableSorting: true,
				enableGridMenu: true,
				exporterCsvColumnSeparator: ";",
				exporterMenuPdf: false,
				exporterCsvFilename: "listado_contratos.csv",
				exporterCsvLinkElement: angular.element(
					document.querySelectorAll(".custom-csv-link-location")
				),
				onRegisterApi: function (gridApi) {
					$scope.gridApi = gridApi;
					//$scope.$apply();
				},
			};

			$scope.gridOptions.columnDefs = [
				{ name: "id", displayName: "#", width: 70 },
				{ name: "fecha_inicio", displayName: "Fecha contrato", width: 110 },
				{ name: "rut", displayName: "Rut", minWidth: 90 },
				{ name: "tipo_contrato", displayName: "Contrato", minWidth: 90 },
				{ name: "ds_estado", displayName: "Estado", minWidth: 80 },
				{ name: "nombre_cliente", displayName: "Cliente", minWidth: 110 },
				{ name: "empresa", displayName: "Empresa Asociada", minWidth: 110 },
				{
					name: "cantidad_productos",
					displayName: "Cant. Productos",
					cellTemplate:
						'<div style="text-align:center;"  class="ngCellText">{{row.entity.cantidad_productos}}</div>',
					minWidth: 110,
				},
				{ name: "nombre_productos", displayName: "Productos", minWidth: 150 },
				{
					name: "subtotal",
					displayName: "Mensualidad",
					cellTemplate:
						'<div style="text-align:right;"  class="ngCellText">{{row.entity.subtotal | number:0}}</div>',
					minWidth: 110,
				},
				{
					name: "descuento",
					displayName: "Descuento -",
					cellTemplate:
						'<div style="text-align:right;"  class="ngCellText">{{row.entity.descuento | number:0}}</div>',
					minWidth: 110,
				},
				{
					name: "garantia",
					displayName: "Garantía",
					cellTemplate:
						'<div style="text-align:right;"  class="ngCellText">{{row.entity.garantia | number:0}}</div>',
					minWidth: 110,
				},
				{
					name: "costo_despacho",
					displayName: "Despacho",
					cellTemplate:
						'<div style="text-align:right;"  class="ngCellText">{{row.entity.costo_despacho | number:0}}</div>',
					minWidth: 110,
				},
				{
					name: "precio_total",
					displayName: "Total",
					cellTemplate:
						'<div style="text-align:right;"  class="ngCellText">{{row.entity.precio_total | number:0}}</div>',
					minWidth: 110,
				},
				{ name: "created", displayName: "Hora creación", minWidth: 90 },
				{ name: "created_user", displayName: "Usuario creación", minWidth: 90 },
				{ name: "modified", displayName: "Hora modificación", minWidth: 90 },
				{
					name: "modified_user",
					displayName: "Usuario modificación",
					minWidth: 90,
				},
			];

			$http.get(host + "contratos/reporte_json").success(function (data) {
				$scope.loader = false;
				$scope.tablaDetalle = true;
				$scope.gridOptions.data = data;
				/* S $scope.gridApi.selection.on.rowSelectionChanged($scope,function(row){
            if(angular.isDefined(row.entity.id))
            {
                if(row.entity.contrato_id == 1 && row.entity.estado == 1){
                    $scope.btncontratosview = false;
                    $scope.btncontratosedit = false;
                    $scope.btncontratosasigna_act = false;
                    $scope.boton = true;
                    $scope.id = row.entity.id +"/"+ row.entity.cliente_id;

                }else{

                    $scope.btncontratosview = false;
                    $scope.btncontratosasigna_act = false;
                    $scope.btncontratosedit = true;
                    $scope.boton = true;
                    $scope.id = row.entity.id+"/"+ row.entity.cliente_id;
                }
            }
        });
*/
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
	])
	.filter("fractionFilter", function () {
		return function (value) {
			return value.toFixed(0);
		};
	})
	.filter("hasFilterTerm", function () {
		return function (columns) {
			var cols = [];
			columns.forEach(function (c) {
				c.filters.forEach(function (f) {
					if (f.term) {
						cols.push(c);
					}
				});
			});
			return cols;
		};
	});
