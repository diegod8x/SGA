<div ng-controller="trabajadoresAdd" ng-init="obtDatosTrabajadores()">
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="formTrabajadores">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="col-md-12">
				<h4 class="col-md-offset-3" style="margin-bottom:10px">Registrar Trabajador</h4>
			</div>
			<div class="row">
				<form class="form-horizontal" name="trabajadoresAdd" novalidate>
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
							<input type="text" name="Nombre" class="form-control" capitalize-first ng-model="formulario.Trabajadore.apellido_materno">
						</div>
					</div>					
					<div class="form-group">
						<label class="col-md-3 control-label baja">Teléfono</label>
						<div class="col-md-6">
							<input type="text" name="Telefono" class="form-control" uppercase ng-model="formulario.Trabajadore.telefono">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label baja">Email</label>
						<div class="col-md-6" ng-class="{ 'has-error': !trabajadoresAdd.Email.$valid }">
							<input type="email" validate-email lowercase name="Email" class="form-control" ng-model="formulario.Trabajadore.email">
						</div>
					</div>
				</form>
			</div>
			<p> &nbsp;</p>
			<div class="text-right col-md-9">
				<button class="btn btn-primary btn-lg" ng-disabled="!trabajadoresAdd.$valid||deshabilita" ng-click="registrarTrabajadore()"><i class="fa fa-pencil"></i> Registrar</button>
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
