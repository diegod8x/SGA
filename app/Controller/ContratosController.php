<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');
/**
 * Contratos Controller
 *
 * @property Contrato $Contrato
 * @property PaginatorComponent $Paginator
 */
class ContratosController extends AppController
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
		AppController::controlAcceso();
		$this->layout = "angular";
		if (!$this->Contrato->exists($id)) {
			$respuesta = array(
				"estado" => 0,
				"mensaje" => "Contrato no válido.",
				"id" => null
			);
		}
		$options = array('conditions' => array('Contrato.' . $this->Contrato->primaryKey => $id));
		$this->set('contrato', $this->Contrato->find('first', $options));
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

	public function add_json()
	{

		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("Producto");
		$this->loadModel("Cliente");
		$this->loadModel("NumeroCuota");
		$this->loadModel("Comuna");
		$this->loadModel("Regione");
		$edit = false;

		$productosActualizados = array();

		if ($this->request->is('post')) {

			if (array_key_exists("id", $this->request->data["Contrato"])) {
				$edit = true;
				$this->request->data["Contrato"]["modified_user"] = $this->Session->read("Users.usuario");
				unset($this->request->data["NumeroCuota"]);
				unset($this->request->data["Cliente"]);
				unset($this->request->data["TipoContrato"]);
				unset($this->request->data["Direccione"]);
			} else {
				$this->request->data["Contrato"]["created_user"] = $this->Session->read("Users.usuario");
			}

			$producto = $this->Producto->find("list", array("fields" => array("existencias")));
			$productos = array();
			$this->request->data["Contrato"]["fecha_inicio"] = date('Y-m-d', strtotime($this->request->data["Contrato"]["fecha_inicio"]));
			foreach ($this->request->data["ContratosProducto"] as $valor) {
				if (!array_key_exists($valor["producto_id"], $productos)) {
					$productos[$valor["producto_id"]] = 1;
				} else {
					$productos[$valor["producto_id"]] = $productos[$valor["producto_id"]] + 1;
				}
			}
			if ($this->request->data["Contrato"]["tipo_contrato_id"] == 2) {
				foreach ($productos as $key => $cantidad) {
					$productosActualizados[] = array("id" => $key, "existencias" => ($producto[$key] - $cantidad));
				}
			}

			$this->Producto->saveAll($productosActualizados);
			//pr($this->request->data);
			//exit;

			if ($this->Contrato->saveAssociated($this->request->data, array('deep' => true))) {
				$respuesta = array(
					"estado" => 1,
					"mensaje" => "Registrado correctamente",
					"id" => $this->Contrato->id
				);
			} else {
				$respuesta = array(
					"estado" => 0,
					"mensaje" => "No se pudo ingresar, por favor intente nuevamente",
					"id" => null
				);
			}

			if ($respuesta["estado"] == 1 && isset($this->request->data["Contrato"]["cliente_id"]) && !$edit) {

				$contrato = $this->Contrato->find('first', array("conditions" => array("Contrato.id" => $this->Contrato->id)));
				//$comunas = $this->Comuna->find('first', array('conditions' => array('Comuna.' . $this->Comuna->primaryKey => $contrato["Cliente"]["comuna_id"])));
				$comunas = $this->Comuna->find('first', array('conditions' => array('Comuna.' . $this->Comuna->primaryKey => $contrato["Direccione"]["comuna_id"])));
				//$contrato["Cliente"]["direccion"] = $contrato["Cliente"]["direccion"] . ', ' . $this->capitalizar($comunas["Comuna"]["nombre"] . ", " . $comunas["Regione"]["nombre"] . '.');
				$contrato["Cliente"]["direccion"] = $contrato["Direccione"]["nombre"] . ', ' . $this->capitalizar($comunas["Comuna"]["nombre"] . ", " . $comunas["Regione"]["nombre"] . '.');
				$correosCliente = array();

				if (isset($contrato["Cliente"]["email"]) && trim($contrato["Cliente"]["email"]) != '') {
					$correosCliente[] = $contrato["Cliente"]["email"];
				}
				if (isset($contrato["Cliente"]["email2"]) && trim($contrato["Cliente"]["email2"]) != '') {
					$correosCliente[] = $contrato["Cliente"]["email2"];
				}
				if (isset($contrato["Cliente"]["email3"]) && trim($contrato["Cliente"]["email3"]) != '') {
					$correosCliente[] = $contrato["Cliente"]["email3"];
				}

				if (!empty($correosCliente)) {
					$Email = new CakeEmail("gmail");
					$Email->from(array('info@camas.cl' => 'camas.cl'));

					$Email->to($correosCliente); //datosCorreo["email"]
					//$Email->to(["diego.leopoldo.diaz@gmail.com"]);
					$Email->subject("Incorporación contrato " . $contrato["Cliente"]["nombre"]);
					$Email->emailFormat('html');
					$Email->template('contratos_new', null);
					$Email->viewVars(array(
						"datos" => $contrato,
					));
					$Email->attachments(array(
						'image003.png' => array(
							'file' =>  WWW_ROOT . 'img' . DS . 'image003.png',
							'mimetype' => 'image/png',
							'contentId' => 'my-unique-id'
						)
					));
					if (!$Email->send()) {
						$respuesta = array(
							"estado" => 1,
							"mensaje" => "El correo no pudo ser enviado",
							"id" => $this->Actividade->id
						);
					}
				} else {
					$respuesta = array(
						"estado" => 1,
						"mensaje" => "Contrato guardado, pero no se pudo enviar correo.",
						"id" => $this->Actividade->id
					);
				}
			}
			/*else
			{
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"No se pudo guardar el contrato, favor intente nuevamente.",
					"id"=>isset($this->Actividade->id)? $this->Actividade->id : null
					);
			}*/
		} else {
			$respuesta = array(
				"estado" => 0,
				"mensaje" => "No se pudo enviar el formulario, intente nuevamente.",
				"id" => null
			);
		}
		$this->set("respuesta", $respuesta);
	}

	public function data_json()
	{

		$this->layout = "ajax";
		$this->response->type('json');

		$this->loadModel("Cliente");
		$this->loadModel("TipoContrato");
		$this->loadModel("Producto");
		$this->loadModel("NumeroCuota");

		$tipoContratos = $this->TipoContrato->find('all', array(
			"fields" => array("TipoContrato.id", "TipoContrato.nombre"),
			"recursive" => 0
		));
		foreach ($tipoContratos as $tipo) {
			$tipoContrato[] = $tipo["TipoContrato"];
		}

		$clientes = $this->Cliente->find('all', array(
			"fields" => array("Cliente.id", "Cliente.nombre"),
			"conditions" => array("Cliente.estado" => 1),
			"recursive" => 0
		));

		foreach ($clientes as $value) {
			$cliente[] = $value["Cliente"];
		}

		$nroCuotas = $this->NumeroCuota->find('all', array(
			"fields" => array("NumeroCuota.id", "NumeroCuota.numero"),
			"recursive" => -1
		));
		foreach ($nroCuotas as $cuota) {
			$cuotas[] = $cuota["NumeroCuota"];
		}

		$productos = $this->Producto->find('all', array("conditions" => array("Producto.estado" => 1), "recursive" => 0));
		foreach ($productos as $producto) {
			$listadoproductos[] = $producto["Producto"];
		}

		$contrato = array_merge(
			array("fecha_inicio" => date("d-m-Y")),
			array("fecha_cobro" => date("d")),
			array("tipo_contrato" => $tipoContrato),
			array("clientes" => $cliente),
			array("productos" => $listadoproductos),
			array("cuotas" => $cuotas)
		);
		//pr($contrato);exit;

		$this->set("dataContrato", $contrato);
	}

	public function enviar_correo_cliente($id = null)
	{
		$this->loadModel("Comuna");
		$this->loadModel("Regione");
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("Contrato");

		$contrato = $this->Contrato->find('first', array("conditions" => array("Contrato.id" => $this->request->data["Contrato"]["id"])));
		$this->Comuna->recursive = 0;
		$comunas = $this->Comuna->find('first', array('conditions' => array('Comuna.' . $this->Comuna->primaryKey => $contrato["Cliente"]["comuna_id"])));
		$contrato["Cliente"]["direccion"] = $contrato["Cliente"]["direccion"] . ', ' . $this->capitalizar($comunas["Comuna"]["nombre"] . ", " . $comunas["Regione"]["nombre"] . '.');
		$Email = new CakeEmail("gmail");
		$Email->from(array('info@camas.cl' => 'camas.cl'));
		//$Email->sender(array('info@camas.cl' => 'camas.cl'));

		if (trim($contrato["Cliente"]["email"]) == '' || !isset($contrato["Cliente"]["email"])) {
			$contrato["Cliente"]["email"] = null;
		}

		$Email->to($contrato["Cliente"]["email"]); //datosCorreo["email"]
		//$Email->to("diego.leopoldo.diaz@gmail.com");
		$Email->subject("Incorporación contrato " . $contrato["Cliente"]["nombre"]);
		$Email->emailFormat('html');
		$Email->template('contratos_new', null);
		$Email->viewVars(array(
			"datos" => $contrato,
		));
		$Email->attachments(array(
			'image003.png' => array(
				'file' =>  WWW_ROOT . 'img' . DS . 'image003.png',
				'mimetype' => 'image/png',
				'contentId' => 'my-unique-id'
			)
		));
		if ($Email->send()) {
			$respuesta = array(
				"estado" => 1,
				"mensaje" => "Correo enviado correctamente.",
				"id" => $this->Contrato->id
			);
		} else {
			$respuesta = array(
				"estado" => 0,
				"mensaje" => "No se pudo enviar correo. Chequee la dirección e intente más tarde.",
				"id" => null
			);
		}

		$this->set("respuesta", $respuesta);
	}

	public function capitalizar($string)
	{
		return ucwords(mb_strtolower($string, 'UTF-8'));
	}
	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($id = null)
	{
		AppController::controlAcceso();
		$this->layout = "angular";
	}

	public function edit_json($id = null)
	{
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("Contrato");
		$this->loadModel("Producto");
		$this->loadModel("Direccione");

		$respuesta = array();
		if (!$this->Contrato->exists($id)) {
			$respuesta = array(
				"estado" => 0,
				"mensaje" => "Contrato no válido.",
				"id" => null
			);
		}
		//pr($this->request->data);
		//exit;
		if ($this->request->is(array('post', 'put'))) {

			if ($this->Contrato->save($this->request->data)) {
				$respuesta = array(
					"estado" => 1,
					"mensaje" => "Registrado correctamente.",
					"id" => $this->Contrato->id
				);
			} else {
				$respuesta = array(
					"estado" => 0,
					"mensaje" => "Contrato no pudo ser guardado.",
					"id" => null
				);
			}
		} else {
			//$options = array('conditions' => array('Contrato.' . $this->Contrato->primaryKey => $id));
			$contrato["data"] = ContratosController::formulario($id);
			unset($contrato["data"]["Contrato"]["created"]);
			unset($contrato["data"]["Contrato"]["created_user"]);
			unset($contrato["data"]["Contrato"]["modified"]);
			$contrato["data"]["Contrato"]["modified_user"] = $this->Session->read("Users.usuario");

			$direccionesCliente = $this->Direccione->find('all', array(
				"fields" => array(
					"Direccione.id", "Direccione.nombre", "Comuna.nombre", "Regione.nombre"
				),
				"conditions" => array(
					"Direccione.estado" => 1,
					"Direccione.cliente_id" => $contrato["data"]["Contrato"]["cliente_id"]
				),
				"recursive" => 0
			));
			foreach ($direccionesCliente as $dir) {
				$contrato["direccionesCliente"][] = array(
					"id" => $dir["Direccione"]["id"],
					"nombre" => $dir["Direccione"]["nombre"] . ', ' . $this->capitalizar($dir["Comuna"]["nombre"] . ", " . $dir["Regione"]["nombre"] . '.'),
				);
			}

			//productos
			$productos = $this->Producto->find('all', array(
				"conditions" => array("Producto.estado" => 1),
				"recursive" => 0
			));
			foreach ($productos as $producto) {
				$contrato["listadoProductos"][] = $producto["Producto"];
			}
			//pr($contrato);
			//exit;
			$this->request->data = $contrato;
		}
		$respuesta = $this->request->data;

		$this->set("respuesta", $respuesta);
	}


	public function index()
	{
		AppController::controlAcceso();
		$this->layout = "angular";
	}

	public function reporte()
	{
		AppController::controlAcceso();
		$this->layout = "angular_full";
	}

	public function listado_contratos()
	{
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("Contrato");
		$listadoContratos = array();
		$contratos = $this->Contrato->find("all", array(
			"order" => "Contrato.id DESC",
			"recursive" => 0
		));
		if (!empty($contratos)) {
			foreach ($contratos as $contrato) {
				$contrato["Contrato"]["ds_estado"] = ($contrato["Contrato"]["estado"] == 1) ? "Activo" : "Cerrado";
				$contrato["Contrato"]["id"] = intval($contrato["Contrato"]["id"]);
				$contrato["Contrato"]["subtotal"] = intval($contrato["Contrato"]["subtotal"]);
				$contrato["Contrato"]["cantidad_productos"] = intval($contrato["Contrato"]["cantidad_productos"]);
				$contrato["Contrato"]["costo_despacho"] = intval($contrato["Contrato"]["costo_despacho"]);
				$contrato["Contrato"]["garantia"] = intval($contrato["Contrato"]["garantia"]);
				$contrato["Contrato"]["descuento"] = intval($contrato["Contrato"]["descuento"]);
				$contrato["Contrato"]["precio_total"] = intval($contrato["Contrato"]["precio_total"]);
				$listadoContratos[] = array_merge($contrato["Contrato"], array(
					"nombre_cliente" => $contrato["Cliente"]["nombre"],
					"contrato_id" => $contrato["TipoContrato"]["id"],
					"tipo_contrato" => $contrato["TipoContrato"]["nombre"],
				));
			}
		}
		$this->set("listadoContratos", $listadoContratos);
	}

	public function reporte_json()
	{
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("Contrato");
		$this->loadModel("ContratosProducto");
		$this->loadModel("Empresa");
		$listadoContratos = array();

		$contratoModel = ClassRegistry::init('Contrato');
		$contratoModel->unbindModel(array('hasMany' => array('Actividade')));
		$contratoModel->unbindModel(array('belongsTo' => array('NumeroCuota')));
		$contratoModel->unbindModel(array('belongsTo' => array('FormaPago')));
		$contratoModel->unbindModel(array('hasMany' => array('ContratosProducto')));

		$contratos = $this->Contrato->find("all", array(
			'fields' => array(
				'Contrato.id', "Contrato.estado", 'Contrato.subtotal', "Contrato.cantidad_productos",
				'Contrato.created', "Contrato.created_user", 'Contrato.modified', "Contrato.modified_user",
				"Contrato.costo_despacho", "Contrato.garantia", "Contrato.descuento", "Contrato.precio_total", "Contrato.fecha_inicio",
				'Cliente.id', 'Cliente.rut', "Cliente.nombre", "Cliente.empresa_id",
				'TipoContrato.id', 'TipoContrato.nombre'
			),
			//"conditions" => array("Contrato.id" => 34),
			"recursive" => 1
		));

		$empresas = $this->Empresa->find("all", array(
			"fields" => array("id", "nombre"),
			"order" => "Empresa.id DESC",
			"recursive" => -1
		));
		$empresasList = array();
		foreach ($empresas as $empresa) {
			$empresasList[$empresa["Empresa"]["id"]] = $empresa["Empresa"]["nombre"];
		}
		if (!empty($contratos)) {
			foreach ($contratos as $contrato) {
				$dsProductos = array();
				if (!empty($contrato["Producto"])) {
					foreach ($contrato["Producto"] as $producto) {
						$dsProductos[] =  $producto["nombre"];
					}
					$dsProducto = implode(", ", $dsProductos);
				}
				$contrato["Contrato"]["ds_estado"] = ($contrato["Contrato"]["estado"] == 1) ? "Activo" : "Cerrado";
				$contrato["Contrato"]["id"] = intval($contrato["Contrato"]["id"]);
				$contrato["Contrato"]["subtotal"] = intval($contrato["Contrato"]["subtotal"]);
				$contrato["Contrato"]["cantidad_productos"] = intval($contrato["Contrato"]["cantidad_productos"]);
				$contrato["Contrato"]["costo_despacho"] = intval($contrato["Contrato"]["costo_despacho"]);
				$contrato["Contrato"]["garantia"] = intval($contrato["Contrato"]["garantia"]);
				$contrato["Contrato"]["descuento"] = intval($contrato["Contrato"]["descuento"]);
				$contrato["Contrato"]["precio_total"] = intval($contrato["Contrato"]["precio_total"]);
				$contrato["Contrato"]["nombre_productos"] = $dsProducto;
				$listadoContratos[] = array_merge($contrato["Contrato"], array(
					"rut" => $contrato["Cliente"]["rut"],
					"nombre_cliente" => $contrato["Cliente"]["nombre"],
					"contrato_id" => $contrato["TipoContrato"]["id"],
					"tipo_contrato" => $contrato["TipoContrato"]["nombre"],
					"empresa" => (isset($contrato["Cliente"]["empresa_id"]) && isset($empresasList[$contrato["Cliente"]["empresa_id"]])) ? $empresasList[$contrato["Cliente"]["empresa_id"]] : '-'
				));
			}
			//pr($listadoContratos);
		}
		$this->set("listadoContratos", $listadoContratos);
	}


	public function formulario($id = null)
	{
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("Contrato");
		$this->loadModel("Producto");

		$productos = $this->Producto->find('all', array("recursive" => 0));
		foreach ($productos as $key => $producto) {
			$dataProductos[$producto["Producto"]["id"]] = $producto["Producto"];
		}

		$this->Contrato->Behaviors->attach('Containable');
		$this->Contrato->contain(
			"TipoContrato.id",
			"TipoContrato.nombre",
			"Cliente.id",
			"Cliente.nombre",
			"ContratosProducto.id",
			//"ContratosProducto.id",
			"ContratosProducto.contrato_id",
			"ContratosProducto.producto_id",
			"ContratosProducto.precio_arriendo",
			"ContratosProducto.precio_venta",
			"ContratosProducto.observaciones",
			"ContratosProducto.cantidad",
			"ContratosProducto.estado",
			"ContratosProducto.subtotal",
			"NumeroCuota.numero",
			"Direccione.id",
		);
		//pr($idContrato);exit;
		$formulario = $this->Contrato->find("first", array(
			"conditions" => array("Contrato.id" => $id),
			"recursive" => 1
		));

		if (!empty($formulario["ContratosProducto"])) {
			foreach ($formulario["ContratosProducto"] as $key => $producto) {
				$formulario["ContratosProducto"][$key]["nombre"] = $dataProductos[$producto["producto_id"]]["nombre"];
				$formulario["ContratosProducto"][$key]["descripcion"] = $dataProductos[$producto["producto_id"]]["descripcion"];
			}
		}

		$formulario["Contrato"]["id"] = floatval($formulario["Contrato"]["id"]);
		$formulario["Contrato"]["cantidad_productos"] = floatval($formulario["Contrato"]["cantidad_productos"]);
		$formulario["Contrato"]["precio_total"] = floatval($formulario["Contrato"]["precio_total"]);
		$formulario["Contrato"]["descuento"] = floatval($formulario["Contrato"]["descuento"]);
		$formulario["Contrato"]["costo_despacho"] = floatval($formulario["Contrato"]["costo_despacho"]);
		$formulario["Contrato"]["garantia"] = floatval($formulario["Contrato"]["garantia"]);
		// Comentarios $formulario["Contrato"]["estado"] = ($formulario["Contrato"]["estado"]==1)? "Activo": "Cerrado";

		$this->set("respuesta", $formulario);
		return $formulario;
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
		$this->Contrato->id = $id;
		if (!$this->Contrato->exists()) {
			throw new NotFoundException(__('Contrato Inválido'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Contrato->delete()) {
			$this->Flash->success(__('El contrato ha sido eliminado.'));
		} else {
			$this->Flash->error(__('El contrato no pudo ser eliminado. Intente mas tarde.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
