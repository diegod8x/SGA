<div class="cobranzas form">
<?php echo $this->Form->create('Cobranza'); ?>
	<fieldset>
		<legend><?php echo __('Add Cobranza'); ?></legend>
	<?php
		echo $this->Form->input('contratos_producto_id');
		echo $this->Form->input('monto_cobrado');
		echo $this->Form->input('monto_pagado');
		echo $this->Form->input('mes_cobro');
		echo $this->Form->input('fecha_pago');
		echo $this->Form->input('estado');
		echo $this->Form->input('tipo_documento_id');
		echo $this->Form->input('nro_boleta_factura');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Cobranzas'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Contratos Productos'), array('controller' => 'contratos_productos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contratos Producto'), array('controller' => 'contratos_productos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tipo Documentos'), array('controller' => 'tipo_documentos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tipo Documento'), array('controller' => 'tipo_documentos', 'action' => 'add')); ?> </li>
	</ul>
</div>
