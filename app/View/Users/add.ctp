<div ng-controller="usersAdd" ng-init="obtDatosUsers()" >
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="formUsers">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="col-md-12">
				<h4 class="col-md-offset-1" style="margin-bottom:10px">Registrar Usuario</h4>
			</div>
			<div class="row">
				<form class="form-horizontal" name="usersAdd" novalidate>	
					<div class="form-group" ng-class="{ 'has-error': !usersAdd.Trabajadores.$valid }">
						<label class="col-md-3 control-label">Trabajador</label>
						<div class="col-md-6">
							<ui-select ng-model="formulario.User.trabajadore_id" name="Trabajadores" on-select="setPassword($select.selected)" required>
								<ui-select-match placeholder="Seleccione un trabajador" >
									{{$select.selected.nombre_completo}}
								</ui-select-match>
								<ui-select-choices repeat="trabajador.id as trabajador in trabajadores | filter: $select.search">
									<div ng-bind-html="trabajador.nombre_completo | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>					
					<div class="form-group" ng-class="{ 'has-error': !usersAdd.Nombre.$valid }">
						<label class="col-md-3 control-label baja">Nombre usuario</label>
						<div class="col-md-6">
							<input type="text" name="Nombre" class="form-control" ng-model="formulario.User.usuario" required>
						</div>
					</div>						
					<div class="form-group" ng-class="{ 'has-error': !usersAdd.Password.$valid }">
						<label class="col-md-3 control-label baja">Password</label>
						<div class="col-md-6">
							<input type="password" name="Password" class="form-control" ng-model="formulario.User.password" required readonly> 
						</div>
					</div>	
					<div class="form-group" ng-class="{ 'has-error': !usersAdd.Roles.$valid }" >
						<label class="col-md-3 control-label">Rol</label>
						<div class="col-md-6">
							<ui-select ng-model="formulario.User.role_id" name="Roles" required>
								<ui-select-match placeholder="Seleccione un rol" >
									{{$select.selected.Nombre}}
								</ui-select-match>
								<ui-select-choices repeat="rol.Id as rol in roles | filter: $select.search">
									<div ng-bind-html="rol.Nombre | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
				</form>
			</div>
			<p> &nbsp;</p>
			<div class="text-right col-md-9">
				<button class="btn btn-primary btn-lg" ng-disabled="!usersAdd.$valid" ng-click="registrarUser()"><i class="fa fa-pencil"></i> Registrar</button>
				<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a> 
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
