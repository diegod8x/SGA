<div class="paginasRoles form">
<?php echo $this->Form->create('PaginasRole'); ?>
	<fieldset>
		<legend><?php echo __('Edit Paginas Role'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('pagina_id');
		echo $this->Form->input('role_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('PaginasRole.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('PaginasRole.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Paginas Roles'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Paginas'), array('controller' => 'paginas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pagina'), array('controller' => 'paginas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Roles'), array('controller' => 'roles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Role'), array('controller' => 'roles', 'action' => 'add')); ?> </li>
	</ul>
</div>
