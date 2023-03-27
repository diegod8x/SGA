<div class="paginas view">
<h2><?php echo __('Pagina'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($pagina['Pagina']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Menu'); ?></dt>
		<dd>
			<?php echo $this->Html->link($pagina['Menu']['id'], array('controller' => 'menus', 'action' => 'view', $pagina['Menu']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Controlador'); ?></dt>
		<dd>
			<?php echo h($pagina['Pagina']['controlador']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Accion'); ?></dt>
		<dd>
			<?php echo h($pagina['Pagina']['accion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre Link'); ?></dt>
		<dd>
			<?php echo h($pagina['Pagina']['nombre_link']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Alias'); ?></dt>
		<dd>
			<?php echo h($pagina['Pagina']['alias']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Pagina'), array('action' => 'edit', $pagina['Pagina']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Pagina'), array('action' => 'delete', $pagina['Pagina']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $pagina['Pagina']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Paginas'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pagina'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Menus'), array('controller' => 'menus', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Menu'), array('controller' => 'menus', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Roles'), array('controller' => 'roles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Role'), array('controller' => 'roles', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Roles'); ?></h3>
	<?php if (!empty($pagina['Role'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Nombre'); ?></th>
		<th><?php echo __('Estado'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($pagina['Role'] as $role): ?>
		<tr>
			<td><?php echo $role['id']; ?></td>
			<td><?php echo $role['nombre']; ?></td>
			<td><?php echo $role['estado']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'roles', 'action' => 'view', $role['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'roles', 'action' => 'edit', $role['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'roles', 'action' => 'delete', $role['id']), array('confirm' => __('Are you sure you want to delete # %s?', $role['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Role'), array('controller' => 'roles', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
