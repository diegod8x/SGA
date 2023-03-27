<?php
App::uses('AppController', 'Controller');
App::uses('ServiciosController', 'Controller');
/**
 * Empresas Controller
 *
 * @property Empresa $Empresa
 * @property PaginatorComponent $Paginator
 */
class EmpresasController extends AppController {

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
	public function view($id = null) {
		AppController::controlAcceso();
		if (!$this->Empresa->exists($id)) {
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Empresa no válida.",
				"id"=>null
				);
		}
		$options = array('conditions' => array('Empresa.' . $this->Empresa->primaryKey => $id));
		$this->set('empresa', $this->Empresa->find('first', $options));
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
			$this->Empresa->create();
			if ($this->Empresa->save($this->request->data)) {
				$respuesta = array(
					"estado"=>1,
					"mensaje"=>"Registrado correctamente",
					"id"=>$this->Empresa->id
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

		if (!$this->Empresa->exists($id)) {
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Empresa no válida.",
				"id"=>null
				);
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Empresa->save($this->request->data)) {
				$respuesta = array(
					"estado"=>1,
					"mensaje"=>"Registrado correctamente.",
					"id"=>$this->Empresa->id
					);
				
			} else {
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"Empresa no pudo ser guardada.",
					"id"=>null
				);
			}
		} else {
			$options = array('conditions' => array('Empresa.' . $this->Empresa->primaryKey => $id));
			$this->request->data = $this->Empresa->find('first', $options);
		}
		$respuesta = $this->request->data;
		$this->set("respuesta", $respuesta);
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Empresa->id = $id;
		if (!$this->Empresa->exists()) {
			throw new NotFoundException(__('Invalid empresa'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Empresa->delete()) {
			$this->Flash->success(__('The empresa has been deleted.'));
		} else {
			$this->Flash->error(__('The empresa could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}


	public function index() {
		AppController::controlAcceso();
		$this->layout = "angular";
	}

	public function listado_empresas() {
		$this->layout = "ajax";
		$this->response->type('json');
		$empresas = $this->Empresa->find("all",array(
			"conditions"=>array("Empresa.estado"=>1), 
			"order" => "Empresa.nombre ASC", 
			"recursive"=>0
			));

		foreach ($empresas as $value){
			$value["Empresa"]["direccion"] = $value["Empresa"]["direccion"] . ', ' .ucwords(mb_strtolower($value["Comuna"]["nombre"], 'UTF-8' ) );
			$listadoEmpresas[] = $value["Empresa"];
		}

		$this->set("listadoEmpresas", $listadoEmpresas);
	}

}
