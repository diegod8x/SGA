<div class="tipoContratos view">
<h2><?php echo __('Tipo Contrato'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($tipoContrato['TipoContrato']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($tipoContrato['TipoContrato']['nombre']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Tipo Contrato'), array('action' => 'edit', $tipoContrato['TipoContrato']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Tipo Contrato'), array('action' => 'delete', $tipoContrato['TipoContrato']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $tipoContrato['TipoContrato']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Tipo Contratos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tipo Contrato'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contratos'), array('controller' => 'contratos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contrato'), array('controller' => 'contratos', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Contratos'); ?></h3>
	<?php if (!empty($tipoContrato['Contrato'])): ?>
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
	<?php foreach ($tipoContrato['Contrato'] as $contrato): ?>
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
