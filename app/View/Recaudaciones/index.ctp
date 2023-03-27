<style>
	input {
		margin-top: 0 !important;
		vertical-align: middle !important
	}

	td {
		vertical-align: middle !important;
	}

	#GridCustomId.ui-grid-cell div form select option:first-child[value=''] {
		display: none;
	}

	.container {
		width: 80%;
	}

	.gridCustomId:before {
		content: "\f040";
		font-family: FontAwesome;
		display: inline-block;
		float: right;
		right: 8px;
		top: 7px;
		position: relative;
	}
</style>

<div ng-controller="recaudacionePagos" ng-init="obtDatos()">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="formPagos">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="row">
				<h4 class="col-md-offset-0" style="margin-bottom:10px">Pagos Pendientes</h4>
			</div>
			<div class="row">
				<!--form class="form-horizontal" name="recaudacionesUpd" novalidate>
				<div class="table-responsive ui-content" data-role="main">
					<label>Buscar: <input ng-model="query"></label>
					<table class="table table-condensed table-striped table-hover" id="searchTextResults">
						<thead>
							<tr>
								<th class="text-center" width="55">#</th>
								<th class="text-center col-md-2" data-priority="1"> Cliente</th>

								<th class="text-center col-md-1" data-priority="1">FechaCobro</th>
								<th class="text-center col-md-1" data-priority="2">Estado</th>
								<th class="text-center col-md-1" data-priority="3">Mensualidad</th>
								<th class="text-center col-md-1" data-priority="4">Descuento</th>
								<th class="text-center col-md-1" data-priority="5">Despacho</th>
								<th class="text-center col-md-1" data-priority="6">Total</th>
								<th class="text-center" data-priority="7">Documento</th>
								<th class="text-center" data-priority="8">&nbsp;&nbsp;Nº.Documento</th>
								<th width="55"></th>
								<th width="55"></th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="recaudacione in formulario.Recaudacione | filter:query" >
								<td ng-model="formulario.Recaudacione[$index].contrato_id" width="50">
									{{recaudacione.contrato_id}}</td>
									{{contrato_id}}
								<td ng-model="formulario.Recaudacione[$index].cliente_id" class="col-md-2">
									<u><a data-toggle="modal" href="#" ng-click="verDetalle(formulario.Recaudacione[$index].contrato_id)">{{recaudacione.nombre_cliente}}</a></u>
								</td>
								<td ng-model="formulario.Recaudacione[$index].fecha_cobro" class="text-center col-md-1">
									{{recaudacione.fecha_cobro}}</td>
								<td class="text-center col-md-1"> {{recaudacione.ds_estado}} </td>
								<td ng-model="formulario.Recaudacione[$index].subtotal" class="text-right col-md-1">
									{{recaudacione.subtotal | number:0}}</td>
								<td ng-model="formulario.Recaudacione[$index].descuento" class="text-right col-md-1">
									{{recaudacione.descuento | number:0}}</td>
								<td ng-model="formulario.Recaudacione[$index].despacho" class="text-right col-md-1">
									{{recaudacione.despacho | number:0}}</td>
								<td ng-model="formulario.Recaudacione[$index].total_cobrado" class="text-right col-md-1">
									{{recaudacione.total_cobrado | number:0}}</td>
								<td class="col-md-1">
									<ui-select class="sube" name="docu-{{$index}}" ng-model="formulario.Recaudacione[$index].tipo_documento_id" style="width:105px">
										<ui-select-match placeholder="Seleccione">
											{{$select.selected.nombre}}
										</ui-select-match>
										<ui-select-choices repeat="docu.id as docu in datos.TipoDocumento | filter: $select.search">
											<div ng-bind-html="docu.nombre | highlight: $select.search" ></div>
										</ui-select-choices>
									</ui-select>
								</td>
								<td width="135">
									<div class="form-group col-md-12" style="margin-bottom:0px;width:120%">
										<input type="text" class="form-control sube" name="nro-{{$index}}" placeholder="Nro. Documento" ng-model="formulario.Recaudacione[$index].nro_documento">
									</div>
								</td>
								<td width="50">
									<input class="checkgrande" type="checkbox" ng-model="formulario.Recaudacione[$index].estado" name="estado-{{$index}}" ng-true-value="1" ng-false-value="0" ng-checked="formulario.Recaudacione[$index].estado==1" ng-init="(formulario.Recaudacione[$index].estado==1)?estado=true:estado=false;" ng-disabled="estado" style="margin-bottom:2px">
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				</form-->
				<?php echo $this->element("botonera"); ?>
				<div id="GridCustomId" ui-grid="gridOptions" ui-grid-edit="" ui-grid-cellnav="" ui-grid-selection ui-grid-exporter ng-model="grid" class="grid" style="height:400px;" ui-grid-auto-resize ui-grid-resize-columns></div>

			</div>
		</div>

		<div id="detalle" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg" style="min-width:900px !important">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Detalle </h4>
					</div>
					<div class="modal-body">

						<div class="row">
							<div class="col-md-12">
								<h4 style="margin-bottom:20px">Contrato</h4>
							</div>
							<form role="form" class="form-horizontal" name="contratosAdd" novalidate>
								<div class="col-md-12">
									<table class="table table-bordered table-hover table-condensed">
										<tr>
											<th class="col-md-2 text-right">Nombre Cliente</th>
											<td class="col-md-2">{{detalle.Cliente.nombre}}</td>
											<th class="col-md-2 text-right">Tipo Contrato</th>
											<td class="col-md-2">{{detalle.TipoContrato.nombre}}</td>
											<th class="col-md-2 text-right">Estado</th>
											<td class="col-md-2">{{(detalle.Contrato.estado==1)? "Activo":"Cerrado" }}</td>
										</tr>
										<tr>
											<th class="text-right">Fecha Inicio</th>
											<td>{{detalle.Contrato.fecha_inicio}}</td>
											<th class="text-right">Día Cobranza</th>
											<td>{{detalle.Contrato.fecha_cobro}}</td>
											<th class="text-right" ng-show="(detalle.Contrato.estado==0)">{{(detalle.Contrato.estado==0)? "Fecha cierre":""}}</th>
											<td ng-show="(detalle.Contrato.estado==0)">{{(detalle.Contrato.estado==0)? (detalle.Contrato.fecha_termino | date:dd-mm-yyyy) :""}}</td>
										</tr>
									</table>
								</div>

								<div>
									<div class="col-md-12">
										<h4 style="margin-bottom:20px">Detalle Productos</h4>
									</div>

									<div class="col-md-12">
										<table class="table table-bordered table-hover table-condensed">
											<thead>
												<tr>
													<th class="text-center">
														#
													</th>
													<th class="text-center">
														Nombre Producto
													</th>
													<th class="text-center">
														Descripción
													</th>
													<th class="text-center">
														Observación
													</th>
													<!--th class="text-center" style="width:200px">
															Cantidad
														</th-->
													<th class="text-center" style="width:200px">
														Precio
													</th>
													<!--th class="text-center" style="width:50px">

														</th-->
												</tr>
											</thead>
											<tbody>
												<tr ng-repeat="producto in detalle.ContratosProducto" ng-show="producto.estado==1||detalle.Contrato.tipo_contrato_id ==2">
													<td class="text-center">
														{{producto.producto_id}}
													</td>
													<td>
														{{producto.nombre}}
													</td>
													<td>
														{{producto.descripcion}}
													</td>
													<td>
														{{producto.observaciones}}
													</td>
													<!--td class="text-center">
															{{producto.cantidad}}
														</td-->
													<td class="text-right">
														{{producto.subtotal | number:0}}
													</td>
													<!--td class="text-center">
															<button ng-show="!!producto.producto_id" ng-click="eliminarProductoCarro($index)" type="button" class="btn btn-danger btn-xs clsEliminarFila pull-center sube">
																<i class="fa fa-trash-o"></i>
															</button>
														</td-->
												</tr>
											</tbody>
											<tfooter>
												<tr>
													<th colspan="4">
														Mensualidad
													</th>
													<!--th class="text-center">
															{{formulario.Contrato.cantidad_productos}}
														</th-->
													<th class="text-right">
														{{detalle.Contrato.subtotal | number:0}}
													</th>
													<!--th>

														</th-->
												</tr>
											</tfooter>
										</table>

										<div class="pull-right">
											<table class="table table-condensed" tyle="width:430px">
												<tbody>
													<tr>
														<th class="text-right">Entrega, instalación y retiro $</th>
														<td>
															<div class="form-group" style="margin-bottom: 0px">
																<div class="col-md-12 text-right">
																	<b>{{detalle.Contrato.costo_despacho | number:0}}</b>
																	<!--input type="number" name="Despacho" class="form-control text-right" min="0" style="margin-top: 0px" ng-model="formulario.Contrato.costo_despacho" readonly-->
																</div>
															</div>
														</td>
													</tr>
													<tr>
														<th class="text-right">Garantía $</th>
														<td>
															<div class="form-group" style="margin-bottom: 0px">
																<div class="col-md-12 text-right">
																	<b>{{detalle.Contrato.garantia | number:0}}</b>
																</div>
															</div>
														</td>
													</tr>
													<tr>
														<th style="width:230px" class="text-right">Descuentos - $ </th>
														<td style="width:210px">
															<div class="form-group" style="margin-bottom: 0px">
																<div class="col-md-12 text-right">
																	<b>{{detalle.Contrato.descuento | number:0}}</b>
																	<!--input type="number" name="Descuento" class="form-control text-right" min="0" style="margin-top: 0px" ng-model="formulario.Contrato.descuento" readonly-->
																</div>
															</div>
														</td>
													</tr>
													<tr ng-if="showCuotas">
														<th class="text-right">Valor Cuota $</th>
														<td class="text-right">
															<div class="form-group" style="margin-bottom: 0px">
																<div class="col-md-12 pull-right" style="margin-right: 5px">
																	<b>{{numeroCuota}} x {{detalle.Contrato.valor_cuota | number:0}}</b>
																</div>
															</div>
														</td>
													</tr>
													<tr style="font-size:16px">
														<th class="text-right">Precio Total $</th>
														<td class="text-right">
															<div class="form-group" style="margin-bottom: 0px">
																<div class="col-md-12 pull-right" style="margin-right: 5px">
																	<b>{{detalle.Contrato.precio_total | number:0}}</b>
																</div>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
					</div>
				</div>

			</div>
		</div>
		<div class="text-right col-md-12">
			<button class="btn btn-primary btn-lg" ng-disabled="deshabilita" ng-click="registrarPagos()"><i class="fa fa-pencil"></i> Registrar</button>
		</div>
	</div>
</div>
</div>

<?php
echo $this->Html->script(array(
	'angularjs/controladores/app',
	'angularjs/controladores/recaudaciones/controlador_recaudaciones',
	'angularjs/servicios/recaudaciones/servicios_recaudaciones',
	'angularjs/controladores/contratos/controlador_contratos',
	'angularjs/servicios/contratos/servicios_contratos',
	'angularjs/servicios/productos/servicios_productos',
	'angularjs/servicios/servicios'
));
?>