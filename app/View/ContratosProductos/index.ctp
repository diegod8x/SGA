<div class="contratosProductos index">
	<h2><?php echo __('Contratos Productos'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('contrato_id'); ?></th>
			<th><?php echo $this->Paginator->sort('producto_id'); ?></th>
			<th><?php echo $this->Paginator->sort('precio_arriendo'); ?></th>
			<th><?php echo $this->Paginator->sort('precio_venta'); ?></th>
			<th><?php echo $this->Paginator->sort('estado'); ?></th>
			<th><?php echo $this->Paginator->sort('observaciones'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($contratosProductos as $contratosProducto): ?>
	<tr>
		<td><?php echo h($contratosProducto['ContratosProducto']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($contratosProducto['Contrato']['id'], array('controller' => 'contratos', 'action' => 'view', $contratosProducto['Contrato']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($contratosProducto['Producto']['id'], array('controller' => 'productos', 'action' => 'view', $contratosProducto['Producto']['id'])); ?>
		</td>
		<td><?php echo h($contratosProducto['ContratosProducto']['precio_arriendo']); ?>&nbsp;</td>
		<td><?php echo h($contratosProducto['ContratosProducto']['precio_venta']); ?>&nbsp;</td>
		<td><?php echo h($contratosProducto['ContratosProducto']['estado']); ?>&nbsp;</td>
		<td><?php echo h($contratosProducto['ContratosProducto']['observaciones']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $contratosProducto['ContratosProducto']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $contratosProducto['ContratosProducto']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $contratosProducto['ContratosProducto']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $contratosProducto['ContratosProducto']['id']))); ?>
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
		<li><?php echo $this->Html->link(__('New Contratos Producto'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Contratos'), array('controller' => 'contratos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contrato'), array('controller' => 'contratos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Productos'), array('controller' => 'productos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Producto'), array('controller' => 'productos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cobranzas'), array('controller' => 'cobranzas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cobranza'), array('controller' => 'cobranzas', 'action' => 'add')); ?> </li>
	</ul>
</div>
