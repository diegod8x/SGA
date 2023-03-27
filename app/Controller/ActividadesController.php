<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Actividades Controller
 *
 * @property Actividade $Actividade
 * @property PaginatorComponent $Paginator
 */
class ActividadesController extends AppController
{

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator');

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($id = null)
	{

		if (!$this->Actividade->exists($id)) {
			throw new NotFoundException(__('Invalid actividade'));
		}
		$options = array('conditions' => array('Actividade.' . $this->Actividade->primaryKey => $id));
		$actividad = $this->Actividade->find('first', $options);
		if (trim($actividad["Actividade"]["direccione_id"]) != '') {
			$actividad["Actividade"]["direccion"] = $this->get_direccion($actividad["Actividade"]["direccione_id"]);
		}
		//$actividad["Actividade"]["direccion"] = $actividad["Actividade"]["direccion"] . ', ' . $this->capitalizeFirst($actividad["Comuna"]["nombre"]) . ', ' . $this->capitalizeFirst($actividad["Regione"]["nombre"]);
		$actividad["Trabajadore"]["nombre_completo"] = strtok($actividad["Trabajadore"]["nombre"], " ") . ' ' . $actividad["Trabajadore"]["apellido_paterno"];

		$this->set('actividade', $actividad);
	}

	public function capitalizeFirst($string)
	{
		//pr($string);
		$nombreCargo = "";
		$cargo = explode(" ", trim($string));
		foreach ($cargo as $palabra) {
			$nombreCargo .= (strlen($palabra) > 2) ? ucwords(mb_strtolower($palabra, 'UTF-8')) . ' ' : $palabra . ' ';
		}
		return $nombreCargo;
	}



	/**
	 * add method
	 *
	 * @return void
	 */
	public function add()
	{
		AppController::controlAcceso();
		$this->layout = "angular";
	}

