<?php
App::uses('AppController', 'Controller');
App::uses('ServiciosController', 'Controller');
App::uses('RecaudacionesController', 'Controller');
/**
 * Clientes Controller
 *
 * @property Cliente $Clientef
 * @property PaginatorComponent $Paginator
 */
class ClientesController extends AppController
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
		if (!$this->Cliente->exists($id)) {
			$respuesta = array(
				"estado" => 0,
				"mensaje" => "Cliente no válido.",
				"id" => null
			);
		}
		$options = array('conditions' => array('Cliente.' . $this->Cliente->primaryKey => $id));
		$this->set('cliente', $this->Cliente->find('first', $options));
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
		$this->loadModel("Direccione");
		if ($this->request->is('post')) {
			$this->Cliente->create();

			if (isset($this->request->data["Cliente"]["Direccione"])) {
				$direccion = $this->request->data["Cliente"]["Direccione"];
			}
			unset($this->request->data["Cliente"]["Direccione"]);
			$last = $this->Cliente->save($this->request->data);
			if ($last["Cliente"]["id"]) {
				if (isset($direccion)) {
					$direccion["cliente_id"] = $last["Cliente"]["id"];
					$this->Direccione->save($direccion);
				}
				$respuesta = array(
					"estado" => 1,
					"mensaje" => "Registrado correctamente",
					"id" => $this->Cliente->id
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

	public function edit_json($id = null, $contratoId = null)
	{
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("Contrato");
		$this->loadModel("Comuna");
		$this->loadModel("Regione");
		$respuesta = array();

		if (!$this->Cliente->exists($id)) {
			$respuesta = array(
				"estado" => 0,
				"mensaje" => "Cliente no válido.",
				"id" => null
			);
			$this->set("respuesta", $respuesta);
			return;
		}

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Cliente->save($this->request->data)) {
				$respuesta = array(
					"estado" => 1,
					"mensaje" => "Registrado correctamente.",
					"id" => $this->Cliente->id
				);
			} else {
				$respuesta = array(
					"estado" => 0,
					"mensaje" => "Cliente no pudo ser guardado.",
					"id" => null
				);
			}
		} else {
			$options = array(
				"fields" => array("Cliente.*"),
				'conditions' => array(
					'Cliente.' . $this->Cliente->primaryKey => $id
				),
				"recursive" => 0
			);
			$this->request->data = $this->Cliente->find('first', $options);
			$respuesta = array(
				"estado" => 1,
				"mensaje" => "OK",
				"data" => $this->request->data
			);
		}

		$this->set("respuesta", $respuesta);
	}

	public function index()
	{
		AppController::controlAcceso();
		$this->layout = "angular";
	}

	public function listado_clientes()
	{
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("Cliente");
		$this->loadModel("Contrato");
		$this->loadModel("TipoContrato");

		$tipoContratos = $this->TipoContrato->find("list",  array("fields" => array("nombre"), "recursive" => 0));
		$clientes = $this->Cliente->find("all", array(
			"conditions" => array("Cliente.estado" => 1),
			"recursive" => 1
		));

		foreach ($clientes as $key => $cliente) {
			$listadoClientes[] = array_merge($cliente["Cliente"], array("nombre_empresa" => $cliente["Empresa"]["nombre"]));
			if (!empty($cliente["Contrato"])) {
				foreach ($cliente["Contrato"] as $contrato) {
					if ($contrato["estado"] == 1) {
						$listadoClientes[$key]["tipo_contrato"] = $tipoContratos[$contrato["tipo_contrato_id"]];
					}
				}
			}
		}

		$this->set("listadoClientes", $listadoClientes);
	}

	public function reporte()
	{
		AppController::controlAcceso();
		$this->layout = "angular_full";
	}

	public function formulario($id = null)
	{
		$this->layout = "ajax";
		$this->response->type('json');
		$this->Cliente->Behaviors->attach('Containable');
		$this->Cliente->contain(array(
			"Empresa.id", "Empresa.nombre",
			"Comuna.id", "Comuna.nombre",
			"Regione.id", "Regione.nombre"
		)); // contratos
		return $this->Cliente->find("first", array("conditions" => array("Cliente.id" => $id)));
	}

	public function reporte_json($rut = null)
	{
		$this->layout = "ajax";
		$this->response->type('json');
		$recaudacionService = new RecaudacionesController();

		//cliente y contratos
		$this->loadModel("ContratosProducto");
		$this->loadModel("TipoContrato");
		$this->loadModel("User");
		$clienteModel = ClassRegistry::init('Cliente');
		$clienteModel->unbindModel(array('hasMany' => array('Recaudacione')));
		$clienteContratos = $this->Cliente->find("first", array(
			"conditions" => array("Cliente.rut" => $rut),
			//'order' => array('Cliente.id' => 'DESC')
		));

		$users = $this->User->find('list', array(
			"fields" => ["usuario", "nombre"],
			"recursive" => -1
		));

		if (empty($clienteContratos)) {
			$this->set('cliente', array("error" => "Rut no encontrado."));
		} else {
			$clienteContratos["Cliente"] = array_merge(
				$clienteContratos["Cliente"],
				array(
					"ds_telefono" => implode(', ', 	array_filter(array($clienteContratos["Cliente"]["telefono"], $clienteContratos["Cliente"]["telefono2"], $clienteContratos["Cliente"]["telefono3"]), 'strlen')),
					"ds_email" => implode(', ', 	array_filter(array($clienteContratos["Cliente"]["email"], $clienteContratos["Cliente"]["email2"], $clienteContratos["Cliente"]["email3"]), 'strlen')),
					"ds_direccion" => $this->capitalizeFirst($clienteContratos["Cliente"]["direccion"] . ', ' . $clienteContratos["Comuna"]["nombre"] . ', ' . $clienteContratos["Regione"]["nombre"]),
					"ds_estado" => $clienteContratos["Cliente"]["direccion"] ? 'Activo' : 'Inactivo'
				)
			);

			$clienteContratos["Empresa"] = array_merge(
				$clienteContratos["Empresa"],
				array("ds_contacto" => implode(', ', 	array_filter(array($clienteContratos["Empresa"]["nombre_contacto"], $clienteContratos["Empresa"]["telefono_contacto"]), 'strlen')))
			);

			$tipoContratos = $this->TipoContrato->find('all', array(
				"fields" => array("TipoContrato.id", "TipoContrato.nombre"),
				"recursive" => 0
			));

			if (!empty($tipoContratos)) {
				foreach ($tipoContratos as $tipo) $tipoContrato[$tipo["TipoContrato"]["id"]] = $tipo["TipoContrato"]["nombre"];
			}

			// Productos x contrato
			$contratosId = array();
			$contratosEstados = array();
			if (!empty($clienteContratos["Contrato"])) {
				foreach ($clienteContratos["Contrato"] as $key => $contrato) {
					$contratosEstados[$contrato["id"]] = $contrato["estado"] == 1 ? 'Vigente' : 'Cerrado';
					$clienteContratos["Contrato"][$key] = array_merge(
						$clienteContratos["Contrato"][$key],
						array("ds_usuario_crea" => isset($users[$contrato["created_user"]]) ? $users[$contrato["created_user"]] : ""),
						array("ds_usuario_mod" => isset($users[$contrato["modified_user"]]) ? $users[$contrato["modified_user"]] : ""),
						array("tipo_contrato" => $tipoContrato[$contrato["tipo_contrato_id"]]),
						array("ds_estado" => $contrato["estado"] == 1 ? 'Vigente' : 'Cerrado')
					);
					$contratosId[] = $contrato["id"];
				}
			}

			$contratosProductos = $this->ContratosProducto->find(
				"all",
				array(
					"conditions" => array("ContratosProducto.contrato_id" => $contratosId),
					"recursive" => 0
				)
			);

			$productos = array();
			if (!empty($contratosProductos))
				foreach ($contratosProductos as $producto) {
					$productos[] = array_merge(
						$producto["ContratosProducto"],
						array("nombre" => $producto["Producto"]["nombre"]),
						array("ds_estado" => $contratosEstados[$producto["ContratosProducto"]["contrato_id"]])
					);
				}
			//recauda
			$recaudacion = $recaudacionService->recauda_cliente_json($clienteContratos["Cliente"]["id"]);
			//pagos
			$pagos = $recaudacionService->pagos_cliente_json($clienteContratos["Cliente"]["id"]);

			/* parche temporal por descuadre de cron */
			$cobrosPagosFix = [];
			if (!empty($pagos))
				foreach ($pagos as $pago) {
					$cobrosPagosFix[$pago["fecha_cobro"] . '-' . $pago["contrato_id"] . '' . $pago["total_cobrado"]] = $pago;
				}

			if (!empty($recaudacion["Recaudacione"]))
				foreach ($recaudacion["Recaudacione"] as $cobro) {
					if (!isset($cobrosPagosFix[$cobro["fecha_cobro"] . '-' . $cobro["contrato_id"] . '' . $cobro["total_cobrado"]]))
						$cobrosPagosFix[$cobro["fecha_cobro"] . '-' . $cobro["contrato_id"] . '' . $cobro["total_cobrado"]] = $cobro;
				}
			//pr(count($recaudacion["Recaudacione"]));
			//pr(count($pagos));
			//pr(array_values($cobrosPagosFix));exit;
			/* termina parche*/

			//union cobros-pagos
			/* comentado por parche cron $cobrosPagos = $recaudacion["Recaudacione"];
			$cobrosPagos = array_merge($cobrosPagos, $pagos); */
			//arma data cliente
			$clienteContratos = array_merge(
				$clienteContratos,
				array("Producto" => $productos),
				array("Pago" => $pagos),
				$recaudacion,
				array("PagosCobro" => array_values($cobrosPagosFix))
			);

			$this->set('cliente', $clienteContratos);
		}
	}

	public function capitalizeFirst($string)
	{
		$nombreCargo = "";
		$cargo = explode(" ", trim($string));
		foreach ($cargo as $palabra) {
			$nombreCargo .= (strlen($palabra) > 2) ? ucwords(mb_strtolower($palabra, 'UTF-8')) . ' ' : $palabra . ' ';
		}
		return $nombreCargo;
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
		$this->layout = "ajax";
		$this->loadModel("Contrato");
		$clienteContratos = $this->Contrato->find("first", array(
			"conditions" => array("Contrato.cliente_id" => $id),
		));

		if (!empty($clienteContratos)) {
			$this->Session->setFlash('Cliente no puede ser eliminado, ya que mantiene Contratos asociados.', 'msg_fallo');
		} else {
			$this->Cliente->id = $id;
			if ($this->Cliente->delete()) {
				$this->Session->setFlash('Cliente eliminado correctamente.', 'msg_exito');
			} else {
				$this->Session->setFlash('Cliente no puede ser eliminado, intente nuevamente.', 'msg_fallo');
			}
		}
		return $this->redirect(array('action' => 'index'));
	}
}
