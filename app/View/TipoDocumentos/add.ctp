<div class="tipoDocumentos form">
<?php echo $this->Form->create('TipoDocumento'); ?>
	<fieldset>
		<legend><?php echo __('Add Tipo Documento'); ?></legend>
	<?php
		echo $this->Form->input('nombre');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Tipo Documentos'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Cobranzas'), array('controller' => 'cobranzas', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cobranza'), array('controller' => 'cobranzas', 'action' => 'add')); ?> </li>
	</ul>
</div>
