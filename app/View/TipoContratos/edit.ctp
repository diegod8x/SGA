<div class="tipoContratos form">
<?php echo $this->Form->create('TipoContrato'); ?>
	<fieldset>
		<legend><?php echo __('Edit Tipo Contrato'); ?></legend>
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

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('TipoContrato.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('TipoContrato.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Tipo Contratos'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Contratos'), array('controller' => 'contratos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contrato'), array('controller' => 'contratos', 'action' => 'add')); ?> </li>
	</ul>
</div>
