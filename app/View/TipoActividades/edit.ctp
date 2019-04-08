<div class="tipoActividades form">
<?php echo $this->Form->create('TipoActividade'); ?>
	<fieldset>
		<legend><?php echo __('Edit Tipo Actividade'); ?></legend>
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

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('TipoActividade.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('TipoActividade.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Tipo Actividades'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Actividades'), array('controller' => 'actividades', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Actividade'), array('controller' => 'actividades', 'action' => 'add')); ?> </li>
	</ul>
</div>
