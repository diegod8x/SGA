<div class="direcciones view">
<h2><?php echo __('Direccione'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($direccione['Direccione']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($direccione['Direccione']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Regione'); ?></dt>
		<dd>
			<?php echo $this->Html->link($direccione['Regione']['id'], array('controller' => 'regiones', 'action' => 'view', $direccione['Regione']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comuna'); ?></dt>
		<dd>
			<?php echo $this->Html->link($direccione['Comuna']['id'], array('controller' => 'comunas', 'action' => 'view', $direccione['Comuna']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cliente'); ?></dt>
		<dd>
			<?php echo $this->Html->link($direccione['Cliente']['id'], array('controller' => 'clientes', 'action' => 'view', $direccione['Cliente']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Direccione'), array('action' => 'edit', $direccione['Direccione']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Direccione'), array('action' => 'delete', $direccione['Direccione']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $direccione['Direccione']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Direcciones'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Direccione'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Regiones'), array('controller' => 'regiones', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Regione'), array('controller' => 'regiones', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Comunas'), array('controller' => 'comunas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Comuna'), array('controller' => 'comunas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Clientes'), array('controller' => 'clientes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cliente'), array('controller' => 'clientes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contratos'), array('controller' => 'contratos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contrato'), array('controller' => 'contratos', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Contratos'); ?></h3>
	<?php if (!empty($direccione['Contrato'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Tipo Contrato Id'); ?></th>
		<th><?php echo __('Fecha Inicio'); ?></th>
		<th><?php echo __('Fecha Termino'); ?></th>
		<th><?php echo __('Fecha Cobro'); ?></th>
		<th><?php echo __('Estado'); ?></th>
		<th><?php echo __('Cliente Id'); ?></th>
		<th><?php echo __('Direccione Id'); ?></th>
		<th><?php echo __('Forma Pago Id'); ?></th>
		<th><?php echo __('Cantidad Productos'); ?></th>
		<th><?php echo __('Subtotal'); ?></th>
		<th><?php echo __('Costo Despacho'); ?></th>
		<th><?php echo __('Descuento'); ?></th>
		<th><?php echo __('Garantia'); ?></th>
		<th><?php echo __('Precio Total'); ?></th>
		<th><?php echo __('Cobrar Despacho'); ?></th>
		<th><?php echo __('Cobrar Descuento'); ?></th>
		<th><?php echo __('Numero Cuota Id'); ?></th>
		<th><?php echo __('Created User'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified User'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($direccione['Contrato'] as $contrato): ?>
		<tr>
			<td><?php echo $contrato['id']; ?></td>
			<td><?php echo $contrato['tipo_contrato_id']; ?></td>
			<td><?php echo $contrato['fecha_inicio']; ?></td>
			<td><?php echo $contrato['fecha_termino']; ?></td>
			<td><?php echo $contrato['fecha_cobro']; ?></td>
			<td><?php echo $contrato['estado']; ?></td>
			<td><?php echo $contrato['cliente_id']; ?></td>
			<td><?php echo $contrato['direccione_id']; ?></td>
			<td><?php echo $contrato['forma_pago_id']; ?></td>
			<td><?php echo $contrato['cantidad_productos']; ?></td>
			<td><?php echo $contrato['subtotal']; ?></td>
			<td><?php echo $contrato['costo_despacho']; ?></td>
			<td><?php echo $contrato['descuento']; ?></td>
			<td><?php echo $contrato['garantia']; ?></td>
			<td><?php echo $contrato['precio_total']; ?></td>
			<td><?php echo $contrato['cobrar_despacho']; ?></td>
			<td><?php echo $contrato['cobrar_descuento']; ?></td>
			<td><?php echo $contrato['numero_cuota_id']; ?></td>
			<td><?php echo $contrato['created_user']; ?></td>
			<td><?php echo $contrato['created']; ?></td>
			<td><?php echo $contrato['modified_user']; ?></td>
			<td><?php echo $contrato['modified']; ?></td>
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
