<?php 
	$nombreControllador = "";
	$nombreAccion = "";
	$tercerNivel = "";


	/* en uso */
	if($this->params->controller == "empresas")
	{
		$nombreControllador = "Empresas";
	}

	if($this->params->controller == "clientes")
	{
		$nombreControllador = "Clientes";
	}
	if($this->params->controller == "productos")
	{
		$nombreControllador = "Productos";
	}	
	if($this->params->controller == "contratos")
	{
		$nombreControllador = "Contratos";
	}
		if($this->params->controller == "actividades")
	{
		$nombreControllador = "Actividades";
	}
	if($this->params->controller == "recaudaciones")
	{
		$nombreControllador = "Recaudación";
	}
		

	/* */
	if($this->params->controller == "dimensiones")
	{
		$nombreControllador = "dimensiones";
	}

	if($this->params->controller == "dimensiones_areas")
	{
		$nombreControllador = "Dimensiones-Areas";
	}

	if($this->params->controller == "dimensiones_areas")
	{
		$nombreControllador = "Dimensiones-Areas";
	}

	if($this->params->controller == "companies")
	{
		$nombreControllador = "Empresas";
	}
	
	if($this->params->controller == "subscribers")
	{
		$nombreControllador = "Abonados";
	}
	
	if($this->params->controller == "users")
	{
		$nombreControllador = "Usuarios";
	}
    
    if($this->params->controller == "dashboards")
    {
        $nombreControllador = "Dashboard";
    }
	
	if($this->params->controller == "roles")
	{
		$nombreControllador = "Roles";
	}
	
	if($this->params->controller == "paginas")
	{
		$nombreControllador = "Páginas";
	}
	
	if($this->params->controller == "exportar")
	{
		$nombreControllador = "Exportar";
	}
	
	if($this->params->controller == "menus")
	{
		$nombreControllador = "Menús";
	}
	
	if($this->params->controller == "compras")
	{
		$nombreControllador = "Requerimientos de Compra";
	}

	if($this->params->controller == "trabajadores")
	{
		$nombreControllador = "Trabajadores";
	}

	if($this->params->controller == "areas")
	{
		$nombreControllador = "Áreas";
	}

	if($this->params->controller == "gerencias")
	{
		$nombreControllador = "Gerencias";
	}

	if($this->params->controller == "cargos")
	{
		$nombreControllador = "Cargos";
	}

	if($this->params->controller == "rating_programaciones" || $this->params->controller == "rating_minutos")
	{
		$nombreControllador = "Rating";
	}

	if($this->params->controller == "log_programas")
	{
		$nombreControllador = "Log";
	}
	if($this->params->controller == "lista_correos")
	{
		$nombreControllador = "Lista Correos";
	}
	if($this->params->controller == "lista_correos_tipos")
	{
		$nombreControllador = "Lista Correos Tipos";
	}
	if($this->params->controller == "ingestas")
	{
		$nombreControllador = "Ingesta";
	}


	/* en uso */

	/* */
	if($this->params->action == "add")
	{
		$nombreAccion = "Registrar";
	}
	
	if($this->params->action == "view")
	{
		$nombreAccion = "Detalle";
	}
	
	else if($this->params->action == "edit")
	{
		$nombreAccion = "Editar";
	}
	
	else if($this->params->action == "index")
	{
		$nombreAccion = "Lista";
	}

	else if($this->params->action == "perfil")
	{
		$nombreAccion = "Perfil";
	}
	else if($this->params->action == "edit_act")
	{
		$nombreAccion = "Editar";
	}


	
	//Especiales//
	if($this->params->action == "index" && $this->params->controller == "subscribers")
	{
		$nombreControllador = "Empresas";
		$nombreAccion = "Abonados";
		$tercerNivel = "Lista";
	}

	if($this->params->action == "programa" && $this->params->controller == "rating_programaciones")
	{
		$nombreAccion = "Informe programas";
	}
	if($this->params->action == "index" && $this->params->controller == "recaudaciones")
	{
		$nombreAccion = "Pagos pendientes";
	}
	if($this->params->action == "consolidado" && $this->params->controller == "actividades")
	{
		$nombreAccion = "Consolidado";
	}
	if($this->params->action == "historico" && $this->params->controller == "recaudaciones")
	{
		$nombreAccion = "Histórico";
	}
	if($this->params->action == "diario" && $this->params->controller == "rating_programaciones")
	{
		$nombreAccion = "Informe diario";
	}
	if($this->params->action == "upload" && $this->params->controller == "rating_programaciones")
	{
		$nombreAccion = "Subir Programación";
	}
	if($this->params->action == "upload" && $this->params->controller == "rating_minutos")
	{
		$nombreAccion = "Subir Minutos";
	}
	if($this->params->action == "programa_minutos")
	{
		$nombreAccion = "Minuto a minuto";
	}
	if($this->params->action == "todos_sap")
	{
		$nombreAccion = "Buscar";
	}
	if($this->params->action == "trabajadores")
	{
		$nombreAccion = "Trabajadores";
	}

	if($this->params->action == "add_media")
	{
		$nombreAccion = "Ingresar Media";
	}

	if($this->params->action == "listar_contratos_empresas")
	{
		$nombreAccion = "Lista de contratos";
	}

	if($this->params->action == "contratos_add")
	{
		$nombreAccion = "Ingreso de contratos";
	}
?>

<div class="row clearfix" >
	<div class="col-md-12 column" id="miga">
		<ul class="breadcrumb">
			<li class="active"><a href="<?php echo $this->Html->url(array("controller"=>"recaudaciones", "action"=>"index"))?>">Inicio</a><span class="divider"></span>
			</li> 	
			<?php //if($this->params->controller != "clientes") : ?>
			<li class="active">
				<?php echo $nombreControllador ?>
					<span class="divider"> </span>
			</li>
			<?php //endif; ?>
			<li class="active">
				<?php echo $tercerNivel  . ' ' .$nombreAccion; ?>
			</li>
		</ul>
	</div>
</div>
