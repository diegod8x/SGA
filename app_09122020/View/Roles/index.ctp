<div ng-controller="ComprasReportes" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<?php echo $this->element('botonera'); ?>
		<?php //echo $this->element('toolbox_angular'); ?>
		<div>	
			<div ui-i18n="{{lang}}">
				<div ui-grid="gridOptions" ui-grid-selection ui-grid-exporter class="grid"></div>
			</div>
		</div>
	</div>
</div>

<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/servicios/lista_roles_service',
		'angularjs/factorias/roles/roles',
		'angularjs/controladores/lista_roles',
		'angularjs/directivas/confirmacion',
	));
?>