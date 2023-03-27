<div class="contratosProductos form">
<?php echo $this->Form->create('ContratosProducto'); ?>
	<fieldset>
		<legend><?php echo __('Add Contratos Producto'); ?></legend>
	<?php
		echo $this->Form->input('contrato_id');
		echo $this->Form->input('producto_id');
		echo $this->Form->input('precio_arriendo');
		echo $this->Form->input('precio_venta');
		echo $this->Form->input('estado');
		echo $this->Form->input('observaciones');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Contratos Productos'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Contratos'), array('controller' => 'contratos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contrato'), array('controller' => 'contratos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Productos'), array('controller' => 'productos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Producto'), array('controller' => 'productos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Cobranzas'), array('controller' => 'cobranzas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cobranza'), array('controller' => 'cobranzas', 'action' => 'add')); ?> </li>
	</ul>
</div>
