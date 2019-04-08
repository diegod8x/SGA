<div class="formaPagos view">
<h2><?php echo __('Forma Pago'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($formaPago['FormaPago']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($formaPago['FormaPago']['nombre']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Forma Pago'), array('action' => 'edit', $formaPago['FormaPago']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Forma Pago'), array('action' => 'delete', $formaPago['FormaPago']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $formaPago['FormaPago']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Forma Pagos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Forma Pago'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contratos'), array('controller' => 'contratos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contrato'), array('controller' => 'contratos', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Contratos'); ?></h3>
	<?php if (!empty($formaPago['Contrato'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Tipo Contrato Id'); ?></th>
		<th><?php echo __('Fecha Inicio'); ?></th>
		<th><?php echo __('Fecha Termino'); ?></th>
		<th><?php echo __('Fecha Cobro'); ?></th>
		<th><?php echo __('Estado'); ?></th>
		<th><?php echo __('Cliente Id'); ?></th>
		<th><?php echo __('Forma Pago Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($formaPago['Contrato'] as $contrato): ?>
		<tr>
			<td><?php echo $contrato['id']; ?></td>
			<td><?php echo $contrato['tipo_contrato_id']; ?></td>
			<td><?php echo $contrato['fecha_inicio']; ?></td>
			<td><?php echo $contrato['fecha_termino']; ?></td>
			<td><?php echo $contrato['fecha_cobro']; ?></td>
			<td><?php echo $contrato['estado']; ?></td>
			<td><?php echo $contrato['cliente_id']; ?></td>
			<td><?php echo $contrato['forma_pago_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'contratos', 'action' => 'view', $contrato['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'contratos', 'action' => 'edit', $contrato['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'contratos', 'action' => 'delete', $contrato['id']), array('confirm' => __('Are you sure you want to delete # %s?', $contrato['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Contrato'), array('controller' => 'contratos', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
