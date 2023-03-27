<div ng-controller="direccionesAdd" ng-init="obtData(<?php if (isset($this->request->pass[0])) {
																												echo $this->request->pass[0];
																											} ?>)">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="formDirecciones">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="col-md-12">
				<h4 class="col-md-offset-1" style="margin-bottom:10px">Registrar Dirección</h4>
			</div>
			<div class="row">
				<form class="form-horizontal" name="direccionesAdd" novalidate>

					<div class="form-group" ng-class="{ 'has-error': !direccionesAdd.Clientes.$valid }">
						<label class="col-md-3 control-label">Cliente</label>
						<div class="col-md-6">
							<ui-select ng-model="formulario.Direccione.cliente_id" name="Clientes" theme="bootstrap" required>
								<ui-select-match placeholder="Busque un cliente">
									{{$select.selected.nombre}}
								</ui-select-match>
								<ui-select-choices refresh-delay="0" repeat="cliente.id as cliente in (clientes | filter: $select.search)  | limitTo: limitTitleSearch" refresh="checkTitle($select.search)">
									<div ng-bind-html="cliente.nombre | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label baja">Dirección</label>
						<div class="col-md-6">
							<input type="text" name="Dirección" class="form-control" capitalize-first ng-model="formulario.Direccione.nombre" required>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !direccionesAdd.Regiones.$valid }">
						<label class="col-md-3 control-label">Región</label>
						<div class="col-md-6">
							<ui-select ng-model="formulario.Direccione.regione_id" on-select="obtComunas($select.selected.id)" name="Regiones" ng-required="!!formulario.Direccione.nombre">
								<ui-select-match placeholder="Seleccione una región">
									{{$select.selected.nombre}}
								</ui-select-match>
								<ui-select-choices repeat="region.id as region in regiones | filter: $select.search">
									<div ng-bind-html="region.nombre | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !direccionesAdd.Comunas.$valid }">
						<label class="col-md-3 control-label">Comuna</label>
						<div class="col-md-6">
							<ui-select ng-model="formulario.Direccione.comuna_id" name="Comunas" ng-required="!!formulario.Direccione.nombre">
								<ui-select-match placeholder="Seleccione un comuna">
									{{$select.selected.nombre}}
								</ui-select-match>
								<ui-select-choices repeat="comuna.id as comuna in comunas | filter: $select.search">
									<div ng-bind-html="comuna.nombre | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
				</form>
			</div>
			<p> &nbsp;</p>
			<p> &nbsp;</p>
			<div class="text-right col-md-9">
				<button class="btn btn-primary btn-lg" ng-disabled="!direccionesAdd.$valid||deshabilita" ng-click="registrarDireccion()"><i class="fa fa-pencil"></i> Registrar</button>
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
	'angularjs/servicios/clientes/clientes',
	'angularjs/servicios/servicios',
	'angularjs/directivas/uppercase',
	'angularjs/directivas/lowercase',
	'angularjs/directivas/capitalize',	// lowercase
	'angularjs/directivas/validate_email',
	'angularjs/directivas/rut'
));
?>