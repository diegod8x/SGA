<div class="tipoActividades view">
<h2><?php echo __('Tipo Actividade'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($tipoActividade['TipoActividade']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($tipoActividade['TipoActividade']['nombre']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Tipo Actividade'), array('action' => 'edit', $tipoActividade['TipoActividade']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Tipo Actividade'), array('action' => 'delete', $tipoActividade['TipoActividade']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $tipoActividade['TipoActividade']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Tipo Actividades'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tipo Actividade'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Actividades'), array('controller' => 'actividades', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Actividade'), array('controller' => 'actividades', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Actividades'); ?></h3>
	<?php if (!empty($tipoActividade['Actividade'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Contrato Id'); ?></th>
		<th><?php echo __('Tipo Actividade Id'); ?></th>
		<th><?php echo __('Trabajadore Id'); ?></th>
		<th><?php echo __('Fecha'); ?></th>
		<th><?php echo __('Hora'); ?></th>
		<th><?php echo __('Direccion'); ?></th>
		<th><?php echo __('Comuna Id'); ?></th>
		<th><?php echo __('Regione Id'); ?></th>
		<th><?php echo __('Observaciones'); ?></th>
		<th><?php echo __('Comentarios'); ?></th>
		<th><?php echo __('Ruta Archivos'); ?></th>
		<th><?php echo __('Gps'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($tipoActividade['Actividade'] as $actividade): ?>
		<tr>
			<td><?php echo $actividade['id']; ?></td>
			<td><?php echo $actividade['contrato_id']; ?></td>
			<td><?php echo $actividade['tipo_actividade_id']; ?></td>
			<td><?php echo $actividade['trabajadore_id']; ?></td>
			<td><?php echo $actividade['fecha']; ?></td>
			<td><?php echo $actividade['hora']; ?></td>
			<td><?php echo $actividade['direccion']; ?></td>
			<td><?php echo $actividade['comuna_id']; ?></td>
			<td><?php echo $actividade['regione_id']; ?></td>
			<td><?php echo $actividade['observaciones']; ?></td>
			<td><?php echo $actividade['comentarios']; ?></td>
			<td><?php echo $actividade['ruta_archivos']; ?></td>
			<td><?php echo $actividade['gps']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'actividades', 'action' => 'view', $actividade['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'actividades', 'action' => 'edit', $actividade['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'actividades', 'action' => 'delete', $actividade['id']), array('confirm' => __('Are you sure you want to delete # %s?', $actividade['id']))); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Actividade'), array('controller' => 'actividades', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
