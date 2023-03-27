<form ng-controller="reporteClientes" ng-submit="buscarCliente()" ng-cloak>
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="tablaDetalle">
		
		<div class="row">			
			<div class="col-md-2" >
			</div>
			<div class="col-md-8" style="margin-top:-5px">		
				<div class="input-group">
					<!--input type="text" class="form-control" placeholder="Buscar Rut Cliente" ng-model="clientesRut"-->
					<input ng-rut rut-format="live" type="text" name="Rut" id="clientesRut" class="form-control" maxlength="12" ng-model="clientesRut" ng-blur="validaRut()" placeholder="Buscar Rut Cliente" required>
					<span class="input-group-btn">
						<button class="btn btn-default" type="submit">Buscar</button>
					</span>					
				</div>
			</div>	
			<div class="col-md-2" >
			</div>	
		</div>		

		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-5">				
				<h5>Cliente</h5>				
				<table class="table table-bordered table-hover table-condensed">
					<tr>
						<th class="text-right" style="width:130px">Nombre</th>
						<td>{{formulario.Cliente.nombre}}</td>	
					</tr>
					<tr>
						<th class="text-right">Dirección</th>
						<td>{{formulario.Cliente.ds_direccion}}</td>
					</tr>
					<tr>
						<th class="text-right">Teléfonos</th>
						<td>{{formulario.Cliente.ds_telefono}}</td>
					</tr>
					<tr>
						<th class="text-right">Correos</th>
						<td>{{formulario.Cliente.ds_email}}</td>
					</tr>
					<tr>
						<th class="text-right">Estado</th>
						<td>{{formulario.Cliente.ds_estado}}</td>
					</tr>	
				</table>
			</div>	


			<div class="col-md-5">
				<h5>Empresa</h5>
				<table class="table table-bordered table-hover table-condensed">
					<tr>
						<th class="text-right" style="width:130px">Empresa</th>
						<td>{{formulario.Empresa.nombre}}</td>	
					</tr>
					<tr>
						<th class="text-right">Telefono</th>
						<td>{{formulario.Empresa.telefono}}</td>
					</tr>
					<tr>
						<th class="text-right">Email</th>
						<td>{{formulario.Empresa.email}}</td>
					</tr>
					<tr>
						<th class="text-right">Contacto</th>
						<td>{{formulario.Empresa.ds_contacto}}</td>
					</tr>
					<tr>
						<th class="text-right">Observaciones</th>
						<td>{{formulario.Empresa.observaciones}}</td>
					</tr>
				</table>
			</div>		
			<div class="col-md-1"></div>
		</div>

		<div class="row" ng-show="true">
			<div class="col-md-1" >
			</div>

			<div class="col-md-10" >
				
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
					
					<a class="nav-link active" id="contratos-tab" data-toggle="tab" href="#contratos" role="tab" aria-controls="contratos" aria-selected="true">
						<i class="fa fa-file"></i>&nbsp;Contratos
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="productos-tab" data-toggle="tab" href="#productos" role="tab" aria-controls="productos" aria-selected="false">
					<i class="fa fa-bed"></i>&nbsp;Productos
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="pagos-tab" data-toggle="tab" href="#pagos" role="tab" aria-controls="pagos" aria-selected="false">
						<i class="fa fa-credit-card"></i>&nbsp;Pagos
					</a>
				</li>
				</ul>
				<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade active in" id="contratos" role="tabpanel" aria-labelledby="contratos-tab">
					<div ui-i18n="{{lang}}">
						<div ui-grid="gridOptionsContratos" ui-grid-exporter ui-grid-auto-resize ui-grid-resize-columns ng-model="grid" class="grid" style="height:300px;"></div>
					</div>
				</div>
				<div class="tab-pane fade" id="productos" role="tabpanel" aria-labelledby="productos-tab">
					<div ui-i18n="{{lang}}">
						<div ui-grid="gridOptionsProductos" ui-grid-exporter ui-grid-auto-resize ui-grid-resize-columns ng-model="grid" class="grid" style="height:300px;"></div>
					</div>
				</div>
				<div class="tab-pane fade" id="pagos" role="tabpanel" aria-labelledby="pagos-tab">
					<div ui-i18n="{{lang}}">
						<div ui-grid="gridOptionsPagos" ui-grid-exporter ui-grid-auto-resize ui-grid-resize-columns ng-model="grid" class="grid" style="height:300px;"></div>
					</div>
				</div>
				</div>
			</div>
			<div class="col-md-1" >
			</div>			
		</div>		
	</div>
</form>
<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/clientes/clientes',
		'angularjs/servicios/clientes/clientes',
		'angularjs/servicios/servicios',		
		//'angularjs/directivas/capitalize_input',		
		//'bootstrap-datepicker',
		'rut'
	));
?>
<script>$('.tool').tooltip()</script>