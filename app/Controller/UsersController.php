<?php
class UsersController extends AppController {

	public function login($usuario = null, $clave = null) { 
		$this->layout = "login";
	
		if ($this->request->is('post')) {
	
			if ($this->Session->read('Users.flag') == "0") {				
				$this->Session->setFlash('El usuario o clave son incorrectos', 'msg_fallo');
				$this->redirect(array('controller' => 'users', 'action' => 'login'));
			}

			if($this->Session->read('Users.flag') == "1") {

				$this->loadModel("PaginasRole");
				$this->loadModel("Pagina");
				$this->loadModel("Menu");

				$nombreUsuario = $this->User->find('first', array(
					'conditions'=>array('User.nombre'=>$this->Session->read("Users.nombre")),
					'recursive'=>-1
				));

				$idRolesUsuarios = array();

				if(!empty($nombreUsuario))
				{
					$usuarioSession = $this->Session->read("Users");
					
					$usuarioSession["trabajadore_id"] = $nombreUsuario["User"]["trabajadore_id"];
					
					$this->Session->write("Users", $usuarioSession);
					
					$idRolesUsuarios = explode(",", $nombreUsuario["User"]["role_id"]);
					$this->Session->write("RolesUsuarios", $idRolesUsuarios);
					
					$this->Session->write("PerfilUsuario", array(
					  		"idUsuario"=>$nombreUsuario["User"]["id"],
					  		"roleId"=>$nombreUsuario["User"]["role_id"],
					  		"trabajadoreId"=>$nombreUsuario["User"]["trabajadore_id"],
						)
					);
				}

				if(!empty($idRolesUsuarios))
				{					
					//CakeLog::write('actividad', 'ingreso el user - ' . $nombreUser["User"]["id"]);
					$idPaginas = array();
					$idPaginas = $this->PaginasRole->find("all", array(
						"conditions"=>array("PaginasRole.role_id"=>$idRolesUsuarios),
						'fields'=>"PaginasRole.pagina_id",
						"recursive"=>-1
					));

					$paginasId = array();
					foreach($idPaginas as $dataPaginas)
					{
						$paginasId[] =  $dataPaginas["PaginasRole"]["pagina_id"];
					}

					$paginas = $this->Pagina->find("all", array(
						"conditions"=>array("Pagina.id"=>$paginasId),
						"recursive"=>-1
					));

					$nombreMenus = array();

					$menus = $this->Menu->find("list",array(
						"fields"=>array("Menu.id", "Menu.nombre")
					));

					$menusPaginas = array();
					$menusSecundarios = array();
					$acceso = array();

					foreach($paginas as $paginasMenus)
					{
						
						$linkMenu = explode(",", $paginasMenus["Pagina"]["nombre_link"]);
						//pr($linkMenu);exit;
						$link = $linkMenu[0];						

						if($menus[$paginasMenus["Pagina"]["menu_id"]] != "Secundario")
						{
							if(count($linkMenu) > 1)
							{
								unset($linkMenu[0]);
							}						
							
							$menusPaginas[$menus[$paginasMenus["Pagina"]["menu_id"]]][$link][] = array(
								"idMenu"=>$paginasMenus["Pagina"]["menu_id"],
								"nombreLink"=>$linkMenu,
								"contadorMenu"=>count($linkMenu),
								"controlador"=>$paginasMenus["Pagina"]["controlador"],
								"accion"=>$paginasMenus["Pagina"]["accion"],
							);
						}
						else
						{
							$menusSecundarios[$menus[$paginasMenus["Pagina"]["menu_id"]]][$link][] = array(
								"idPagina"=>$paginasMenus["Pagina"]["id"],
								"idMenu"=>$paginasMenus["Pagina"]["menu_id"],
								"controlador"=>$paginasMenus["Pagina"]["controlador"],
								"accion"=>$paginasMenus["Pagina"]["accion"],
								"accionFantasia"=>$paginasMenus["Pagina"]["accion_fantasia"],
							);
						}
						$acceso[] = array("controlador"=>$paginasMenus["Pagina"]["controlador"], "accion"=>$paginasMenus["Pagina"]["accion"]);		
					}
				}
				

				if(!empty($menusPaginas))
					array_multisort($menusPaginas);				
				$this->Session->write("Acceso", $acceso);
				$this->Session->write("Menus", $menusPaginas);
				$this->Session->write("BotonesSecundarios", $menusSecundarios);
				if(empty($nombreUsuario["User"]["usuario"]) && !empty($nombreUsuario["User"]["nombre"]))
				{
					//CakeLog::write('actividad', 'ingreso el user - ' . $nombreUser["User"]["user"]);
					$this->request->data["id"] = $nombreUsuario["User"]["id"];
					$this->request->data["nombre"] = $this->Session->read('Users.nombre');
					$this->request->data["usuario"] = $this->Session->read('Users.usuario');
					$this->request->data["email"] = $this->Session->read('Users.email');
					
					if ($this->User->save($this->request->data))
					{
						//CakeLog::write('actividad', 'ingreso el user - ' . $nombreUser["User"]["user"]);
						$this->redirect(array('controller'=>'actividades',  'action' => 'index'));
						//pr($menusPaginas);
					}
				}
				else if(!empty($nombreUsuario["User"]["usuario"]) && !empty($nombreUsuario["User"]["nombre"]))
				{	
					//CakeLog::write('actividad', 'ingreso el user - ' . $nombreUser["User"]["user"] );
					$this->redirect(array('controller'=>'actividades',  'action' => 'index'));
					//pr($menusPaginas);
				}
				else
				{
					$this->Session->setFlash("Usted no tiene permiso para entrar al sistema comuniquese con el administrador", "msg_fallo");
					return $this->redirect(array('controller'=>'users', 'action' => 'login'));
				}	
			}
		}		

	}

