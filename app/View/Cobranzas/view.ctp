<div>
	<table class="table">
		<tr>
			<th># Contrato</th>
			<th>Tipo Contrato</th>
			<th>Fecha Cobro</th>
			<th>Producto</th>
			<th>Tipo Documento</th>
			<th>Nro. Documento</th>
			<th>Precio</th>
			<th></th>
		</tr>

		<?php foreach ($cobranzas as $cobranza) { ?>

			<tr>			
				<td><?php echo h($cobranza['Contrato']['id']); ?></td>
				<td><?php echo h($cobranza['TipoContrato']['nombre']); ?></td>
				<td><?php echo h($cobranza['Cobranza']['fecha_cobro']); ?></td>
				<td><?php echo h($cobranza['Producto']['nombre']); ?></td>
				<td><?php echo h($cobranza['TipoDocumento']['nombre']); ?></td>
				<td><?php echo h($cobranza['Cobranza']['nro_documetno']); ?></td>
				<td><?php echo h($cobranza['Cobranza']['estado']); ?></td>
				<td><?php echo h($cobranza['Cobranza']['estado']); ?></td>
			</tr>

		<?php } ?>
	</table>
</div>


