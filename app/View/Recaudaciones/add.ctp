<div class="recaudaciones form">
<?php echo $this->Form->create('Recaudacione'); ?>
	<fieldset>
		<legend><?php echo __('Add Recaudacione'); ?></legend>
	<?php
		echo $this->Form->input('contrato_id');
		echo $this->Form->input('cliente_id');
		echo $this->Form->input('fecha_cobro');
		echo $this->Form->input('mes_cobro');
		echo $this->Form->input('estado');
		echo $this->Form->input('subtotal');
		echo $this->Form->input('despacho');
		echo $this->Form->input('descuento');
		echo $this->Form->input('total_cobrado');
		echo $this->Form->input('total_pagado');
		echo $this->Form->input('tipo_documento_id');
		echo $this->Form->input('nro_documento');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Recaudaciones'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Contratos'), array('controller' => 'contratos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contrato'), array('controller' => 'contratos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Clientes'), array('controller' => 'clientes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cliente'), array('controller' => 'clientes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tipo Documentos'), array('controller' => 'tipo_documentos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tipo Documento'), array('controller' => 'tipo_documentos', 'action' => 'add')); ?> </li>
	</ul>
</div>
