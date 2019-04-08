<div class="clientes view col-xs-12 col-sm-12 col-md-12 col-lg-12">
<h4 class="col-md-offset-3"><?php echo __('Detalle cliente'); ?></h4>
	<div class="row">
		<dl class="form-horizontal" >
			<div class="form-group">
				<div class="col-md-3 control-label">	
					<dt><?php echo __('Rut'); ?></dt>
				</div>
				<div class="col-md-7">
					<dd class="form-control">
						<?php echo h($cliente['Cliente']['rut']); ?>
					</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label">	
					<dt><?php echo __('Nombre'); ?></dt>
				</div>
				<div class="col-md-7">
					<dd class="form-control">
						<?php echo h($cliente['Cliente']['nombre']); ?>
						&nbsp;
					</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label">	
				<dt><?php echo __('Empresa'); ?></dt>
				</div>
				<div class="col-md-7">
				<dd class="form-control">
					<?php echo h($cliente['Empresa']['nombre']); ?>
					&nbsp;
				</dd>
				</div>
			</div>


			<div class="form-group">
				<div class="col-md-3 control-label">	
				<dt ><?php echo __('Teléfono'); ?></dt>
				</div>
				<div class="col-md-7">
				<dd class="form-control">
					<?php echo h($cliente['Cliente']['telefono']); ?>
					&nbsp;
				</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label">	
				<dt ><?php echo __('Teléfono 2'); ?></dt>
				</div>
				<div class="col-md-7">
				<dd class="form-control">
					<?php echo h($cliente['Cliente']['telefono2']); ?>
					&nbsp;
				</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label">	
				<dt ><?php echo __('Teléfono 3'); ?></dt>
				</div>
				<div class="col-md-7">
				<dd class="form-control">
					<?php echo h($cliente['Cliente']['telefono3']); ?>
					&nbsp;
				</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label">	
				<dt><?php echo __('Email'); ?></dt>
				</div>
				<div class="col-md-7">
				<dd class="form-control">
					<?php echo h($cliente['Cliente']['email']); ?>
					&nbsp;
				</dd>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-3 control-label">	
				<dt><?php echo __('Email 2'); ?></dt>
				</div>
				<div class="col-md-7">
				<dd class="form-control">
					<?php echo h($cliente['Cliente']['email2']); ?>
					&nbsp;
				</dd>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-3 control-label">	
				<dt><?php echo __('Email 3'); ?></dt>
				</div>
				<div class="col-md-7">
				<dd class="form-control">
					<?php echo h($cliente['Cliente']['email3']); ?>
					&nbsp;
				</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label">	
					<dt><?php echo __('Direccion'); ?></dt>
				</div>
				<div class="col-md-7">
					<textarea class="form-control view-ronly" readonly><?php echo ($cliente['Cliente']['direccion']); ?></textarea>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label">	
				<dt><?php echo __('Comuna'); ?></dt>
				</div>
				<div class="col-md-7">
				<dd class="form-control">
					<?php echo h($cliente['Comuna']['nombre']); ?>
					&nbsp;
				</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label">	
				<dt><?php echo __('Región'); ?></dt>
				</div>
				<div class="col-md-7">
				<dd class="form-control">
					<?php echo h($cliente['Regione']['nombre']); ?>
					&nbsp;
				</dd>
				</div>
			</div>




			<!--div class="form-group">
				<div class="col-md-3 control-label text-right">	
				<dt><?php echo __('GPS'); ?></dt>
				</div>
				<div class="col-md-7">
				<dd class="form-control">
					<?php echo h($cliente['Cliente']['gps']); ?>
					&nbsp;
				</dd>
				</div>
			</div-->

			<div class="text-right col-md-9">
				<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a> 
			</div>

		</dl>
	</div>
</div>
