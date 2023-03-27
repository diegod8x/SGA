<div class="col-md-10 ">
	<?php echo $this->Form->create('Pagina'); ?>

		<h4 class="col-md-offset-1"> <?php echo __('Registrar Pagina'); ?></h4>

		<dl class="form-horizontal">
			<div class="form-group">
				<div class="col-md-3 control-label text-right baja">	
					<label><?php echo __('Controlador'); ?></label>
				</div>
				<div class="required-field-block col-md-7">
					<?php echo $this->Form->input('controlador', array("class"=>"form-control", "placeholder"=>"Ingrese Controlador", "label"=>false, "required"=>"required"));?>
				</div>
			</div>


			<div class="form-group">
				<div class="col-md-3 control-label text-right baja">	
					<label><?php echo __('Controlador Fantasia'); ?></label>
				</div>
				<div class="required-field-block col-md-7">
					<?php echo $this->Form->input('controlador_fantasia', array("class"=>"form-control", "placeholder"=>"Ingrese Controlador Fantasia", "label"=>false, "required"=>"required"));?>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label text-right baja">	
					<label><?php echo __('Acción'); ?></label>
				</div>
				<div class="required-field-block col-md-7">
					<?php echo $this->Form->input('accion', array("class"=>"form-control", "placeholder"=>"Ingrese Acción", "label"=>false, "required"=>"required"));?>
				</div>
			</div>


			<div class="form-group">
				<div class="col-md-3 control-label text-right baja">	
					<label><?php echo __('Acción Fantasia'); ?></label>
				</div>
				<div class="required-field-block col-md-7">
					<?php echo $this->Form->input('accion_fantasia', array("class"=>"form-control", "placeholder"=>"Ingrese Accion Fantasia", "label"=>false, "required"=>"required"));?>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label text-right baja">	
					<label><?php echo __('Link'); ?></label>
				</div>
				<div class="required-field-block col-md-7">
					<?php echo $this->Form->input('nombre_link', array("class"=>"form-control", "placeholder"=>"Ingrese Link", "label"=>false, "required"=>"required"));?>
				</div>			
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label text-right baja">	
					<label><?php echo __('Alias'); ?></label>
				</div>
				<div class="required-field-block col-md-7">
					<?php echo $this->Form->input('alias', array("class"=>"form-control", "placeholder"=>"Ingrese Alias", "label"=>false, "required"=>"required"));?>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-3 control-label text-right">	
					<label><?php echo __('Menú'); ?></label>
				</div>
				<div class="required-field-block col-md-7">
					<?php echo $this->Form->input('menu_id', array("type"=>"select","class"=>"form-control", 'options' => $menus));?>
				</div>
			</div>

		</dl>		

		<br/><br/>
		<div class="text-right col-md-10">
			<button class="btn btn-primary btn-lg"><i class="fa fa-pencil"></i> Registrar</button>
			<a href="<?php echo $this->Html->url(array("action"=>"index"))?>" class="volver btn btn-default btn-lg"><i class="fa fa-mail-reply-all"></i> Volver</a>  
		</div>
	<?php echo $this->Form->end(); ?>
</div>

<script>
	$("#PaginaMenuId").select2({
		placeholder: "Seleccione Menú",
		allowClear: true,
		width:'100%',		
		language: "es"
	});
	$("#s2id_PaginaMenuId").prev().hide();	
</script>