	public function add_actividad()
	{

		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("Actividade");
		$this->loadModel("Trabajadore");
		$this->loadmodel("Producto");
		$productosNuevos = array();
		//edit
		if (is_array($this->request->data["Actividade"]["cliente_id"])) {
			$this->request->data["Actividade"]["cliente_id"] = $this->request->data["Actividade"]["cliente_id"]["id"];
		}

		if (array_key_exists("productosNuevos", $this->request->data)) {
			$productosNuevos = $this->request->data["productosNuevos"];
		}

		if (array_key_exists("id", $this->request->data["Actividade"])) {

			if ($this->Actividade->saveAssociated($this->request->data, array('deep' => true))) {
				$respuesta = array(
					"estado" => 1,
					"mensaje" => "Registrado correctamente",
					"id" => $this->Actividade->id
				);
			} else {
				$respuesta = array(
					"estado" => 0,
					"mensaje" => "No se pudo ingresar, por favor intente nuevamente",
					"id" => null
				);
			}
			if ($respuesta["estado"] == 1) {

				$productosEntrega = array();

				$options = array('conditions' => array('Trabajadore.' . $this->Trabajadore->primaryKey => $this->request->data["Actividade"]["trabajadore_id"]), "recursive" => -1);
				$trabajador = $this->Trabajadore->find('first', $options);
				$options = array('conditions' => array('Actividade.' . $this->Actividade->primaryKey => $this->request->data["Actividade"]["id"]), "recursive" => 2);
				$actividad = $this->Actividade->find('first', $options);

				$actividad["Actividade"]["direccion"] = isset($actividad["Actividade"]["direccione_id"]) ? $this->get_direccion($actividad["Actividade"]["direccione_id"]) : "-";

				$actividad["ProductoEntrega"] = $productosEntrega;
				$Email = new CakeEmail("gmail");
				$Email->from(array('info@camas.cl' => 'SGA'));
				$Email->to($trabajador["Trabajadore"]["email"]); //datosCorreo["email"]
				$Email->cc('actividades@camas.cl');
				//$Email->to('diego.leopoldo.diaz@gmail.com');
				$Email->subject("Nuevo comentario en Actividad");
				$Email->emailFormat('html');
				$Email->template('actividades_edit', null);
				$Email->viewVars(array(
					"datos" => $actividad,
				));
				//pr($actividad);exit;
				if (!$Email->send()) {
					$respuesta = array(
						"estado" => 1,
						"mensaje" => "El correo no pudo ser enviado",
						"id" => $this->Actividade->id
					);
				}
			}
		} else {
			//add
			if ($this->request->is('post')) {
				$this->Actividade->create();
				if (is_array($this->request->data["Actividade"]["cliente_id"])) {
					$this->request->data["Actividade"]["cliente_id"] = $this->request->data["Actividade"]["cliente_id"]["id"];
				}

				if ($this->Actividade->save($this->request->data)) {
					$respuesta = array(
						"estado" => 1,
						"mensaje" => "Registrado correctamente",
						"id" => $this->Actividade->id
					);
				} else {
					$respuesta = array(
						"estado" => 0,
						"mensaje" => "No se pudo ingresar, por favor intente nuevamente",
						"id" => null
					);
				}
			}
			if ($respuesta["estado"] == 1) {
				$productosEntrega = array();
				if (!empty($productosNuevos)) {
					$options = array('conditions' => array('Producto.' . $this->Producto->primaryKey => $productosNuevos), "recursive" => -1);
					$descProductos = $this->Producto->find('all', $options);
					$prodActividad["ProductosNuevos"] = $descProductos;
					if (!empty($descProductos)) {
						foreach ($descProductos as $descripcion) {
							$descProducto[$descripcion["Producto"]["id"]] = array(
								"nombre" => $descripcion["Producto"]["nombre"],
								"descripcion" => $descripcion["Producto"]["descripcion"]
							);
						}
						foreach ($productosNuevos as $prod) {
							$productosEntrega[] = $descProducto[$prod];
						}
					}
				}
				$options = array('conditions' => array('Trabajadore.' . $this->Trabajadore->primaryKey => $this->request->data["Actividade"]["trabajadore_id"]), "recursive" => -1);
				$trabajador = $this->Trabajadore->find('first', $options);

				$options = array('conditions' => array('Actividade.' . $this->Actividade->primaryKey => $this->Actividade->id), "recursive" => 2);
				$actividad = $this->Actividade->find('first', $options);
				if (trim($actividad["Actividade"]["direccione_id"]) != '') {
					//$actividad["Actividade"]["direccion"] = $actividad["Actividade"]["direccion"] . ', ' . $this->capitalizeFirst($actividad["Comuna"]["nombre"]) . ', ' . $this->capitalizeFirst($actividad["Regione"]["nombre"]);
					$actividad["Actividade"]["direccion"] = $this->get_direccion($actividad["Actividade"]["direccione_id"]);
				}
				$actividad["Trabajadore"]["nombre_completo"] = strtok($actividad["Trabajadore"]["nombre"], " ") . ' ' . $actividad["Trabajadore"]["apellido_paterno"];

				$actividad["ProductoEntrega"] = $productosEntrega;
				$Email = new CakeEmail("gmail");
				$Email->from(array('info@camas.cl' => 'SGA'));
				$Email->to($trabajador["Trabajadore"]["email"]); //datosCorreo["email"]
				$Email->cc('actividades@camas.cl');
				//$Email->to('diego.leopoldo.diaz@gmail.com');
				$Email->subject("Nueva Actividad del tipo " . $actividad["TipoActividade"]["nombre"]);
				$Email->emailFormat('html');
				$Email->template('actividades_new', null);
				$Email->viewVars(array(
					"datos" => $actividad,
				));
				//pr($actividad);exit;
				if (!$Email->send()) {
					$respuesta = array(
						"estado" => 1,
						"mensaje" => "El correo no pudo ser enviado",
						"id" => $this->Actividade->id
					);
				}
			}
		}
		$this->set("respuesta", $respuesta);
	}

