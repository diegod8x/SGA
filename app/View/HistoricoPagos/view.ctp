<div class="historicoPagos view">
<h2><?php echo __('Historico Pago'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($historicoPago['HistoricoPago']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Contratos Producto Id'); ?></dt>
		<dd>
			<?php echo h($historicoPago['HistoricoPago']['contratos_producto_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Monto Cobrado'); ?></dt>
		<dd>
			<?php echo h($historicoPago['HistoricoPago']['monto_cobrado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Monto Pagado'); ?></dt>
		<dd>
			<?php echo h($historicoPago['HistoricoPago']['monto_pagado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Mes Cobro'); ?></dt>
		<dd>
			<?php echo h($historicoPago['HistoricoPago']['mes_cobro']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Pago'); ?></dt>
		<dd>
			<?php echo h($historicoPago['HistoricoPago']['fecha_pago']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Estado'); ?></dt>
		<dd>
			<?php echo h($historicoPago['HistoricoPago']['estado']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tipo Documento'); ?></dt>
		<dd>
			<?php echo $this->Html->link($historicoPago['TipoDocumento']['id'], array('controller' => 'tipo_documentos', 'action' => 'view', $historicoPago['TipoDocumento']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nro Boleta Factura'); ?></dt>
		<dd>
			<?php echo h($historicoPago['HistoricoPago']['nro_boleta_factura']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Historico Pago'), array('action' => 'edit', $historicoPago['HistoricoPago']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Historico Pago'), array('action' => 'delete', $historicoPago['HistoricoPago']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $historicoPago['HistoricoPago']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Historico Pagos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Historico Pago'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Tipo Documentos'), array('controller' => 'tipo_documentos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Tipo Documento'), array('controller' => 'tipo_documentos', 'action' => 'add')); ?> </li>
	</ul>
</div>
