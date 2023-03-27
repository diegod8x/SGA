<?php
App::uses('AppController', 'Controller');
App::uses('ServiciosController', 'Controller');
/**
 * Clientes Controller
 *
 * @property Cliente $Cliente
 * @property PaginatorComponent $Paginator
 */
class ClientesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 *//*
	public function index() {
		$this->Cliente->recursive = 0;
		$this->set('clientes', $this->Paginator->paginate());
	}*/

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		AppController::controlAcceso();
		if (!$this->Cliente->exists($id)) {
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Cliente no válido.",
				"id"=>null
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
	public function add() {
		AppController::controlAcceso();
		$this->layout = "angular";
	}

	public function add_json(){
		
		$this->layout = "ajax";
		$this->response->type('json');

		if ($this->request->is('post')) {
			$this->Cliente->create();
			if ($this->Cliente->save($this->request->data)) {
				$respuesta = array(
					"estado"=>1,
					"mensaje"=>"Registrado correctamente",
					"id"=>$this->Cliente->id
					);				
			} else {
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"No se pudo ingresar, por favor intente nuevamente",
					"id"=>null
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

	public function edit($id = null) {
		AppController::controlAcceso();
		$this->layout = "angular";
	}

	public function edit_json($id = null) {

		$this->layout = "ajax";
		$this->response->type('json');

		$respuesta = array();

		if (!$this->Cliente->exists($id)) {
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Cliente no válido.",
				"id"=>null
				);
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Cliente->save($this->request->data)) {
				$respuesta = array(
					"estado"=>1,
					"mensaje"=>"Registrado correctamente.",
					"id"=>$this->Cliente->id
					);
				
			} else {
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"Cliente no pudo ser guardado.",
					"id"=>null
				);
			}
		} else {
			$options = array('conditions' => array('Cliente.' . $this->Cliente->primaryKey => $id));
			$this->request->data = $this->Cliente->find('first', $options);
		}
		$respuesta = $this->request->data;
		$this->set("respuesta", $respuesta);
	}

	public function index() {
		AppController::controlAcceso();
		$this->layout = "angular";
	}

	public function listado_clientes(){
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("Cliente");
		$this->loadModel("Contrato");
		$this->loadModel("TipoContrato");

		$tipoContratos = $this->TipoContrato->find("list",  array("fields"=>array("nombre"),"recursive"=>0));
		$clientes = $this->Cliente->find("all", array(
			"conditions"=> array("Cliente.estado"=>1),
			"recursive"=>1
			));
		
		foreach ($clientes as $key => $cliente) {

			$listadoClientes[] = array_merge($cliente["Cliente"], array("nombre_empresa" => $cliente["Empresa"]["nombre"]));

			if(!empty($cliente["Contrato"])){
				foreach ($cliente["Contrato"] as $contrato) {
					if($contrato["estado"]==1)
						$listadoClientes[$key]["tipo_contrato"] = $tipoContratos[$contrato["tipo_contrato_id"]];//array_merge($cliente["Cliente"], array("nombre_empresa" => $cliente["Empresa"]["nombre"], "tipo_contrato"=>$tipoContratos[$contrato["tipo_contrato_id"]]));
					/*else
						$listadoClientes[] = array_merge($cliente["Cliente"], array("nombre_empresa" => $cliente["Empresa"]["nombre"], "tipo_contrato"=>''));*/
						//$tipoContrato = $tipoContratos[$contrato["tipo_contrato_id"]];
				}
			}
			
		}
		
		$this->set("listadoClientes",$listadoClientes);

	}

	public function formulario($id = null) {
		$this->layout = "ajax";
		$this->response->type('json');
		$this->Cliente->Behaviors->attach('Containable');
		$this->Cliente->contain(array("Empresa.id","Empresa.nombre",
			"Comuna.id","Comuna.nombre",
			"Regione.id","Regione.nombre"
			)); // contratos
		$formulario = $this->Cliente->find("first", array("conditions"=>array("Cliente.id"=>$id)));

		return $formulario;		
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Cliente->id = $id;
		if (!$this->Cliente->exists()) {
			throw new NotFoundException(__('Invalid cliente'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Cliente->delete()) {
			$this->Flash->success(__('The cliente has been deleted.'));
		} else {
			$this->Flash->error(__('The cliente could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
