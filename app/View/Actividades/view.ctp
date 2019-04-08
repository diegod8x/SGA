<div class="actividades view col-xs-12 col-sm-12 col-md-12 col-lg-12">
<h4 class="col-md-offset-3"><?php echo __('Detalle Actividad'); ?></h4>
	<div class="row">
		<dl class="form-horizontal">
			<div class="form-group">
				<div class="col-md-3 control-label">	
					<dt><?php echo __('Tipo Actividad'); ?></dt>
				</div>
				<div class="col-md-7">
					<dd class="form-control">
						<?php echo h( (isset($actividade['TipoActividade']['nombre']))? $actividade['TipoActividade']['nombre']:''); ?>
						&nbsp;
					</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label">	
				<dt ><?php echo __('Trabajador'); ?></dt>
				</div>
				<div class="col-md-7">
				<dd class="form-control">
					<?php echo h( (isset($actividade['Trabajadore']['nombre_completo']))? $actividade['Trabajadore']['nombre_completo']:''); ?>
					&nbsp;
				</dd>
				</div>
			</div>


			<div class="form-group">
				<div class="col-md-3 control-label">	
				<dt ><?php echo __('Observaciones'); ?></dt>
				</div>
				<div class="col-md-7">
					<textarea class="form-control view-ronly" readonly><?php echo (isset($actividade['Actividade']['observaciones']))? $actividade['Actividade']['observaciones']:''; ?></textarea>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label">	
					<dt><?php echo __('Dirección'); ?></dt>
				</div>
				<div class="col-md-7">
					<textarea class="form-control view-ronly" readonly><?php echo (isset($actividade['Actividade']['direccion']))? $actividade['Actividade']['direccion']:'';?></textarea>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label">	
				<dt><?php echo __('Fecha Actividad'); ?></dt>
				</div>
				<div class="col-md-7">
				<dd class="form-control">
					<?php echo h( (isset($actividade['Actividade']['fecha_ingreso']))? DateTime::createFromFormat('Y-m-d',$actividade['Actividade']['fecha_ingreso'])->format('d-m-Y') :'' );?>
					&nbsp;
				</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label">	
					<dt><?php echo __('Hora Acordada'); ?></dt>
				</div>
				<div class="col-md-7">
					<dd class="form-control">
						<?php echo h( (isset($actividade['Actividade']['hora_ingreso']))? substr($actividade['Actividade']['hora_ingreso'],0,-3):''); ?>
						&nbsp;
					</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label">	
					<dt><i class="fa fa-map-marker"></i>&nbsp;<?php echo __('GPS'); ?></dt>
				</div>
				<div class="col-md-7">
					<dd class="form-control">
						<?php echo h( (isset($actividade['Actividade']['gps']))? $actividade['Actividade']['gps']:'');?>
						&nbsp;
					</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label">	
					<dt><?php echo __('Cliente'); ?></dt>
				</div>
				<div class="col-md-7">
					<dd class="form-control">
						<?php echo h( (isset($actividade['Cliente']['nombre']))? $actividade['Cliente']['nombre']:''); ?>
					</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label">	
					<dt><?php echo __('Estado'); ?></dt>
				</div>
				<div class="col-md-7">
					<dd class="form-control">
						<?php echo h( (isset( $actividade['EstadoActividade']['nombre']))? $actividade['EstadoActividade']['nombre']:''); ?>
						&nbsp;
					</dd>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label">	
					<dt><?php echo __('Comentarios'); ?></dt>
				</div>
				<div class="col-md-7">
					<textarea class="form-control view-ronly" readonly><?php echo (isset( $actividade['Actividade']['comentarios']))? $actividade['Actividade']['comentarios']:''; ?></textarea>
				</div>
			</div>			
			<div class="text-right col-md-9">
				<a href="<?php echo $this->request->referer();?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a> 
			</div>
		</dl>
	</div>
</div>
