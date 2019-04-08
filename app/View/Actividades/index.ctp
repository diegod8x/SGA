<div ng-controller="actividadesIndex" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		<div class="row">
			<div  class="col-md-12">
				<div class="col-md-12">
					<h3 styel="margin-top: 0px">Listado Actividades<!--b><?php echo $this->Session->read("Users.nombre");?></b--></h3>
				</div>
				<form class="form-inline" name="actividades" novalidate>
					<div class="col-md-12" style="margin-bottom: 20px;">	
						<div class="form-group">
							<div class="input text">	
								<input class="form-control datepicker readonly-pointer-background" type="text" id="fechaInicio" name="fechaInicio" ng-model="actividades.fecha_inicio" placeholder="Fecha inicio" style="padding-left: 12px" required>
							</div>
						</div>
						<div class="form-group">
							<div class="input text">	
								<input class="form-control datepicker readonly-pointer-background"  type="text" id="fechaTermino" name="fechaTermino" ng-model="actividades.fecha_termino" placeholder="Fecha término" style="padding-left: 12px;" required>
							</div>
						</div>
						<div class="form-group">
							<button type="button" ng-click="buscarActividades(actividades.fecha_inicio, actividades.fecha_termino)" class="btn btn-info btn-lg clsEliminarFila pull-center button" ng-disabled="!actividades.$valid">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</div>
					<div ng-show="msgSinResultados" class="text-danger"><p>Sin resultados</p></div>
				</form>					
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
		'angularjs/controladores/actividades/controlador_actividades',
		'angularjs/servicios/actividades/servicios_actividades',
		'angularjs/servicios/servicios',
		'angularjs/servicios/empresas/empresas',
		'bootstrap-datepicker'
		//'rut'
	));
?>
<script>$('.tool').tooltip()</script>