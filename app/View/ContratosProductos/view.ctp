<div class="contratosProductos view">
<h2><?php echo __('Contratos Producto'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($contratosProducto['ContratosProducto']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Contrato'); ?></dt>
		<dd>
			<?php echo $this->Html->link($contratosProducto['Contrato']['id'], array('controller' => 'contratos', 'action' => 'view', $contratosProducto['Contrato']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Producto'); ?></dt>
		<dd>
			<?php echo $this->Html->link($contratosProducto['Producto']['id'], array('controller' => 'productos', 'action' => 'view', $contratosProducto['Producto']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Precio Arriendo'); ?></dt>
		<dd>
			<?php echo h($contratosProducto['ContratosProducto']['precio_arriendo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Precio Venta'); ?></dt>
		<dd>
			<?php echo h($contratosProducto['ContratosProducto']['precio_venta']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado'); ?></dt>
		<dd>
			<?php echo h($contratosProducto['ContratosProducto']['estado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Observaciones'); ?></dt>
		<dd>
			<?php echo h($contratosProducto['ContratosProducto']['observaciones']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Contratos Producto'), array('action' => 'edit', $contratosProducto['ContratosProducto']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Contratos Producto'), array('action' => 'delete', $contratosProducto['ContratosProducto']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $contratosProducto['ContratosProducto']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Contratos Productos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contratos Producto'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contratos'), array('controller' => 'contratos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contrato'), array('controller' => 'contratos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Productos'), array('controller' => 'productos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Producto'), array('controller' => 'productos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cobranzas'), array('controller' => 'cobranzas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cobranza'), array('controller' => 'cobranzas', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Cobranzas'); ?></h3>
	<?php if (!empty($contratosProducto['Cobranza'])): ?>
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
	<?php foreach ($contratosProducto['Cobranza'] as $cobranza): ?>
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
