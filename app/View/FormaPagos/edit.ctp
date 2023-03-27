<div class="formaPagos form">
<?php echo $this->Form->create('FormaPago'); ?>
	<fieldset>
		<legend><?php echo __('Edit Forma Pago'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('nombre');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('FormaPago.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('FormaPago.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Forma Pagos'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Contratos'), array('controller' => 'contratos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contrato'), array('controller' => 'contratos', 'action' => 'add')); ?> </li>
	</ul>
</div>
