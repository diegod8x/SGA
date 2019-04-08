<div class="tipoDocumentos view">
<h2><?php echo __('Tipo Documento'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($tipoDocumento['TipoDocumento']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($tipoDocumento['TipoDocumento']['nombre']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Tipo Documento'), array('action' => 'edit', $tipoDocumento['TipoDocumento']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Tipo Documento'), array('action' => 'delete', $tipoDocumento['TipoDocumento']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $tipoDocumento['TipoDocumento']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Tipo Documentos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tipo Documento'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cobranzas'), array('controller' => 'cobranzas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cobranza'), array('controller' => 'cobranzas', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Cobranzas'); ?></h3>
	<?php if (!empty($tipoDocumento['Cobranza'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Contratos Producto Id'); ?></th>
		<th><?php echo __('Monto Cobrado'); ?></th>
		<th><?php echo __('Monto Pagado'); ?></th>
		<th><?php echo __('Mes Cobro'); ?></th>
		<th><?php echo __('Fecha Pago'); ?></th>
		<th><?php echo __('Estado'); ?></th>
		<th><?php echo __('Tipo Documento Id'); ?></th>
		<th><?php echo __('Nro Boleta Factura'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($tipoDocumento['Cobranza'] as $cobranza): ?>
		<tr>
			<td><?php echo $cobranza['id']; ?></td>
			<td><?php echo $cobranza['contratos_producto_id']; ?></td>
			<td><?php echo $cobranza['monto_cobrado']; ?></td>
			<td><?php echo $cobranza['monto_pagado']; ?></td>
			<td><?php echo $cobranza['mes_cobro']; ?></td>
			<td><?php echo $cobranza['fecha_pago']; ?></td>
			<td><?php echo $cobranza['estado']; ?></td>
			<td><?php echo $cobranza['tipo_documento_id']; ?></td>
			<td><?php echo $cobranza['nro_boleta_factura']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'cobranzas', 'action' => 'view', $cobranza['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'cobranzas', 'action' => 'edit', $cobranza['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'cobranzas', 'action' => 'delete', $cobranza['id']), array('confirm' => __('Are you sure you want to delete # %s?', $cobranza['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Cobranza'), array('controller' => 'cobranzas', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
