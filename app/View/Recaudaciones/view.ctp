<div class="recaudaciones view">
<h2><?php echo __('Recaudacione'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($recaudacione['Recaudacione']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Contrato'); ?></dt>
		<dd>
			<?php echo $this->Html->link($recaudacione['Contrato']['id'], array('controller' => 'contratos', 'action' => 'view', $recaudacione['Contrato']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cliente'); ?></dt>
		<dd>
			<?php echo $this->Html->link($recaudacione['Cliente']['id'], array('controller' => 'clientes', 'action' => 'view', $recaudacione['Cliente']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Cobro'); ?></dt>
		<dd>
			<?php echo h($recaudacione['Recaudacione']['fecha_cobro']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mes Cobro'); ?></dt>
		<dd>
			<?php echo h($recaudacione['Recaudacione']['mes_cobro']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado'); ?></dt>
		<dd>
			<?php echo h($recaudacione['Recaudacione']['estado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mensualidad'); ?></dt>
		<dd>
			<?php echo h($recaudacione['Recaudacione']['subtotal']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Entrega, instalación y retiro'); ?></dt>
		<dd>
			<?php echo h($recaudacione['Recaudacione']['despacho']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Descuento'); ?></dt>
		<dd>
			<?php echo h($recaudacione['Recaudacione']['descuento']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Total Cobrado'); ?></dt>
		<dd>
			<?php echo h($recaudacione['Recaudacione']['total_cobrado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Total Pagado'); ?></dt>
		<dd>
			<?php echo h($recaudacione['Recaudacione']['total_pagado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tipo Documento'); ?></dt>
		<dd>
			<?php echo $this->Html->link($recaudacione['TipoDocumento']['id'], array('controller' => 'tipo_documentos', 'action' => 'view', $recaudacione['TipoDocumento']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nro Documento'); ?></dt>
		<dd>
			<?php echo h($recaudacione['Recaudacione']['nro_documento']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Recaudacione'), array('action' => 'edit', $recaudacione['Recaudacione']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Recaudacione'), array('action' => 'delete', $recaudacione['Recaudacione']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $recaudacione['Recaudacione']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Recaudaciones'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Recaudacione'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contratos'), array('controller' => 'contratos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contrato'), array('controller' => 'contratos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Clientes'), array('controller' => 'clientes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cliente'), array('controller' => 'clientes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tipo Documentos'), array('controller' => 'tipo_documentos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tipo Documento'), array('controller' => 'tipo_documentos', 'action' => 'add')); ?> </li>
	</ul>
</div>
