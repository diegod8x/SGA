<div ng-controller="clientesIndex" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<div class="row">
			<div  class="col-md-12">
				<div class="col-md-12">
					<h3>Listado Clientes</h3>
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
</div>
<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/clientes/clientes',
		'angularjs/servicios/clientes/clientes',
		'angularjs/servicios/servicios',
		'angularjs/servicios/empresas/empresas',	
		'bootstrap-datepicker',
		'angularjs/directivas/confirmacion',
		'rut'
	));
?>
<script>$('.tool').tooltip()
$(".alert" ).fadeOut(3000);
</script>