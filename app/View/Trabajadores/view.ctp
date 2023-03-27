<div class="trabajadores view col-xs-12 col-sm-12 col-md-12 col-lg-12">
<h4 class="col-md-offset-3"><?php echo __('Detalle trabajadore'); ?></h4>
	<div class="row">
		<dl class="form-horizontal" >
			<div class="form-group">
				<div class="col-md-3 control-label text-right">	
					<dt><?php echo __('Rut'); ?></dt>
				</div>
				<div class="col-md-7">
					<dd class="form-control">
						<?php echo h($trabajadore['Trabajadore']['rut']); ?>
					</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label text-right control-label">	
					<dt><?php echo __('Nombre'); ?></dt>
				</div>
				<div class="col-md-7">
					<dd class="form-control">
						<?php echo h($trabajadore['Trabajadore']['nombre']); ?>
						&nbsp;
					</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label text-right control-label">	
					<dt><?php echo __('Apellido paterno'); ?></dt>
				</div>
				<div class="col-md-7">
					<dd class="form-control">
						<?php echo h($trabajadore['Trabajadore']['apellido_paterno']); ?>
						&nbsp;
					</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label text-right control-label">	
					<dt><?php echo __('Apellido materno'); ?></dt>
				</div>
				<div class="col-md-7">
					<dd class="form-control">
						<?php echo h($trabajadore['Trabajadore']['apellido_materno']); ?>
						&nbsp;
					</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label text-right control-label">	
				<dt ><?php echo __('Telefono'); ?></dt>
				</div>
				<div class="col-md-7">
				<dd class="form-control">
					<?php echo h($trabajadore['Trabajadore']['telefono']); ?>
					&nbsp;
				</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label text-right">	
				<dt><?php echo __('Email'); ?></dt>
				</div>
				<div class="col-md-7">
				<dd class="form-control">
					<?php echo h($trabajadore['Trabajadore']['email']); ?>
					&nbsp;
				</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label text-right control-label">	
				<dt ><?php echo __('Estado'); ?></dt>
				</div>
				<div class="col-md-7">
				<dd class="form-control">
					<?php echo h($trabajadore['EstadoTrabajadore']['nombre']); ?>
					&nbsp;
				</dd>
				</div>
			</div>

			<div class="text-right col-md-9">
				<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a> 
			</div>

		</dl>
	</div>
</div>
