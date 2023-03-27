<div ng-controller="cobranzaPagos" ng-init="obtDatos()" >
	<p ng-bind-html="cargador" ng-show="loader"></p>
	<div ng-show="formPagos">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="col-md-12">
				<h4 class="col-md-offset-3" style="margin-bottom:10px">Pagos</h4>
			</div>
			<div class="row">
				<form class="form-horizontal" name="cobranzasUpd" novalidate>	
				{{formulario.Cobranza}}
					<table class="table table-condensed" >
						<thead>
							<tr>
								<th># Contrato</th>
								<th>Tipo Contrato</th>
								<th>Producto</th>
								<th>Fecha Cobro</th>
								<th>Tipo Documento</th>
								<th>Nro. Documento</th>
								<th>Precio</th>
								<th></th>
							</tr>
						</thead>
						<tbody >
							<tr ng-repeat="cobranza in formulario.Cobranza">
								<td ng-model="formulario.Cobranza.contrato_id">{{cobranza.contrato_id}}</td>
								<td ng-model="formulario.Cobranza.tipo_contrato_id">{{cobranza.tipo_contrato}}</td>
								<td>{{cobranza.nombre_producto}}</td>
								<td ng-model="formulario.Cobranza.fecha_cobro">{{cobranza.fecha_cobro}}</td>
								<td >
									
								</td>
								<td>
									
								</td>
								<td>{{cobranza.monto_cobrado | number:0}}</td>
								<td>
									
								</td>
							</tr>
						</tbody>
					</table>

				</form>	
			</div>
			<p> &nbsp;</p>
			<div class="text-right col-md-9">
				<button class="btn btn-primary btn-lg" ng-disabled="!cobranzasUpd.$valid" ng-click="registrarPagos()"><i class="fa fa-pencil"></i> Registrar</button>
				<!--a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a--> 
			</div>
		</div>
	</div>
</div>

<script>$('.tool').tooltip()</script>
<?php 
	echo $this->Html->script(array(
		'angularjs/controladores/app',
		'angularjs/controladores/cobranzas/controlador_cobranzas',
		'angularjs/servicios/cobranzas/servicios_cobranzas',	
		'angularjs/servicios/servicios',	
		'angularjs/directivas/uppercase',		
		'angularjs/directivas/lowercase',		
		'angularjs/directivas/capitalize',	// lowercase
		'angularjs/directivas/validate_email',
		'angularjs/directivas/rut'
	));
?>