	public function logout() {

		CakeLog::write('actividad', 'fin sesion el user - ' . $this->Session->read('Users.nombre'));
		$this->Session->destroy();
		$this->redirect(array('controller' => 'users', 'action' => 'login'));
	}

	public function add() {
		$this->layout = "angular";
	}

	public function add_json(){
		
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("User");

		if ($this->request->is(array('post'))) {
			$this->User->create();			
			$this->request->data["User"]["password"] = '*'.strtoupper(sha1(sha1($this->request->data["User"]["password"],true)));
			if ($this->User->save($this->request->data)){
				$respuesta = array(
					"estado"=>1,
					"mensaje"=>"Registrado correctamente",
					"id"=>$this->User->id
					);
			} else {
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"Nombre de usuario ya existe.",
					"id"=>null
					);
			}
		}
		$this->set("respuesta", $respuesta);
	}

	public function edit($id = null) {
		$this->layout = "angular";
	}

	public function edit_json($id = null) {

		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("User");
		$this->loadModel("Role");
		$this->loadModel("Trabajadore");

		$respuesta = array();
		if (!$this->User->exists($id)) {
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"User no válido.",
				"id"=>null
				);
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data["User"]["password"] = '*'.sha1(sha1($this->request->data["User"]["password"],true));
			if ($this->User->save($this->request->data)) {
				$respuesta = array(
					"estado"=>1,
					"mensaje"=>"Registrado correctamente.",
					"id"=>$this->User->id
					);
				
			} else {
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"Trabajador no pudo ser guardado.",
					"id"=>null
				);
			}
		} else {
			$options = array( "fields" => array("User.id","User.nombre","User.trabajadore_id", "User.role_id", "User.usuario", "Role.id", "Role.nombre", "Trabajadore.nombre",
				"Trabajadore.rut", "Trabajadore.email", "Trabajadore.apellido_paterno"),
				'conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
			$this->request->data;
		}
		$respuesta = $this->request->data;

		//pr($respuesta);exit;
		$this->set("respuesta", $respuesta);
	}

	public function perfil() {
		$this->layout = "angular";
	}

	public function perfil_json() {

		$this->layout = "ajax";
		$this->response->type('json');
		$respuesta = array();


		$datosUser = $this->User->find("first", array(
			"fields"=>array("User.id"),
			"conditions"=>array("User.id" =>  $this->Session->read('PerfilUsuario.idUsuario')),
			"recursive"=>0
			));
		$id = $datosUser["User"]["id"];
	
		if (!$this->User->exists($id)) {
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"User no válido.",
				"id"=>null
				);
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$respuesta = array(
					"estado"=>1,
					"mensaje"=>"Registrado correctamente.",
					"id"=>$this->User->id
					);
				
			} else {
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"Trabajador no pudo ser guardado.",
					"id"=>null
				);
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
			$this->request->data;
		}
		$respuesta = $this->request->data;
		$this->set("respuesta", $respuesta);
	}

	public function roles_usuario()
	{
		$this->layout = "ajax";
		//$this->response->type('json');
		$usuarios = $this->User->find('first', array(
			"conditions"=>array("User.id"=>$this->params->query["usuarioId"]),
			"fields"=>array("User.role_id"),
			"recursive"=>-1
		));
		$this->set("idRolesUsuarios", $usuarios["User"]["role_id"]);
	}


	public function lista_usuarios_json() {
		/*
		if($this->Session->Read("Users.flag") != 0)
		{
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
		 **/
		 
		$this->layout = "ajax";
		$this->response->type('json');
		$usuarios = $this->User->find('all', array(
			"fields"=>array("User.id", "User.nombre", "User.role_id", "Role.id", "Role.nombre"),
			"conditions"=>array("User.estado"=>1)
		));
		
		if(!empty($usuarios)){

			$usuariosJson = array();

			foreach($usuarios as $usuario){
				$usuariosJson[] = array(
					"UsuarioId"=>$usuario["User"]["id"],
					"UsuarioNombre"=>$usuario["User"]["nombre"],
					"UsuarioRolesId"=>$usuario["User"]["role_id"],
					"RoleId"=>$usuario["Role"]["id"],
					"RoleNombre"=>$usuario["Role"]["nombre"],
				);
			}			
		}

		$this->set('usuariosJson', $usuariosJson);
	}

	public function index(){
		
		if($this->Session->Read("Users.flag") != 0)
		{
			
			if($this->Session->Read("Accesos.accesoPagina") == 0)
			{
				$this->Session->setFlash('No tiene acceso a la pagina solicitada', 'msg_fallo');
				return $this->redirect(array("controller" => 'users', "action" => 'fallo'));
			}
		}
		else 
		{
			$this->Session->setFlash('Primero inicie Sesión', 'msg_fallo');
			return $this->redirect(array("controller" => 'users', "action" => 'login'));
		}
		$this->layout = "angular";
		/*
		$users = $this->User->find('all');
		$this->set('users', $users);		 
		 */
	}

	public function delete() {

		$this->autoRender = false;
		$this->response->type("json");		
		if($this->Session->Read("Users.flag") == 1)
		{			
			if($this->Session->Read("Accesos.accesoPagina") == 1)
			{
				if($this->request->isPost()){
					if($this->User->save($this->request->data)){
						CakeLog::write('actividad', 'Elimino - Users - Delete - '.$this->User->id.' el user ' .$this->Session->Read("PerfilUsuario.idUsuario"));
						$respuesta = array(
							"estado"=>1,
							"mensaje"=>"Se elimino el user correctamente"
							);
					}else{
						$respuesta = array(
							"estado"=>0,
							"mensaje"=>"No se pudo eliminar el user, por favor intentelo nuevamente"
							);		
					}
				}
			}else{
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"No tiene acceso a la pagina solicitada"
					);
			}
		}
		else 
		{
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>'Primero inicie Sesión'
				);
		}
		return json_encode($respuesta);
	}
	
	public function validacion()
	{
		$this->layout = "ajax";
		$users = $this->User->find('all');
		$this->set('users', $users);
		echo json_encode($users);
	}
	
	public function fallo()
	{
		$this->layout = "sin_acceso";
	}
	
	public function add_roles_usuarios()
	{
		$this->layout = "ajax";
		$this->response->type('json');
		$estado = array();
		
		if(!empty($this->params->query["usuarioId"]))
		{
			$existe = $this->User->find("first", array(
				"conditions"=>array("User.id"=>$this->params->query["usuarioId"], "User.role_id"=>$this->params->query["rolesId"]),
				"fields"=>array("User.id"),
				"recursive"=>0
			));
			
			if(empty($existe))
			{
				$this->request->data["User"]["id"] = $this->params->query["usuarioId"];
				$this->request->data["User"]["role_id"] = $this->params->query["rolesId"];
				$this->User->save($this->request->data);
				$estado = array("Error"=>1, "Mensaje"=>"ROL ASOCIADO CORRECTAMENTE");
			}
			else 
			{
				$estado = array("Error"=>1, "Mensaje"=>"NO SE PUDO GUARDAR, LA ASOCIACIÓN DE ROLES ES IGUAL A LA QUE YA ESTA REGISTRADA");
			}	
		}
		else
		{
			$estado = array("Error"=>0, "Mensaje"=>"NO SE PUEDE REGISTRAR. SELECCIONE AL MENOS USUARIO Y UN ROL");
		}
		$this->set("estado", $estado);
	}	
}
?>