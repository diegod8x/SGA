<div class="productos view col-xs-12 col-sm-12 col-md-12 col-lg-12">
<h4 class="col-md-offset-3"><?php echo __('Detalle producto'); ?></h4>
	<div class="row">
		<dl class="form-horizontal">
			<div class="form-group">
				<div class="col-md-3 control-label">	
					<dt><?php echo __('Nombre'); ?></dt>
				</div>
				<div class="col-md-7">
					<dd class="form-control">
						<?php echo h($producto['Producto']['nombre']); ?>
						&nbsp;
					</dd>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-3 control-label">	
					<dt><?php echo __('Descripción'); ?></dt>
				</div>
				<div class="col-md-7">
					<textarea class="form-control view-ronly" readonly><?php echo $producto['Producto']['descripcion']; ?></textarea>
				</div>
			</div>


			<div class="form-group">
				<div class="col-md-3 control-label">	
					<dt><?php echo __('Precio Arriendo Mensual $'); ?></dt>
				</div>
				<div class="col-md-7">
					<dd class="form-control">
						<?php echo h(number_format($producto['Producto']['precio_arriendo'],0,",",".")); ?>
						&nbsp;
					</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label">	
					<dt><?php echo __('Precio Venta $'); ?></dt>
				</div>
				<div class="col-md-7">
					<dd class="form-control">
						<?php echo h(number_format($producto['Producto']['precio_venta'],0,",",".")); ?>
						&nbsp;
					</dd>
				</div>
			</div>


			<div class="form-group">
				<div class="col-md-3 control-label">	
					<dt><?php echo __('Existencias'); ?></dt>
				</div>
				<div class="col-md-7">
					<dd class="form-control">
						<?php echo h($producto['Producto']['existencias']); ?>
						&nbsp;
					</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label">	
					<dt><?php echo __('Disponibles'); ?></dt>
				</div>
				<div class="col-md-7">
					<dd class="form-control">
						<?php echo h($producto['Producto']['disponibles']); ?>
						&nbsp;
					</dd>
				</div>
			</div>

			<!--div class="form-group">
				<div class="col-md-3 control-label text-right control-label">	
					<dt><?php echo __('Estado'); ?></dt>
				</div>
				<div class="col-md-7">
					<dd class="form-control">
						<?php echo h($producto['Producto']['estado']); ?>
						&nbsp;
					</dd>
				</div>
			</div-->

			<div class="col-md-offset-3 col-md-5 text-right">
				<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a> 
			</div>

		</dl>
	</div>
</div>
