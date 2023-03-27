<div ng-controller="contratosEdit" ng-init="obtDatos(<?php if (isset($this->request->pass[0])) {
															echo $this->request->pass[0];
														} ?>)">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="formContratos">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<h4 style="margin-bottom:20px">Contrato</h4>
				</div>
				<form role="form" class="form-horizontal" name="contratosAdd" novalidate>
					<div class="col-md-12">
						<table class="table table-bordered table-hover table-condensed">
							<tr>
								<th class="col-md-2 text-right">Nombre Cliente</th>
								<td class="col-md-2">{{formulario.Cliente.nombre}}</td>
								<th class="col-md-2 text-right">Tipo Contrato</th>
								<td class="col-md-2">{{formulario.TipoContrato.nombre}}</td>
								<th class="col-md-2 text-right">Estado</th>
								<td class="col-md-2">{{(formulario.Contrato.estado==1)? "Activo":"Cerrado" }}</td>
							</tr>
							<tr>
								<th class="text-right">Fecha Inicio</th>
								<td>{{formulario.Contrato.fecha_inicio}}</td>
								<th class="text-right">Día Cobranza</th>
								<td>{{formulario.Contrato.fecha_cobro}}</td>
								<th class="text-right" ng-show="(formulario.Contrato.estado==0)">{{(formulario.Contrato.estado==0)? "Fecha cierre":""}}</th>
								<td ng-show="(formulario.Contrato.estado==0)">{{(formulario.Contrato.estado==0)? (formulario.Contrato.fecha_termino | date:dd-mm-yyyy) :""}}</td>
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
									<tr ng-repeat="producto in formulario.ContratosProducto" ng-show="producto.estado==1||formulario.Contrato.estado==0">
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
										<th colspan="4" class="text-right">
											{{(formulario.Contrato.tipo_contrato_id==1)? "Mensualidad":"Subtotal" }}
										</th>
										<!--th class="text-center">
											{{formulario.Contrato.cantidad_productos}}
										</th-->
										<th class="text-right">
											{{formulario.Contrato.subtotal | number:0}}
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
														<b>{{formulario.Contrato.costo_despacho | number:0}}</b>
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
														<b>{{formulario.Contrato.garantia | number:0}}</b>
													</div>
												</div>
											</td>
										</tr>
										<tr>
											<th style="width:230px" class="text-right">Descuentos - $ </th>
											<td style="width:210px">
												<div class="form-group" style="margin-bottom: 0px">
													<div class="col-md-12 text-right">
														<b>{{formulario.Contrato.descuento | number:0}}</b>
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
														<b>{{numeroCuota}} x {{formulario.Contrato.valor_cuota | number:0}}</b>
													</div>
												</div>
											</td>
										</tr>
										<tr style="font-size:16px">
											<th class="text-right">Precio Total $</th>
											<td class="text-right">
												<div class="form-group" style="margin-bottom: 0px">
													<div class="col-md-12 pull-right" style="margin-right: 5px">
														<b>{{formulario.Contrato.precio_total | number:0}}</b>
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

			<p> &nbsp;</p>
			<div class="text-center col-md-12">
				<!--a href="<?php echo $this->Html->url(array("action" => "index")) ?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a-->
				<a href="<?php echo $this->request->referer(); ?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a>
				<button class="volver btn btn-primary btn-lg" confirmed-click="contratoCliente(<?php if (isset($this->request->pass[0])) {
																									echo $this->request->pass[0];
																								} ?>)" ng-confirm-click="Enviaras un contrato por correo al cliente actual. ¿ Deseas continuar ?" ng-disabled="desabilita"><i class="fa fa-send"></i> Enviar a Cliente</button>
			</div>
		</div>

	</div>
</div>

<?php
echo $this->Html->script(array(
	'angularjs/controladores/app',
	'angularjs/controladores/contratos/controlador_contratos',
	'angularjs/servicios/contratos/servicios_contratos',
	'angularjs/servicios/productos/servicios_productos',
	'angularjs/servicios/servicios',
	'angularjs/directivas/confirmacion',
	'bootstrap-datepicker',
	'rut'
));
?>