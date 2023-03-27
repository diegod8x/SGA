<div ng-controller="reporteContratos" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<div class="row">
			<div class="col-md-12" style="zoom: 96%;">
				<div class="col-md-12">
					<h3>Listado Contratos</h3>
				</div>
				<div class="col-md-12" >
					<?php //echo $this->element("botonera"); ?>
					</br>
					<div ui-i18n="{{lang}}">
						<div ui-grid="gridOptions" ui-grid-exporter ui-grid-auto-resize ui-grid-resize-columns ng-model="grid" class="grid" style="height:530px;"></div>
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
		'angularjs/controladores/contratos/controlador_contratos',
		'angularjs/servicios/contratos/servicios_contratos',
		//'angularjs/servicios/servicios',		
		//'angularjs/directivas/capitalize_input',		
		//'bootstrap-datepicker',
		//'rut'
	));
?>
<script>$('.tool').tooltip()</script>