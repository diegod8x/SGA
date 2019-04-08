<?php
App::uses('AppController', 'Controller');

class TrabajadoresController extends AppController {

	public function index() {
		AppController::controlAcceso();
		$this->layout = "angular";
	}
	public function listado_trabajadores(){
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("Trabajadore");
		$this->loadModel("EstadoTrabajadore");
		$estadoTrabajadores = $this->EstadoTrabajadore->find("list", array("fields"=>"EstadoTrabajadore.nombre","recursive"=>0));
		$datosTrabajadores = $this->Trabajadore->find("all", array(	"recursive"=>0 ));
		foreach ($datosTrabajadores as $value) {
			$trabajadores[] = array_merge($value["Trabajadore"], 
				array(
					"nombre_completo"=> strtok($value["Trabajadore"]["nombre"], " ").' '. $value["Trabajadore"]["apellido_paterno"],
					"estado" => $estadoTrabajadores[$value["Trabajadore"]["estado_trabajadore_id"]]
				));
		}			
		$this->set('datosTrabajadores', $trabajadores);
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
			$this->Trabajadore->create();
			if ($this->Trabajadore->save($this->request->data)) {
				$respuesta = array(
					"estado"=>1,
					"mensaje"=>"Registrado correctamente",
					"id"=>$this->Trabajadore->id
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

	public function edit($id = null) {
		AppController::controlAcceso();
		$this->layout = "angular";
	}

	public function edit_json($id = null) {

		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("EstadoTrabajadore");
		$respuesta = array();
		if (!$this->Trabajadore->exists($id)) {
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Trabajadore no válido.",
				"id"=>null
				);
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Trabajadore->save($this->request->data)) {
				$respuesta = array(
					"estado"=>1,
					"mensaje"=>"Registrado correctamente.",
					"id"=>$this->Trabajadore->id
					);
				
			} else {
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"Trabajador no pudo ser guardado.",
					"id"=>null
				);
			}
		} else {
			$options = array('conditions' => array('Trabajadore.' . $this->Trabajadore->primaryKey => $id),"recursive" => 0	);
			$this->request->data = $this->Trabajadore->find('first', $options);

			$estadoTrabajadores = $this->EstadoTrabajadore->find("all", array("recursive"=>0));
			foreach ($estadoTrabajadores as $value) $estados[] = $value["EstadoTrabajadore"];

			$this->request->data["dataEstados"] = $estados;			
			$this->request->data;
		}
		$respuesta = $this->request->data;
		$this->set("respuesta", $respuesta);
	}


	public function view($id = null) {
		AppController::controlAcceso();
		if (!$this->Trabajadore->exists($id)) {
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Trabajadore no válido.",
				"id"=>null
				);
		}
		$options = array('conditions' => array('Trabajadore.' . $this->Trabajadore->primaryKey => $id));
		//pr($this->Trabajadore->find('first', $options));exit;
		$this->set('trabajadore', $this->Trabajadore->find('first', $options));
	}
}