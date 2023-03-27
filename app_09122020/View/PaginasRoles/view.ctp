<div class="paginasRoles view">
<h2><?php echo __('Paginas Role'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($paginasRole['PaginasRole']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pagina'); ?></dt>
		<dd>
			<?php echo $this->Html->link($paginasRole['Pagina']['id'], array('controller' => 'paginas', 'action' => 'view', $paginasRole['Pagina']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Role'); ?></dt>
		<dd>
			<?php echo $this->Html->link($paginasRole['Role']['id'], array('controller' => 'roles', 'action' => 'view', $paginasRole['Role']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Paginas Role'), array('action' => 'edit', $paginasRole['PaginasRole']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Paginas Role'), array('action' => 'delete', $paginasRole['PaginasRole']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $paginasRole['PaginasRole']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Paginas Roles'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Paginas Role'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Paginas'), array('controller' => 'paginas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pagina'), array('controller' => 'paginas', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Roles'), array('controller' => 'roles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Role'), array('controller' => 'roles', 'action' => 'add')); ?> </li>
	</ul>
</div>
