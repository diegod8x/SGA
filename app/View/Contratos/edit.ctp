<style>
	.ui-select-toggle {
		display: flex;
		justify-content: space-between;
	}

	.ui-select-match-text {
		overflow-x: hidden;
		text-overflow: ellipsis;
	}

	.dropdown {
		position: relative;
		padding-left: 15px px;
		padding-left: 15px;
	}

	.ui-select-bootstrap>.ui-select-choices {
		margin-left: 15px;
		width: auto;
	}
</style>

<div ng-controller="contratosEdit" ng-init="obtDatos(<?php if (isset($this->request->pass[0])) {
																												echo $this->request->pass[0];
																											} ?>)">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="formContratos">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<h4 style="margin-bottom:20px">Editar Contrato</h4>
				</div>
				<form role="form" class="form-horizontal" name="contratosAdd" novalidate>
					<div class="col-md-12">
						<table class="table table-bordered table-hover table-condensed">
							<tr style="height:45px !important">
								<th class="col-md-1 text-right">Nombre Cliente</th>
								<td class="col-md-2" ng-model="formulario.Cliente.nombre">{{formulario.Cliente.nombre}}</td>
								<th class="col-md-1 text-right">Tipo Contrato</th>
								<td class="col-md-1" ng-model="formulario.TipoContrato.nombre">{{formulario.TipoContrato.nombre}}</td>
								<th class="col-md-1 text-right" style="padding-top:10px;border-right:none">Estado</th>
								<td class="col-md-1">
									<div class="col-md-12">
										<select class="form-control" ng-model="formulario.Contrato.estado" on-select="open('cerrar')" style="width:384px !important">
											<option value="1">Activo</option>
											<option value="0">Cerrado</option>
										</select>
									</div>
									<!--{{(formulario.Contrato.estado==1)? "Activo":"Cerrado" }}-->
								</td>

							</tr>
							<tr style="height:45px !important">
								<th class="col-md-1 text-right">Fecha Inicio</th>
								<td class="col-md-2" ng-model="formulario.Contrato.fecha_inicio">{{formulario.Contrato.fecha_inicio}}</td>
								<th class="text-right">Día Cobranza</th>
								<td ng-model="formulario.Contrato.fecha_cobro">{{formulario.Contrato.fecha_cobro}}</td>
								<th class="text-right">Dirección</th>
								<td class="col-md-2" ng-model="formulario.Contrato.direccione_id">
									<ui-select ng-model="formulario.Contrato.direccione_id" name="Direccion" ng-required="!!formulario.Contrato.direccione_id" style="width:400px !important">
										<ui-select-match placeholder="Seleccione una dirección">
											{{$select.selected.nombre}}
										</ui-select-match>
										<ui-select-choices repeat="direccion.id as direccion in direcciones | filter: $select.search">
											<div ng-bind-html="direccion.nombre | highlight: $select.search"></div>
										</ui-select-choices>
									</ui-select>
								</td>
							</tr>
						</table>
					</div>

					<div class="modal fade" tabindex="-1" role="dialog" id="cerrar">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title">Confirmnación</h4>
								</div>
								<div class="modal-body">
									<p>Debe ingresar un comentario para cerrar el contrato.</p>
									<textarea></textarea>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
									<button type="button" class="btn btn-primary">Confirmar</button>
								</div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->

					<!--div class="form-group">
						<label class="control-label col-md-3 baja">Tipo Contrato</label>
						<div class=" col-md-8">
							<input type="text" name="TipoContrato" class="form-control" ng-model="formulario.TipoContrato.nombre" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3 baja">Cliente</label>
						<div class=" col-md-8">
							<input type="text" name="Clientes" class="form-control" ng-model="formulario.Cliente.nombre" readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label baja">Fecha Inicio</label>
						<div class="col-md-8">
							<div class="input">
								<input class="form-control datepicker"  id="fechaInicio" name="fechaInicio" ng-model="formulario.Contrato.fecha_inicio" placeholder="Seleccione fecha" readonly="readonly" style="padding-left: 12px;" required>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label  col-md-3 baja">Día Cobranza</label>
						<div class=" col-md-8">
							<input type="text" name="Cobranza" class="form-control" ng-model="formulario.Contrato.fecha_cobro" readonly>
						</div>
					</div-->
					<div class="col-md-12 text-center">
						<a id="modal" href="#dialog" role="button" style="width:200px" ng-disabled="!contratosAdd.$valid" class="btn btn-success btn-lg" data-toggle="modal">
							<i class="fa fa-shopping-cart"></i>
							Ingresar Producto
						</a>
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
										<th class="text-center" style="width:50px">

										</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="producto in formulario.ContratosProducto" ng-show="producto.estado==1||producto.pendiente==1">
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
										<td class="text-center">
											<button ng-show="!!producto.producto_id" ng-click="eliminarProductoCarro($index)" type="button" class="btn btn-danger btn-xs clsEliminarFila pull-center sube">
												<i class="fa fa-trash-o"></i>
											</button>
										</td>
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
											{{formulario.Contrato.subtotal | number:0}}
										</th>
										<th>

										</th>
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
													<div class="col-md-12 pull-right">
														<input type="text" number-format decimals="0" negative="false" name="Despacho" class="form-control text-right" min="0" style="margin-top: 0px" ng-model="formulario.Contrato.costo_despacho">
													</div>
												</div>
											</td>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<th class="text-right">Garantía $</th>
											<td>
												<div class="form-group" style="margin-bottom: 0px">
													<div class="col-md-12 pull-right">
														<input type="text" number-format decimals="0" negative="false" name="Garantía" class="form-control text-right" min="0" style="margin-top: 0px" ng-model="formulario.Contrato.garantia">
													</div>
												</div>
											</td>
											<td>&nbsp;</td>
										</tr>
										<tr>
											<th style="width:230px" class="text-right">Descuentos - $ </th>
											<td style="width:210px">
												<div class="form-group" style="margin-bottom: 0px">
													<div class="col-md-12">
														<input type="text" number-format decimals="0" negative="false" name="Descuento" class="form-control text-right" min="0" style="margin-top: 0px" ng-model="formulario.Contrato.descuento">
													</div>
												</div>
											</td>
											<td style="width:43px">&nbsp;</td>
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
											<td>&nbsp;</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</form>
			</div>


			<div class="col-md-12">

				<form role="form" class="form-horizontal" name="productoAdd" novalidate>
					<div class="modal fade" id="dialog" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<!--button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button-->

									<h4 class="modal-title" id="myModalLabel">
										Ingreso productos
									</h4>
								</div>

								<div class="modal-body">
									<div class="form-group" ng-class="{ 'has-error': !productoAdd.NombreProducto.$valid }">
										<label class="control-label col-md-4">Nombre Producto</label>
										<div class="col-md-7">
											<ui-select ng-model="Producto.producto_id" name="NombreProducto" on-select="setProducto($select.selected.id)" required>
												<ui-select-match placeholder="Seleccione un producto">
													{{$select.selected.nombre}}
												</ui-select-match>
												<ui-select-choices repeat="producto.id as producto in productos | filter: $select.search">
													<div ng-bind-html="producto.nombre | highlight: $select.search"></div>
												</ui-select-choices>
											</ui-select>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-4 baja">Descripción</label>
										<div class=" col-md-7">
											<input type="text" name="Descripcion" class="form-control" ng-model="Producto.descripcion" required readonly>
										</div>
									</div>

									<div class="form-group" ng-if="venta">
										<label class="control-label col-md-4 baja">Precio venta $</label>
										<div class=" col-md-7">
											<input type="text" number-format decimals="0" negative="false" name="PrecioVenta" class="form-control" ng-model="Producto.precio_venta" min="1" required>
										</div>
									</div>

									<div class="form-group" ng-if="arriendo">
										<label class="control-label col-md-4 baja">Precio arriendo $</label>
										<div class=" col-md-7">
											<input type="text" number-format decimals="0" negative="false" name="PrecioArriendo" class="form-control" ng-model="Producto.precio_arriendo" min="1" required>
										</div>
									</div>

									<!--div class="form-group">
										<label class="control-label  col-md-4 baja">Cantidad</label>
										<div class=" col-md-7">
											<input type="number" name="Cantidad" class="form-control" ng-model="Producto.cantidad" min="1" required>
										</div>
									</div>

									<div class="form-group">
										<label class="control-label  col-md-4 baja">Subtotal $</label>
										<div class=" col-md-7">
											<input type="number" name="Subtotal" class="form-control" ng-model="Producto.subtotal" required readonly>
										</div>
									</div-->

									<div class="form-group">
										<label class="control-label  col-md-4 baja">Observaciones</label>
										<div class=" col-md-7">
											<input type="text" name="Observaciones" class="form-control" ng-model="Producto.observaciones">
										</div>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label  col-md-4 baja">Disponibles</label>
									<div class="col-md-7">
										<input type="text" name="Cantidad" class="form-control" ng-model="Producto.disponibles" readonly required>
									</div>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">
										Cancelar
									</button>
									<button type="button" class="btn btn-primary" ng-disabled="!productoAdd.$valid" data-dismiss="modal" ng-click="addProductoCarro(Producto);close('dialog')">
										Ingresar
									</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<p> &nbsp;</p>
			<div class="text-center col-md-12">
				<button class="btn btn-primary btn-lg" ng-hide="btnAgregarActividad" style="width:200px" ng-disabled="!contratosAdd.$valid||deshabilita" ng-click="registrarContrato()">
					<i class="fa fa-pencil"></i>
					Registrar
				</button>
				<a ng-show="btnAgregarActividad" href="<?php echo $this->Html->url(array('controller' => 'actividades', 'action' => 'add')) . DS . $this->request->pass[0] . DS . $this->request->pass[1] . DS ?>#/{{productosNew}}" class="btn btn-morado btn-lg">
					<i class="fa fa-pencil"></i>
					Agregar Actividad
				</a>
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
	'angularjs/directivas/number_format',
	'bootstrap-datepicker',
	'rut'
));
?>