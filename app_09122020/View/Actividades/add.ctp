<div ng-controller="actividadesAdd" ng-init="obtDatos(<?php if(isset($this->request->pass)){ echo implode(",",$this->request->pass); }?>)" >
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="formActividades">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<h4 class="col-md-offset-3" style="margin-bottom:20px">Nueva Actividad</h4>
				</div>
				<form role="form" class="form-horizontal" name="actividadesAdd" novalidate>
					
					<div class="form-group" ng-class="{ 'has-error': !actividadesAdd.TipoActividade.$valid }">
						<label class="control-label col-md-3">Seleccione Tipo Actividad</label>
						<div class="col-md-6">
							<ui-select ng-model="formulario.Actividade.tipo_actividade_id" name="TipoActividade" required>
								<ui-select-match placeholder="Seleccione un tipo de actividad">
									{{$select.selected.nombre}}
								</ui-select-match>
								<ui-select-choices repeat="actividade.id as actividade in tipoActividades | filter: $select.search">
									<div ng-bind-html="actividade.nombre | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>

					<div class="form-group" ng-class="{ 'has-error': !actividadesAdd.Trabajador.$valid }">
						<label class="col-md-3 control-label">Seleccione Trabajador</label>
						<div class="col-md-6">
							<ui-select ng-model="formulario.Actividade.trabajadore_id" name="Trabajador" required>
								<ui-select-match placeholder="Asignar trabajador">
									{{$select.selected.nombre_completo}}
								</ui-select-match>
								<ui-select-choices repeat="trabajador.id as trabajador in trabajadores | filter: $select.search">
									<div ng-bind-html="trabajador.nombre_completo | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
						<div calss="form-inline">
							<a href="<?php echo $this->Html->url(array('controller'=>'trabajadores',"action"=>"add"))?>" target="_blank" class="btn btn-primary tool" data-toggle="tooltip" data-placement="top" title="Ingresar trabajador">
								<i class="fa fa-plus"></i>
							</a>
						</div>
					</div>

					<div class="form-group" ng-class="{ 'has-error': !actividadesAdd.Observaciones.$valid }">
						<label class="col-md-3 control-label baja">Observaciones</label>
						<div class="col-md-6">
							<textarea type="text" class="form-control sube col-md-6" name="Observaciones"
						 ng-model="formulario.Actividade.observaciones" required></textarea>
						</div>
					</div>

					<div class="form-group sube" ng-class="{ 'has-error': !actividadesAdd.fechaActividad.$valid }">
						<label class="control-label col-md-3">Fecha Actividad</label>
						<div class="input col-md-6">
							<input class="form-control datepicker readonly-pointer-background sube" readonly="readonly" id="fechaActividad" name="fechaActividad" ng-model="formulario.Actividade.fecha_ingreso" placeholder="Fecha" style="padding-left: 12px;" required>
						</div>
					</div>

					<div class="form-group sube" ng-class="{ 'has-error': !actividadesAdd.horaAcordada.$valid }">
						<label class="control-label col-md-3">Hora Acordada</label>
						<div class="input text col-md-6">
							<input class="form-control readonly-pointer-background sube" type="text"  id="horaAcordada" name="horaAcordada" placeholder="Hora" ng-model="formulario.Actividade.hora_ingreso" readonly>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-3 baja">Dirección</label>
						<div class=" col-md-6">
							<input type="text" name="Direccion" class="form-control" ng-model="formulario.Actividade.direccion">
						</div>
					</div>

					<div class="form-group" ng-class="{ 'has-error': !actividadesAdd.Regiones.$valid }">
						<label class="col-md-3 control-label">Región</label>
						<div class="col-md-6">
							<ui-select ng-model="formulario.Actividade.regione_id" on-select="obtComunas($select.selected.id)" name="Regiones" ng-required="!!formulario.Actividade.direccion">
								<ui-select-match placeholder="Seleccione una región">
									{{$select.selected.nombre}}
								</ui-select-match>
								<ui-select-choices repeat="region.id as region in regiones | filter: $select.search">
									<div ng-bind-html="region.nombre | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !actividadesAdd.Comunas.$valid }">
						<label class="col-md-3 control-label">Comuna</label>
						<div class="col-md-6">
							<ui-select ng-model="formulario.Actividade.comuna_id" name="Comunas" ng-required="!!formulario.Actividade.direccion">
								<ui-select-match placeholder="Seleccione una comuna">
									{{$select.selected.nombre}}
								</ui-select-match>
								<ui-select-choices repeat="comuna.id as comuna in comunas | filter: $select.search">
									<div ng-bind-html="comuna.nombre | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-md-3"><i class="fa fa-map-marker"></i> GPS</label>
						<div class="input col-md-6">
							<input type="text" name="Direccion" class="sube form-control" ng-model="formulario.Actividade.gps">
						</div>
						<div class="form-inline">
							<!--button class="btn btn-info tool sube" id="btnGps" ng-click="obtGPS()" ng-disabled="" data-toggle="tooltip" data-placement="top" title="Geo Localización">
								<i class="fa fa-search"></i>
							</button-->
						</div>
					</div>


					<div class="form-group" ng-class="{ 'has-error': !actividadesAdd.Cliente.$valid }">
						<label class="col-md-3 control-label">Seleccione Cliente</label>
						<div class="col-md-6">
							<ui-select ng-model="formulario.Actividade.cliente_id" name="Cliente">
								<ui-select-match placeholder="Seleccione Cliente">
									{{$select.selected.nombre}}
								</ui-select-match>
								<ui-select-choices repeat="cliente.id as cliente in clientes | filter: $select.search">
									<div ng-bind-html="cliente.nombre | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>							
						</div>
						<!--div calss="form-inline">
							<a href="<?php echo $this->Html->url(array('controller'=>'clientes',"action"=>"add"))?>" target="_blank" class="btn btn-primary tool" data-toggle="tooltip" data-placement="top" title="Ingresar cliente">
								<i class="fa fa-plus"></i>
							</a>
						</div-->
					</div>
					
					
				</form>
			</div>

			<div class="text-center col-md-12">
				<!--button class="btn btn-success btn-lg" ng-show="btnAgregarActividad" style="width:200px" ng-click="addActividad()"><i class="fa fa-pencil"></i> Agregar Actividad</button-->
				<button class="btn btn-primary btn-lg" ng-hide="btnAgregarActividad" style="width:200px" ng-disabled="!actividadesAdd.$valid||deshabilita" ng-click="registrarActividade()"><i class="fa fa-pencil"></i> Registrar</button>
				<!--a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a--> 
				<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a>
			</div>
			<p> &nbsp;</p>			
			<!--div id="map" style="height: 400px;"></div-->
		</div> 

	</div>
</div>
<script>$('.tool').tooltip()</script>
<?php 
	echo $this->Html->css('bootstrap-clockpicker.min');
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/actividades/controlador_actividades',
		'angularjs/servicios/actividades/servicios_actividades',
		'angularjs/servicios/clientes/clientes',
		'angularjs/servicios/servicios',		
		'bootstrap-datepicker',
		'bootstrap-clockpicker.min'
	));
?>
<script src="https://maps.googleapis.com/maps/api/js" async defer></script>