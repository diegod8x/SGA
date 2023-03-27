<div class="historicoPagos index">
	<h2><?php echo __('Historico Pagos'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('contratos_producto_id'); ?></th>
			<th><?php echo $this->Paginator->sort('monto_cobrado'); ?></th>
			<th><?php echo $this->Paginator->sort('monto_pagado'); ?></th>
			<th><?php echo $this->Paginator->sort('mes_cobro'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha_pago'); ?></th>
			<th><?php echo $this->Paginator->sort('estado'); ?></th>
			<th><?php echo $this->Paginator->sort('tipo_documento_id'); ?></th>
			<th><?php echo $this->Paginator->sort('nro_boleta_factura'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($historicoPagos as $historicoPago): ?>
	<tr>
		<td><?php echo h($historicoPago['HistoricoPago']['id']); ?>&nbsp;</td>
		<td><?php echo h($historicoPago['HistoricoPago']['contratos_producto_id']); ?>&nbsp;</td>
		<td><?php echo h($historicoPago['HistoricoPago']['monto_cobrado']); ?>&nbsp;</td>
		<td><?php echo h($historicoPago['HistoricoPago']['monto_pagado']); ?>&nbsp;</td>
		<td><?php echo h($historicoPago['HistoricoPago']['mes_cobro']); ?>&nbsp;</td>
		<td><?php echo h($historicoPago['HistoricoPago']['fecha_pago']); ?>&nbsp;</td>
		<td><?php echo h($historicoPago['HistoricoPago']['estado']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($historicoPago['TipoDocumento']['id'], array('controller' => 'tipo_documentos', 'action' => 'view', $historicoPago['TipoDocumento']['id'])); ?>
		</td>
		<td><?php echo h($historicoPago['HistoricoPago']['nro_boleta_factura']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $historicoPago['HistoricoPago']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $historicoPago['HistoricoPago']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $historicoPago['HistoricoPago']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $historicoPago['HistoricoPago']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
		'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Historico Pago'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Tipo Documentos'), array('controller' => 'tipo_documentos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tipo Documento'), array('controller' => 'tipo_documentos', 'action' => 'add')); ?> </li>
	</ul>
</div>
