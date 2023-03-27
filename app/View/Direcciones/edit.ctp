<div ng-controller="direccionesEdit" ng-init="obtData(<?php if (isset($this->request->pass[0])) {
															echo $this->request->pass[0];
														} ?>)">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="formDirecciones">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="col-md-12">
				<h4 class="col-md-offset-1" style="margin-bottom:10px">Editar dirección</h4>
			</div>
			<div class="row">
				<form class="form-horizontal" name="direccionesEdit" novalidate>
					<div class="form-group" ng-class="{ 'has-error': !direccionesEdit.Clientes.$valid }">
						<label class="col-md-3 control-label">Clientes</label>
						<div class="col-md-6">
							<ui-select ng-model="formulario.Direccione.cliente_id" name="Clientes" theme="bootstrap" ng-disabled="true" required>
								<ui-select-match placeholder="Busque un cliente">
									{{$select.selected.nombre}}
								</ui-select-match>
								<ui-select-choices refresh-delay="0" repeat="cliente.id as cliente in clientes | filter: $select.search" readonly="readonly">
									<div ng-bind-html="cliente.nombre | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label baja">Dirección</label>
						<div class="col-md-6">
							<input type="text" name="Direccion" class="form-control" ng-model="formulario.Direccione.nombre" required>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !direccionesEdit.Regiones.$valid }">
						<label class="col-md-3 control-label">Región</label>
						<div class="col-md-6">
							<ui-select ng-model="formulario.Direccione.regione_id" on-select="obtComunas($select.selected.id)" name="Regiones" ng-required="!!formulario.Direccione.direccion">
								<ui-select-match placeholder="Seleccione un región">
									{{$select.selected.nombre}}
								</ui-select-match>
								<ui-select-choices repeat="region.id as region in regiones | filter: $select.search">
									<div ng-bind-html="region.nombre | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !direccionesEdit.Comunas.$valid }">
						<label class="col-md-3 control-label">Comuna</label>
						<div class="col-md-6">
							<ui-select ng-model="formulario.Direccione.comuna_id" name="Comunas" ng-required="!!formulario.Direccione.direccion">
								<ui-select-match placeholder="Seleccione un comuna">
									{{$select.selected.nombre}}
								</ui-select-match>
								<ui-select-choices repeat="comuna.id as comuna in comunas | filter: $select.search">
									<div ng-bind-html="comuna.nombre | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !direccionesEdit.Estado.$valid }">
						<label class="col-md-3 control-label">Estado</label>
						<div class="col-md-6">
							<ui-select ng-model="formulario.Direccione.estado" name="Estado">
								<ui-select-match placeholder="Seleccione un estado">
									{{$select.selected.nombre}}
								</ui-select-match>
								<ui-select-choices repeat="estado.id as estado in estados | filter: $select.search">
									<div ng-bind-html="estado.nombre | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
				</form>
			</div>
			<p> &nbsp;</p>
			<div class="text-right col-md-9">
				<button class="btn btn-primary btn-lg" ng-disabled="!direccionesEdit.$valid||deshabilita" ng-click="registrarDireccion()"><i class="fa fa-pencil"></i> Registrar</button>
				<a href="<?php echo $this->Html->url(array("action" => "index")) ?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a>
			</div>
		</div>
	</div>
</div>

<?php
echo $this->Html->script(array(
	'angularjs/controladores/app',
	'angularjs/controladores/direcciones/direcciones',
	'angularjs/servicios/direcciones/direcciones',
	'angularjs/servicios/servicios',
	'angularjs/servicios/clientes/clientes',
	'bootstrap-datepicker',
	'rut'
));
?>