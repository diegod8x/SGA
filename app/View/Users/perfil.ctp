<div ng-controller="perfilEdit" ng-init="obtDatosUsers(<?php echo $this->Session->Read("PerfilUsuario.idUsuario");?>)" >
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="formUsers">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="col-md-12">
				<h4 class="col-md-offset-3" style="margin-bottom:10px">Perfil Usuario</h4>
			</div>
			<div class="row">
				<form class="form-horizontal" name="usersEdit" novalidate>	
					<div class="form-group" ng-class="{ 'has-error': !usersEdit.Nombre.$valid }">
						<label class="col-md-3 control-label baja">Trabajador</label>
						<div class="col-md-6">
							<input type="text" name="Nombre" class="form-control" ng-model="formulario.User.nombre" readonly>
						</div>
					</div>					
					<div class="form-group" ng-class="{ 'has-error': !usersEdit.Nombre.$valid }">
						<label class="col-md-3 control-label baja">Nombre usuario</label>
						<div class="col-md-6">
							<input type="text" name="Usuario" class="form-control" ng-model="formulario.User.usuario" readonly>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': (!usersEdit.Password.$valid || formulario.User.valida_password!=formulario.User.password) }" >
						<label class="col-md-3 control-label baja">Password</label>
						<div class="col-md-6">
							<input type="password" name="Password" class="form-control" ng-model="formulario.User.password" required> 
						</div>
					</div>	
					<div class="form-group" ng-class="{ 'has-error': (!usersEdit.RepitaPassword.$valid || formulario.User.valida_password!=formulario.User.password) }" >
						<label class="col-md-3 control-label baja">Repita Password</label>
						<div class="col-md-6">
							<input type="password" name="RepitaPassword" class="form-control" ng-model="formulario.User.valida_password" required> 
						</div>
					</div>	
				</form>
			</div>
			<p> &nbsp;</p>
			<div class="text-right col-md-9">
				<button class="btn btn-primary btn-lg" ng-disabled="!usersEdit.$valid || formulario.User.valida_password!=formulario.User.password" ng-click="registrarUser()"><i class="fa fa-pencil"></i> Registrar</button>
				<!--a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a--> 
			</div>
		</div>
	</div>
</div>

<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/users/lista_usuarios',
		'angularjs/servicios/users/lista_users_service',
		'angularjs/servicios/servicios',
		'angularjs/servicios/trabajadores/servicios_trabajadores',
		//'angularjs/directivas/capitalize_input',		
		'bootstrap-datepicker',
		'rut'
	));
?>
