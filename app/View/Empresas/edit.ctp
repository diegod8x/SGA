<div ng-controller="empresasEdit" ng-init="obtDatos(<?php if(isset($this->request->pass[0])){ echo $this->request->pass[0]; }?>)">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="formEmpresas">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="col-md-12">
				<h4 class="col-md-offset-1" style="margin-bottom:10px">Editar empresa</h4>
			</div>
			<div class="row">
				<form class="form-horizontal" name="empresasEdit" novalidate>			
					<div class="form-group">
						<label class="col-md-3 control-label baja" for="empresasRut">Rut</label>
						<div class="col-md-6" ng-class="{ 'has-error': !formulario.Empresa.rut }">
							<input ng-rut rut-format="live" type="text" name="Rut" id="empresasRut" class="form-control" maxlength="12" ng-model="formulario.Empresa.rut" ng-blur="validaRut()" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label baja">Nombre</label>
						<div class="col-md-6">
							<input type="text" name="Nombre" class="form-control" ng-model="formulario.Empresa.nombre" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label baja">Teléfono</label>
						<div class="col-md-6">
							<input type="text" name="Telefono" class="form-control" ng-model="formulario.Empresa.telefono" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label baja">Email</label>
						<div class="col-md-6" ng-class="{ 'has-error': !empresasEdit.Email.$valid }">
							<input type="email" name="Email" class="form-control" ng-model="formulario.Empresa.email">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label baja">Dirección</label>
						<div class="col-md-6">
							<input type="text" name="Direccion" class="form-control" ng-model="formulario.Empresa.direccion" required>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !empresasEdit.Regiones.$valid }">
						<label class="col-md-3 control-label">Región</label>
						<div class="col-md-6">
							<ui-select ng-model="formulario.Empresa.regione_id" on-select="obtComunas($select.selected.id)" name="Regiones" ng-required="!!formulario.Empresa.direccion">
								<ui-select-match placeholder="Seleccione un región">
									{{$select.selected.nombre}}
								</ui-select-match>
								<ui-select-choices repeat="region.id as region in regiones | filter: $select.search">
									<div ng-bind-html="region.nombre | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !empresasEdit.Comunas.$valid }">
						<label class="col-md-3 control-label">Comuna</label>
						<div class="col-md-6">
							<ui-select ng-model="formulario.Empresa.comuna_id" name="Comunas" ng-required="!!formulario.Empresa.direccion">
								<ui-select-match placeholder="Seleccione un comuna">
									{{$select.selected.nombre}}
								</ui-select-match>
								<ui-select-choices repeat="comuna.id as comuna in comunas | filter: $select.search">
									<div ng-bind-html="comuna.nombre | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label baja">Nombre Contacto</label>
						<div class="col-md-6">
							<input type="text" name="NombreContacto" class="form-control" ng-model="formulario.Empresa.nombre_contacto" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label baja">Teléfono Contacto</label>
						<div class="col-md-6">
							<input type="text" name="TelefonoContacto" class="form-control" ng-model="formulario.Empresa.telefono_contacto" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label baja">Observaciones</label>
						<div class="col-md-6">
							<textarea type="text" class="form-control sube col-md-6" name="Observaciones"
						 ng-model="formulario.Empresa.observaciones"></textarea>
						</div>
					</div>
				</form>
			</div>
			<p> &nbsp;</p>
			<div class="text-right col-md-9">
				<button class="btn btn-primary btn-lg" ng-disabled="!empresasEdit.$valid||deshabilita" ng-click="registrarEmpresa()"><i class="fa fa-pencil"></i> Registrar</button>
				<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a> 
			</div>
		</div>
	</div>
</div>

<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/empresas/empresas',
		'angularjs/servicios/empresas/empresas',
		'angularjs/servicios/servicios',
		//'angularjs/directivas/capitalize_input',		
		'bootstrap-datepicker',
		'rut'
	));
?>