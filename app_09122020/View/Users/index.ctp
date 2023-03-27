<div ng-controller="ListaUsers" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<?php echo $this->element("botonera"); ?>
		<div class="row">
			<div class="col-xs-12">	
				<!--div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid"></div-->
				<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter ui-grid-auto-resize ui-grid-resize-columns ng-model="grid" class="grid"></div>
			</div>
		</div>
	</div>
</div>
<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/directivas/confirmacion',
		'angularjs/servicios/users/lista_users_service',
		'angularjs/servicios/roles/lista_nombres_roles',
		'angularjs/servicios/paginas_roles/paginas_roles',
		'angularjs/servicios/lista_roles_service',
		'angularjs/controladores/users/lista_usuarios',
		'angularjs/directivas/users/lista_roles_nombres',
		'angularjs/directivas/modal/modal',
	));
?>
<script>
	$('.tool').tooltip();
</script>