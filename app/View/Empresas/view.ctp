<div class="empresas view col-xs-12 col-sm-12 col-md-12 col-lg-12">
<h4 class="col-md-offset-3"><?php echo __('Detalle empresa'); ?></h4>
	<div class="row">
		<dl class="form-horizontal">			
			<div class="form-group">
				<div class="col-md-3 control-label">	
					<dt><?php echo __('Rut'); ?></dt>
				</div>
				<div class="col-md-7">
					<dd class="form-control">
						<?php echo h($empresa['Empresa']['rut']); ?>
					</dd>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-3 control-label">	
					<dt><?php echo __('Nombre'); ?></dt>
				</div>
				<div class="col-md-7">
					<dd class="form-control">
						<?php echo h($empresa['Empresa']['nombre']); ?>
						&nbsp;
					</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label">	
				<dt ><?php echo __('Telefono'); ?></dt>
				</div>
				<div class="col-md-7">
				<dd class="form-control">
					<?php echo h($empresa['Empresa']['telefono']); ?>
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
					<?php echo h($empresa['Empresa']['email']); ?>
					&nbsp;
				</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label">	
				<dt><?php echo __('Dirección'); ?></dt>
				</div>
				<div class="col-md-7">
					<textarea class="form-control view-ronly" readonly><?php echo $empresa['Empresa']['direccion']; ?></textarea>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label">	
				<dt><?php echo __('Región'); ?></dt>
				</div>
				<div class="col-md-7">
				<dd class="form-control">
					<?php echo h($empresa['Regione']['nombre']); ?>
					&nbsp;
				</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label">	
				<dt><?php echo __('Comuna'); ?></dt>
				</div>
				<div class="col-md-7">
				<dd class="form-control">
					<?php echo h($empresa['Comuna']['nombre']); ?>
					&nbsp;
				</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label">	
				<dt><?php echo __('Nombre Contacto'); ?></dt>
				</div>
				<div class="col-md-7">
				<dd class="form-control">
					<?php echo h($empresa['Empresa']['nombre_contacto']); ?>
					&nbsp;
				</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label">	
				<dt><?php echo __('Teléfono Contacto'); ?></dt>
				</div>
				<div class="col-md-7">
				<dd class="form-control">
					<?php echo h($empresa['Empresa']['telefono_contacto']); ?>
					&nbsp;
				</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label">	
					<dt><?php echo __('Observaciones'); ?></dt>
				</div>
				<div class="col-md-7">
				<textarea class="form-control view-ronly" readonly style="display:table"><?php echo $empresa['Empresa']['observaciones']; ?></textarea>
				</div>
			</div>

			<div class="text-right col-md-8">
				<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a> 
			</div>

		</dl>
	</div>
</div>
