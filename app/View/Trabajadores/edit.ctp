<div ng-controller="trabajadoresEdit" ng-init="obtDatosTrabajadores(<?php if(isset($this->request->pass[0])){ echo $this->request->pass[0]; }?>)">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="formTrabajadores">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="col-md-12">
				<h4 class="col-md-offset-3" style="margin-bottom:10px">Editar Trabajador</h4>
			</div>
			<div class="row">
				<form class="form-horizontal" name="trabajadoresEdit" novalidate>			
					<div class="form-group">
						<label class="col-md-3 control-label baja" for="trabajadoresRut">Rut</label>
						<div class="col-md-6" ng-class="{ 'has-error': !formulario.Trabajadore.rut }">
							<input ng-rut rut-format="live" type="text" name="Rut" id="trabajadoresRut" class="form-control" maxlength="12" ng-model="formulario.Trabajadore.rut" uppercase ng-blur="validaRut()" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label baja">Nombre</label>
						<div class="col-md-6">
							<input type="text" name="Nombre" class="form-control" ng-model="formulario.Trabajadore.nombre" capitalize-first required>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label baja">Apellido paterno</label>
						<div class="col-md-6">
							<input type="text" name="Nombre" class="form-control" ng-model="formulario.Trabajadore.apellido_paterno" capitalize-first required>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label baja">Apellido materno</label>
						<div class="col-md-6">
							<input type="text" name="Nombre" class="form-control" ng-model="formulario.Trabajadore.apellido_materno" capitalize-first required>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label baja">Teléfono</label>
						<div class="col-md-6">
							<input type="text" name="Telefono" class="form-control" uppercase ng-model="formulario.Trabajadore.telefono" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label baja">Email</label>
						<div class="col-md-6" ng-class="{ 'has-error': !trabajadoresEdit.Email.$valid }">
							<input type="email" name="Email" class="form-control" validate-email lowercase ng-model="formulario.Trabajadore.email">
						</div>
					</div>

					<div class="form-group" ng-class="{ 'has-error': !trabajadoresEdit.Estado.$valid }">
						<label class="col-md-3 control-label">Estado</label>
						<div class="col-md-6">
							<ui-select ng-model="formulario.Trabajadore.estado_trabajadore_id" name="Estado" required>
								<ui-select-match placeholder="Estado">
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
				<button class="btn btn-primary btn-lg" ng-disabled="!trabajadoresEdit.$valid||deshabilita" ng-click="registrarTrabajadore()"><i class="fa fa-pencil"></i> Registrar</button>
				<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a> 
			</div>
		</div>
	</div>
</div>

<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/trabajadores/controlador_trabajadores',
		'angularjs/servicios/trabajadores/servicios_trabajadores',
		'angularjs/servicios/servicios',
		'angularjs/directivas/uppercase',		
		'angularjs/directivas/lowercase',		
		'angularjs/directivas/capitalize',	// lowercase
		'angularjs/directivas/validate_email',
		'angularjs/directivas/rut'
	));
?>