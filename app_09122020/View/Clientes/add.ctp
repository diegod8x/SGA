<div ng-controller="clientesAdd" ng-init="obtDatos()" >
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="formClientes">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="col-md-12">
				<h4 class="col-md-offset-3" style="margin-bottom:10px">Registrar Cliente</h4>
			</div>
			<div class="row">
				<form class="form-horizontal" name="clientesAdd" novalidate>			
					<div class="form-group">
						<label class="col-md-3 control-label baja" for="clientesRut">Rut</label>
						<div class="col-md-6" ng-class="{ 'has-error': !formulario.Cliente.rut }">
							<input ng-rut rut-format="live" type="text" name="Rut" id="clientesRut" class="form-control" maxlength="12" ng-model="formulario.Cliente.rut" ng-blur="validaRut()" uppercase required>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label baja">Nombre</label>
						<div class="col-md-6" ng-class="{ 'has-error': !clientesAdd.Nombre.$valid }">
							<input type="text" name="Nombre" class="form-control" capitalize-first ng-model="formulario.Cliente.nombre" required>
						</div>
					</div>

					<div class="form-group" ng-class="{ 'has-error': !clientesAdd.Empresas.$valid }">
						<label class="col-md-3 control-label">Empresa</label>
						<div class="col-md-6">
							<ui-select ng-model="formulario.Cliente.empresa_id" name="Empresas">
								<ui-select-match placeholder="Seleccione una empresa">
									{{$select.selected.nombre}}
								</ui-select-match>	
								<ui-select-choices repeat="empresa.id as empresa in empresas | filter: $select.search">
									<div ng-bind-html="empresa.nombre | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
						<div calss="form-inline">
							<a href="<?php echo $this->Html->url(array('controller'=>'empresas',"action"=>"add"))?>" target="_blank" class="btn btn-primary tool" data-toggle="tooltip" data-placement="top" title="Ingresar empresa">
								<i class="fa fa-plus"></i>
							</a>
						</div>
					</div>


					<div class="form-group">
						<label class="col-md-3 control-label baja">Teléfono</label>
						<div class="col-md-6" ng-class="{ 'has-error': !clientesAdd.Telefono.$valid }">
							<input type="text" name="Telefono" class="form-control" ng-model="formulario.Cliente.telefono" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label baja">Teléfono 2</label>
						<div class="col-md-6">
							<input type="text" name="Telefono2" class="form-control" ng-model="formulario.Cliente.telefono2">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label baja">Teléfono 3</label>
						<div class="col-md-6">
							<input type="text" name="Telefono3" class="form-control" ng-model="formulario.Cliente.telefono3">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label baja">Email</label>
						<div class="col-md-6" ng-class="{ 'has-error': !clientesAdd.Email.$valid }">
							<input type="email" name="Email" class="form-control" validate-email lowercase ng-model="formulario.Cliente.email" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label baja">Email 2</label>
						<div class="col-md-6" ng-class="{ 'has-error': !clientesAdd.Email2.$valid }">
							<input type="email" name="Email2" class="form-control" validate-email lowercase ng-model="formulario.Cliente.email2">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label baja">Email 3</label>
						<div class="col-md-6" ng-class="{ 'has-error': !clientesAdd.Email3.$valid }">
							<input type="email" name="Email3" class="form-control" validate-email lowercase ng-model="formulario.Cliente.email3">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label baja">Dirección</label>
						<div class="col-md-6" ng-class="{ 'has-error': !clientesAdd.Direccion.$valid }">
							<input type="text" name="Direccion" class="form-control" ng-model="formulario.Cliente.direccion" required>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !clientesAdd.Regiones.$valid }">
						<label class="col-md-3 control-label">Región</label>
						<div class="col-md-6">
							<ui-select ng-model="formulario.Cliente.regione_id" on-select="obtComunas($select.selected.id)" name="Regiones" ng-required="!!formulario.Cliente.direccion">
								<ui-select-match placeholder="Seleccione un región">
									{{$select.selected.nombre}}
								</ui-select-match>
								<ui-select-choices repeat="region.id as region in regiones | filter: $select.search">
									<div ng-bind-html="region.nombre | highlight: $select.search"></div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
					<div class="form-group" ng-class="{ 'has-error': !clientesAdd.Comunas.$valid }">
						<label class="col-md-3 control-label">Comuna</label>
						<div class="col-md-6">
							<ui-select ng-model="formulario.Cliente.comuna_id" name="Comunas" ng-required="!!formulario.Cliente.direccion">
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
			<div class="text-right col-md-9">
				<button class="btn btn-primary btn-lg" ng-disabled="!clientesAdd.$valid||deshabilita" ng-click="registrarCliente()"><i class="fa fa-pencil"></i> Registrar</button>
				<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a> 
			</div>
		</div>
	</div>
</div>
<script>$('.tool').tooltip()</script>
<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/clientes/clientes',
		'angularjs/servicios/clientes/clientes',
		'angularjs/servicios/servicios',
		'angularjs/servicios/empresas/empresas',
		'angularjs/directivas/uppercase',		
		'angularjs/directivas/lowercase',		
		'angularjs/directivas/capitalize',	// lowercase
		'angularjs/directivas/validate_email',
		'angularjs/directivas/rut'
	));
?>
