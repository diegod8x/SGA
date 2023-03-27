<?php
App::uses('AppController', 'Controller');
/**
 * Direcciones Controller
 *
 * @property Direccione $Direccione
 * @property PaginatorComponent $Paginator
 */
class DireccionesController extends AppController
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

		if (!$this->Direccione->exists($id)) {
			throw new NotFoundException(__('Dirección no válida'));
		}
		$options = array('conditions' => array('Direccione.' . $this->Direccione->primaryKey => $id));
		$this->set('direccione', $this->Direccione->find('first', $options));
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add($id = null)
	{
		AppController::controlAcceso();
		$this->layout = "angular";
	}
	public function add_json($id = null)
	{
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("Cliente");

		if ($this->request->is('post')) {
			if (is_array($this->request->data["Direccione"]["cliente_id"])) {
				$this->request->data["Direccione"]["cliente_id"] = $this->request->data["Direccione"]["cliente_id"]["id"];
			}

			$this->Direccione->create();
			if ($this->Direccione->save($this->request->data)) {
				$respuesta = array(
					"estado" => 1,
					"mensaje" => "Registrado correctamente",
					"id" => $this->Direccione->id
				);
			} else {
				$respuesta = array(
					"estado" => 0,
					"mensaje" => "No se pudo ingresar, por favor intente nuevamente",
					"id" => null
				);
			}
		}

		$this->set("respuesta", $respuesta);
	}

	public function cliente_json($id)
	{
		$this->layout = "ajax";
		$this->response->type('json');
		$options = array(
			"fields" => array(
				"Direccione.nombre", "Comuna.nombre", "Regione.nombre", "Cliente.nombre", "Cliente.rut"
			),
			'conditions' => array(
				'Direccione.cliente_id' => $id,
				"Direccione.estado" => 1,

			),
			"order" => "Direccione.id ASC",
		);
		$direcciones = $this->Direccione->find('all', $options);
		$listadoDirecciones = [];
		if (!empty($direcciones)) {
			foreach ($direcciones as $value) {
				$listadoDirecciones[] = array(
					"id" => $value["Direccione"]["id"],
					"nombre" => ucwords(mb_strtolower($value["Direccione"]["nombre"], 'UTF-8')) . ", " . ucwords(mb_strtolower($value["Comuna"]["nombre"], 'UTF-8')),
					//"comuna" => ucwords(mb_strtolower($value["Comuna"]["nombre"], 'UTF-8')),
					//"region" => ucwords(mb_strtolower($value["Regione"]["nombre"], 'UTF-8')),
				);
			}
		}

		$this->set("direcciones", $listadoDirecciones);
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
		$this->response->type("json");
		$respuesta = array();
		if (!$this->Direccione->exists($id)) {
			$respuesta = array(
				"estado" => 0,
				"mensaje" => "Dirección no válida."
			);
			$this->set("respuesta", $respuesta);
			return;
		}

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Direccione->save($this->request->data)) {
				$respuesta = array(
					"estado" => 1,
					"mensaje" => "Registrado correctamente.",
					"id" => $this->Empresa->id
				);
			} else {
				$respuesta = array(
					"estado" => 0,
					"mensaje" => "Empresa no pudo ser guardada."
				);
			}
		} else {
			$options = array('conditions' => array('Direccione.' . $this->Direccione->primaryKey => $id));
			$this->request->data = $this->Direccione->find('first', $options);
			$respuesta = array(
				"estado" => 1,
				"mensaje" => "OK",
				"data" => $this->request->data
			);
		}

		$this->set("respuesta", $respuesta);
	}

	public function index($id = null)
	{
		AppController::controlAcceso();
		$this->layout = "angular";
	}

	public function listado_direcciones($id = null)
	{
		$this->layout = "ajax";
		$this->response->type("json");
		$direcciones = $this->Direccione->find("all", array(
			"fields" => array(
				"Direccione.nombre", "Direccione.estado", "Comuna.nombre", "Regione.nombre", "Cliente.nombre", "Cliente.rut", "Cliente.id"
			),
			//"conditions" => array("Direccione.estado" => 1),
			"order" => "Cliente.nombre ASC",
			"recursive" => 0
		));
		//pr($direcciones);
		//exit;
		foreach ($direcciones as $value) {
			$listadoDirecciones[] = array(
				"id" => $value["Direccione"]["id"],
				"cliente" => $value["Cliente"]["nombre"],
				"rut" => $value["Cliente"]["rut"],
				"direccion" => ucwords(mb_strtolower($value["Direccione"]["nombre"], 'UTF-8')),
				"comuna" => ucwords(mb_strtolower($value["Comuna"]["nombre"], 'UTF-8')),
				"region" => ucwords(mb_strtolower($value["Regione"]["nombre"], 'UTF-8')),
				"estado" => $value["Direccione"]["estado"] ? "ACTIVO" : "INACTIVO",
				"cliente_id" => $value["Cliente"]["id"]
			);
			// $value["Direccione"]["nombre"] . ', ' . ucwords(mb_strtolower($value["Comuna"]["nombre"], 'UTF-8'));
			// $value["Direccione"][""] = $value["Direccione"]["nombre"] . ', ' . ucwords(mb_strtolower($value["Comuna"]["nombre"], 'UTF-8'));
			// $listadoDirecciones[] = $value["Direccione"];
		}

		$this->set("listadoDirecciones", $listadoDirecciones);
	}


	public function migrar()
	{
		$this->layout = "ajax";
		$this->response->type("json");
		$this->loadModel("Cliente");
		$this->loadModel("Contrato");

		$clientesId = $this->Contrato->find(
			"list",
			array(
				"fields" => array("Contrato.cliente_id"),
				"conditions" => array(
					"Contrato.cliente_id !=" => null,
					//"Contrato.id IN" => array(50, 51, 52)
				),
				"recursive" => -1
			)
		);
		$clientes = $this->Cliente->find("all", array(
			"fields" => array(
				"Cliente.id",
				"Cliente.direccion",
				"Cliente.regione_id",
				"Cliente.comuna_id"
			),
			"conditions" => [
				array("Cliente.id IN" => $clientesId),
			],
			"recursive" => 0
		));
		$contratosActualizados = [];
		$this->Direccione->query('TRUNCATE direcciones;');
		foreach ($clientes as $value) {
			$direccion = array(
				"nombre" => $value["Cliente"]["direccion"],
				"regione_id" => $value["Cliente"]["regione_id"],
				"comuna_id" => $value["Cliente"]["comuna_id"],
				"cliente_id" => $value["Cliente"]["id"],
				"estado" => 1,
			);
			$this->Direccione->create();
			$last = $this->Direccione->save($direccion);
			if (isset($last["Direccione"]["id"])) {
				$contratos = $this->Contrato->find("all", array(
					"conditions" => array("Contrato.cliente_id" => $last["Direccione"]["cliente_id"]),
					"recursive" => -1
				));

				if (!empty($contratos)) {
					foreach ($contratos as $contrato) {
						$contrato["Contrato"]["direccione_id"] = $last["Direccione"]["id"];
						$contratosActualizados[] = $contrato;
					}
				}
			}
		}
		$this->Contrato->saveMany($contratosActualizados);
		exit;
	}
}
