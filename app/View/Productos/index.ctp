<div ng-controller="productosIndex" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<div class="row">
			<div  class="col-md-12">
				<div class="col-md-12">
					<h3>Listado Productos</h3>
				</div>
				<div class="col-md-12">
					<?php echo $this->element("botonera"); ?>
					<div ui-i18n="{{lang}}">
						<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ui-grid-auto-resize ui-grid-resize-columns ng-model="grid" class="grid" style="height:400px;"></div>
					</div>
				</div>
			</div>		
		</div>
	</div>
	<?php //echo $this->element("ficha_trabajador"); ?>
</div>
<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/productos/controlador_productos',
		'angularjs/servicios/productos/servicios_productos',
		'angularjs/servicios/servicios',
		//'angularjs/directivas/capitalize_input',		
		'bootstrap-datepicker',
		'rut'
	));
?>

<script>
	$('.tool').tooltip();
</script>