<div class="historicoPagos form">
<?php echo $this->Form->create('HistoricoPago'); ?>
	<fieldset>
		<legend><?php echo __('Add Historico Pago'); ?></legend>
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

		<li><?php echo $this->Html->link(__('List Historico Pagos'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Tipo Documentos'), array('controller' => 'tipo_documentos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tipo Documento'), array('controller' => 'tipo_documentos', 'action' => 'add')); ?> </li>
	</ul>
</div>
