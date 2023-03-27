<div class="menus view">
<h2><?php echo __('Menu'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($menu['Menu']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($menu['Menu']['nombre']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Menu'), array('action' => 'edit', $menu['Menu']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Menu'), array('action' => 'delete', $menu['Menu']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $menu['Menu']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Menus'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Menu'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Paginas'), array('controller' => 'paginas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pagina'), array('controller' => 'paginas', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Paginas'); ?></h3>
	<?php if (!empty($menu['Pagina'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Menu Id'); ?></th>
		<th><?php echo __('Controlador'); ?></th>
		<th><?php echo __('Accion'); ?></th>
		<th><?php echo __('Nombre Link'); ?></th>
		<th><?php echo __('Alias'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($menu['Pagina'] as $pagina): ?>
		<tr>
			<td><?php echo $pagina['id']; ?></td>
			<td><?php echo $pagina['menu_id']; ?></td>
			<td><?php echo $pagina['controlador']; ?></td>
			<td><?php echo $pagina['accion']; ?></td>
			<td><?php echo $pagina['nombre_link']; ?></td>
			<td><?php echo $pagina['alias']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'paginas', 'action' => 'view', $pagina['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'paginas', 'action' => 'edit', $pagina['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'paginas', 'action' => 'delete', $pagina['id']), array('confirm' => __('Are you sure you want to delete # %s?', $pagina['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Pagina'), array('controller' => 'paginas', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
