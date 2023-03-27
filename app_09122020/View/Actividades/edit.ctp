<div ng-controller="actividadesEdit" ng-init="obtDatos(<?php if(isset($this->request->pass[0])){ echo $this->request->pass[0]; }?>)" >
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="formActividades">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<h4 class="col-md-offset-3" style="margin-bottom:20px">Editar Actividad</h4>
				</div>
				<form role="form" class="form-horizontal" name="actividadesEdit" novalidate>				
					<div class="form-group" ng-class="{ 'has-error': !actividadesEdit.TipoActividade.$valid }">
						<label class="control-label col-md-3">Tipo Actividad</label>
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

					<div class="form-group" ng-class="{ 'has-error': !actividadesEdit.Trabajador.$valid }">
						<label class="col-md-3 control-label">Trabajador</label>
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
					</div>	

					<div class="form-group" ng-class="{ 'has-error': !actividadesEdit.Observaciones.$valid }">
						<label class="col-md-3 control-label baja">Observaciones</label>
						<div class="col-md-6">
							<textarea type="text" class="form-control sube col-md-6" name="Observaciones"
						 ng-model="formulario.Actividade.observaciones" required></textarea>
						</div>
					</div>

					<div class="form-group" ng-class="{ 'has-error': !actividadesEdit.fechaActividad.$valid }">
						<label class="control-label col-md-3">Fecha Actividad</label>
						<div class="input col-md-6">
							<input class="form-control datepicker readonly-pointer-background sube" readonly="readonly" id="fechaActividad" name="fechaActividad" ng-model="formulario.Actividade.fecha_ingreso" placeholder="Fecha" style="padding-left: 12px;" required>
						</div>
					</div>

					<div class="form-group">
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

					<div class="form-group" ng-class="{ 'has-error': !actividadesEdit.Regiones.$valid }">
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
					<div class="form-group" ng-class="{ 'has-error': !actividadesEdit.Comunas.$valid }">
						<label class="col-md-3 control-label">Comuna</label>
						<div class="col-md-6">
							<ui-select ng-model="formulario.Actividade.comuna_id" name="Comunas" ng-required="!!formulario.Actividade.direccion" >
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
							<!--button class="btn btn-info tool sube" ng-click="obtGPS()" ng-disabled="" data-toggle="tooltip" data-placement="top" title="Geo Localización">
								<i class="fa fa-search"></i>
							</button-->
						</div>
					</div>

					<div class="form-group" ng-class="{ 'has-error': !actividadesEdit.Cliente.$valid }">
						<label class="col-md-3 control-label">Cliente</label>
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
					</div>
					
					<div class="form-group" ng-class="{ 'has-error': !actividadesEdit.EstadoActividade.$valid }">
						<label class="col-md-3 control-label">Estado</label>
						<div class="col-md-6">
							<ui-select ng-model="formulario.Actividade.estado_actividade_id" name="EstadoActividade" required>
								<ui-select-match placeholder="Seleccione un estado">
									{{$select.selected.nombre}}
								</ui-select-match>
								<ui-select-choices repeat="estado.id as estado in estadoActividades | filter: $select.search">
									<div ng-bind-html="estado.nombre | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
					
					
				</form>
			</div>

			<div class="text-center col-md-12">
				<button class="btn btn-primary btn-lg" ng-hide="btnAgregarActividad" ng-disabled="!actividadesEdit.$valid||deshabilita" ng-click="registrarActividade()"><i class="fa fa-pencil"></i> Editar</button>
				<a href="<?php echo $this->request->referer();?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a> 
			</div>
			<p> &nbsp;</p>			
			<!--div id="map" style="height: 400px;"></div-->
		</div> 
	</div>
</div>

<?php 
	echo $this->Html->css('bootstrap-clockpicker.min');
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/actividades/controlador_actividades',
		'angularjs/servicios/actividades/servicios_actividades',
		'angularjs/servicios/servicios',		
		'bootstrap-datepicker',
		'bootstrap-clockpicker.min'
	));
?>
<!--script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDazQ4qIZsdw9Cyrs2aIJIULIU0OnejBcY&callback=initMap" async defer></script-->