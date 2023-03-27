<div ng-controller="productosAdd" ng-init="obtDatos()" >
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="formProductos">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="col-md-12">
				<h4 class="col-md-offset-1" style="margin-bottom:10px">Registrar Producto</h4>
			</div>
			<div class="row">
				<form class="form-horizontal" name="productosAdd" novalidate>			
					<div class="form-group">
						<label class="col-md-3 control-label baja">Nombre</label>
						<div class="col-md-6">
							<input type="text" name="Nombre" class="form-control" ng-model="formulario.Producto.nombre" required>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label baja">Descripción</label>
						<div class="col-md-6">
							<input type="text" name="Descripcion" class="form-control" ng-model="formulario.Producto.descripcion">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label baja">Precio Arriendo Mensual $</label>
						<div class="col-md-6">
							<input type="text" number-format decimals="0" negative="false" name="PrecioArriendo" class="form-control" ng-model="formulario.Producto.precio_arriendo" required>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label baja">Precio Venta $</label>
						<div class="col-md-6">
							<input type="text" number-format decimals="0" negative="false" name="PrecioVenta" class="form-control" ng-model="formulario.Producto.precio_venta" required>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label baja">Existencias</label>
						<div class="col-md-6">
							<input type="text" number-format decimals="0" negative="false" name="Existencias" class="form-control" ng-model="formulario.Producto.existencias" required>
						</div>
					</div>
					
				</form>
			</div>
			<p> &nbsp;</p>
			<div class="text-right col-md-9">
				<button class="btn btn-primary btn-lg" ng-disabled="!productosAdd.$valid||deshabilita" ng-click="registrarProducto()"><i class="fa fa-pencil"></i> Registrar</button>
				<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a> 
			</div>
		</div>
	</div>
</div>

<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/productos/controlador_productos',
		'angularjs/servicios/productos/servicios_productos',
		'angularjs/servicios/servicios',		
		'angularjs/directivas/number_format',		
		'bootstrap-datepicker'		
	));
?>