	public function get_direccion($id)
	{
		$this->loadModel("Direccione");
		if ($this->Direccione->exists($id)) {
			$options = array('conditions' => array('Direccione.' . $this->Direccione->primaryKey => $id));
			$direccion = $this->Direccione->find('first', $options);
			return $this->capitalizeFirst($direccion["Direccione"]["nombre"] . ', ' . $direccion["Comuna"]["nombre"] . ', ' . $direccion["Regione"]["nombre"]);
		}
		return "";
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit()
	{
		AppController::controlAcceso();
		$this->layout = "angular";
	}

	public function edit_act()
	{
		AppController::controlAcceso();
		$this->layout = "angular";
	}

	public function edit_json($id = null)
	{

		$this->layout = "ajax";
		$this->response->type('json');
		$respuesta = array();
		$this->loadModel("Actividade");

		$actividad = $this->Actividade->find("first",  array(
			"conditions" => array("Actividade.id" => $id),
			"recursive" => -1
		));
		//$data = ActividadesController::data_json();
		$actividadData = array(
			"actividad" => $actividad["Actividade"],
			//"data"=>$data
		);
		$this->set("respuesta", $actividadData);
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null)
	{
		$this->Actividade->id = $id;
		if (!$this->Actividade->exists()) {
			throw new NotFoundException(__('Invalid actividade'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Actividade->delete()) {
			$this->Flash->success(__('The actividade has been deleted.'));
		} else {
			$this->Flash->error(__('The actividade could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function data_json()
	{

		$this->layout = "ajax";
		$this->response->type('json');
		//$respuesta = array();

		$this->loadModel("Trabajadore");
		$this->loadModel("TipoActividade");
		$this->loadModel("Cliente");
		$this->loadModel("TipoContrato");
		$this->loadModel("ContratosProducto");
		$this->loadModel("EstadoActividade");
		$this->loadModel("Comuna");
		$this->loadModel("Regione");

		//$tipoContratos = $this->TipoContrato->find("list",  array("fields" => array("nombre"), "recursive" => 0));
		$comunas = $this->Comuna->find("list",  array("fields" => array("Comuna.id", "Comuna.nombre"), "recursive" => 0));
		array_walk($comunas, function (&$a) {
			$a = $this->capitalizeFirst($a);
		});
		$regiones = $this->Regione->find("list",  array("fields" => array("Regione.id", "Regione.nombre"), "recursive" => 0));
		array_walk($regiones, function (&$a) {
			$a = $this->capitalizeFirst($a);
		});

		$trabajadores = $this->Trabajadore->find('all', array(
			"conditions" => array("Trabajadore.estado_trabajadore_id" => 1),
			"recursive" => 0
		));
		foreach ($trabajadores as  $key => $trabajador)
			$listadoTrabajadores[] = array_merge(
				$trabajador["Trabajadore"],
				array("nombre_completo" => strtok($trabajador["Trabajadore"]["nombre"], " ") . ' ' . $trabajador["Trabajadore"]["apellido_paterno"])
			);

		$tpActividades = $this->TipoActividade->find('all', array(
			"conditions" => array("TipoActividade.estado" => 1),
			"order" => array("TipoActividade.orden ASC"),
			"recursive" => 0
		));
		foreach ($tpActividades as $actividad)
			$tipoActividades[] = $actividad["TipoActividade"];

		$stActividades = $this->EstadoActividade->find('all', array(
			"recursive" => 0
		));
		foreach ($stActividades as $estado)
			$estadoActividades[] = $estado["EstadoActividade"];

		$clientes = $this->Cliente->find('all', array("recursive" => 1));
		foreach ($clientes as $cliente) {
			$listadoClientes[] = $cliente["Cliente"];

			foreach ($cliente["Contrato"] as $key => $value) {
				$listadoContratos[$cliente["Cliente"]["id"]] =  array_merge(
					$cliente["Contrato"][$key],
					array("nombre" => "# " . $cliente["Contrato"][$key]["id"] . " - Fecha: " . $cliente["Contrato"][$key]["fecha_inicio"])
				);
			}
		}

		$productos = $this->ContratosProducto->find('all', array(
			"recursive" => -1
		));
		foreach ($productos as $key => $producto) {
			$listadoProductos[$producto["ContratosProducto"]["contrato_id"]][] = $producto["ContratosProducto"];
		}

		$data = array_merge(
			array("Trabajadore" => $listadoTrabajadores),
			array("TipoActividade" => $tipoActividades),
			array("Clientes" => $listadoClientes),
			array("ContratosCliente" => $listadoContratos),
			array("EstadoActividade" => $estadoActividades),
			array("Comuna" => $comunas),
			array("Rgione" => $regiones),
		);

		$this->set("dataActividades", $data);
		return $data;
	}

	public function consolidado()
	{
		AppController::controlAcceso();
		$this->layout = "angular";
	}

	public function listado_consolidado($fInicio = null, $fTermino = null)
	{
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("Actividade");
		$this->loadModel("TipoActividade");
		$this->loadModel("EstadoActividade");
		$this->loadModel("Trabajadore");
		$this->loadModel("Comuna");
		$this->loadModel("Cliente");

		$tipoActividades = $this->TipoActividade->find(
			"list",
			array(
				"fields" => array("nombre"),
				"order" => array("TipoActividade.orden ASC"),
				"recursive" => 0
			)
		);
		$comunas = $this->Comuna->find("list",  array("fields" => array("nombre"), "recursive" => 0));
		$listadoTrabajadores = $this->Trabajadore->find("all",  array("fields" => array("Trabajadore.nombre", "Trabajadore.apellido_paterno"), "recursive" => 0));
		foreach ($listadoTrabajadores as $trabajador) {
			$listTrabajadores[$trabajador["Trabajadore"]["id"]] = strtok($trabajador["Trabajadore"]["nombre"], " ") . ' ' . $trabajador["Trabajadore"]["apellido_paterno"];
		}
		$estadoActividades = $this->EstadoActividade->find("list",  array("fields" => array("nombre"), "recursive" => 0));
		$nombreClientes = $this->Cliente->find("list",  array("fields" => array("id", "nombre"), "recursive" => 0));
		if ($fInicio) {
			$conditions = array(
				"Actividade.fecha_ingreso >=" => $fInicio,
				"Actividade.fecha_ingreso <=" => $fTermino,
			);
		} else {
			$conditions = array();
		}

		$actividades = $this->Actividade->find("all", array(
			"conditions" => $conditions,
			"recursive" => 0,
			"order" => array("Actividade.fecha_ingreso DESC, Actividade.estado_actividade_id ASC")
		));
		if (!empty($actividades)) {
			foreach ($actividades as $key => $actividad) {
				//$comuna = (isset($actividad["Actividade"]["comuna_id"])) ? ucwords(mb_strtolower($comunas[$actividad["Actividade"]["comuna_id"]], 'UTF-8')) : '';
				$listadoActividades[] = array_merge(
					$actividad["Actividade"],
					array(
						"tipo_actividad" => $tipoActividades[$actividad["Actividade"]["tipo_actividade_id"]],
						"estado" => $estadoActividades[$actividad["Actividade"]["estado_actividade_id"]],
						"nombre_trabajador" => $listTrabajadores[$actividad["Actividade"]["trabajadore_id"]],
						//"direccion_completa" => $actividad["Actividade"]["direccion"] . ', ' . $comuna,
						"nombre_cliente" =>
						isset($actividad["Actividade"]["cliente_id"]) && isset($nombreClientes[$actividad["Actividade"]["cliente_id"]]) ?
							$nombreClientes[$actividad["Actividade"]["cliente_id"]] : ''
					)
				);
			}
		} else {
			$listadoActividades = array();
		}

		$this->set("listadoActividades", $listadoActividades);
	}

	public function index()
	{
		AppController::controlAcceso();
		$this->layout = "angular";
	}

	public function listado_trabajador($fInicio = null, $fTermino = null)
	{

		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("User");
		$this->loadModel("Actividade");
		$this->loadModel("TipoActividade");
		$this->loadModel("EstadoActividade");
		$this->loadModel("Trabajadore");
		$this->loadModel("Comuna");
		$this->loadModel("Cliente");
		$datosUser = $this->User->find("first", array(
			"fields" => array("User.trabajadore_id"),
			"conditions" => array("User.id" =>  $this->Session->read('PerfilUsuario.idUsuario')),
			"recursive" => 0
		));
		$comunas = $this->Comuna->find("list",  array("fields" => array("nombre"), "recursive" => 0));
		$tipoActividades = $this->TipoActividade->find(
			"list",
			array(
				"fields" => array("nombre"),
				"order" => array("TipoActividade.orden ASC"),
				"recursive" => 0
			)
		);

		$listadoTrabajadores = $this->Trabajadore->find("all",  array("fields" => array("Trabajadore.nombre", "Trabajadore.apellido_paterno"), "recursive" => 0));
		foreach ($listadoTrabajadores as $trabajador) {
			$listTrabajadores[$trabajador["Trabajadore"]["id"]] = strtok($trabajador["Trabajadore"]["nombre"], " ") . ' ' . $trabajador["Trabajadore"]["apellido_paterno"];
		}
		$estadoActividades = $this->EstadoActividade->find("list",  array("fields" => array("nombre"), "recursive" => 0));
		$nombreClientes = $this->Cliente->find("list",  array("fields" => array("id", "nombre"), "recursive" => 0));
		if ($fInicio) {
			$conditions = array(
				"Actividade.fecha_ingreso >=" => $fInicio,
				"Actividade.fecha_ingreso <=" => $fTermino
			);
		} else
			$conditions = array();

		$actividades = $this->Actividade->find("all", array(
			"conditions" => array(
				array("Actividade.trabajadore_id" => $datosUser["User"]["trabajadore_id"], $conditions)
			),
			"recursive" => 0,
			"order" => array("Actividade.fecha_ingreso DESC, Actividade.estado_actividade_id ASC")
		));
		if (!empty($actividades)) {
			foreach ($actividades as $key => $actividad) {
				$comuna = (isset($actividad["Actividade"]["comuna_id"])) ? ucwords(mb_strtolower($comunas[$actividad["Actividade"]["comuna_id"]], 'UTF-8')) : '';
				$listadoActividades[] = array_merge($actividad["Actividade"], array(
					"tipo_actividad" => $tipoActividades[$actividad["Actividade"]["tipo_actividade_id"]],
					"estado" => $estadoActividades[$actividad["Actividade"]["estado_actividade_id"]],
					"nombre_trabajador" => $listTrabajadores[$actividad["Actividade"]["trabajadore_id"]],
					"direccion_completa" => $actividad["Actividade"]["direccion"] . ', ' . $comuna,
					"nombre_cliente" => isset($actividad["Actividade"]["cliente_id"]) && isset($nombreClientes[$actividad["Actividade"]["cliente_id"]]) ?
						$nombreClientes[$actividad["Actividade"]["cliente_id"]] : ''
				));
			}
		} else {
			$listadoActividades = array();
		}
		$this->set("listadoActividades", $listadoActividades);
	}
}
