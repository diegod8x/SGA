<?php
App::uses('AppController', 'Controller');
/**
 * Cobranzas Controller
 *
 * @property Cobranza $Cobranza
 * @property PaginatorComponent $Paginator
 */
class CobranzasController extends AppController {

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
 */
	public function index(){
		AppController::controlAcceso();
		$this->layout = "angular";
	}

	public function index_json() {
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("TipoContrato");
		$this->loadModel("TipoDocumento");
		$this->loadModel("Cobranza");
		$this->loadModel("Cliente");

		$tipoContratos = $this->TipoContrato->find("list",array("fields"=>array("TipoContrato.nombre")));
		$listadoClientes = $this->Cliente->find("list",array("fields"=>array("Cliente.nombre")));

		$listadoCobranza = $this->Cobranza->find("all",array("recursive"=>2));
		foreach ($listadoCobranza as $producto) {		
			$productos[]=array( 
				"contrato_id"		=> $producto["ContratosProducto"]["contrato_id"],
				"nombre_cliente"	=> $listadoClientes[$producto["ContratosProducto"]["Contrato"]["cliente_id"]],
				//"tipo_contrato_id"	=> $producto["ContratosProducto"]["Contrato"]["tipo_contrato_id"],
				//"tipo_contrato" 	=> $tipoContratos[$producto["ContratosProducto"]["Contrato"]["tipo_contrato_id"]],
				"nombre_producto" 	=> $producto["ContratosProducto"]["Producto"]["nombre"],
				"fecha_cobro" 		=> $producto["Cobranza"]["fecha_cobro"],
				"monto_cobrado" 	=> $producto["Cobranza"]["monto_cobrado"],
				);
		}
		$tipoDocumentos = $this->TipoDocumento->find("all",array("recursive"=>-1));
		foreach ($tipoDocumentos as $tipoDocumento) {
			$tipoDoc[] = $tipoDocumento["TipoDocumento"];
		}

		$respuesta = array(
			"tipoDocumento"=>$tipoDoc,
			"cobranzas"=>$productos);

		$this->set('respuesta', $respuesta);

	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		AppController::controlAcceso();
		if (!$this->Cobranza->exists($id)) {
			throw new NotFoundException(__('Invalid cobranza'));
		}
		$options = array('conditions' => array('Cobranza.' . $this->Cobranza->primaryKey => $id));
		$this->set('cobranza', $this->Cobranza->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		AppController::controlAcceso();
		if ($this->request->is('post')) {
			$this->Cobranza->create();
			if ($this->Cobranza->save($this->request->data)) {
				$this->Flash->success(__('The cobranza has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The cobranza could not be saved. Please, try again.'));
			}
		}
		$contratosProductos = $this->Cobranza->ContratosProducto->find('list');
		$tipoDocumentos = $this->Cobranza->TipoDocumento->find('list');
		$this->set(compact('contratosProductos', 'tipoDocumentos'));
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
		if (!$this->Cobranza->exists($id)) {
			throw new NotFoundException(__('Invalid cobranza'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Cobranza->save($this->request->data)) {
				$this->Flash->success(__('The cobranza has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The cobranza could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Cobranza.' . $this->Cobranza->primaryKey => $id));
			$this->request->data = $this->Cobranza->find('first', $options);
		}
		$contratosProductos = $this->Cobranza->ContratosProducto->find('list');
		$tipoDocumentos = $this->Cobranza->TipoDocumento->find('list');
		$this->set(compact('contratosProductos', 'tipoDocumentos'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Cobranza->id = $id;
		if (!$this->Cobranza->exists()) {
			throw new NotFoundException(__('Invalid cobranza'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Cobranza->delete()) {
			$this->Flash->success(__('The cobranza has been deleted.'));
		} else {
			$this->Flash->error(__('The cobranza could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}


/**
 * add method
 *
 * @return void
 */
	public function add_cobranza() {

		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("Contrato");
		$this->loadModel("ContratosProducto");
		$this->loadModel("TipoContrato");

		$timeZome = timezone_open('America/Santiago');
		$date = new DateTime();
		$date->setTimezone($timeZome);

		$tipoContratos = $this->TipoContrato->find("list",array("fields"=>array("TipoContrato.nombre")));
		$contratos = $this->Contrato->find('all',array(
			"fields"=>array("Contrato.id", "Contrato.tipo_contrato_id"),
			"conditions"=>array("Contrato.fecha_cobro"=>$date->format("d"),
				"OR"=>array(
					array("Contrato.tipo_contrato_id"=>1, "Contrato.estado" =>1),
					array("Contrato.tipo_contrato_id"=>2, "Contrato.estado IN" =>array(0,1))
					)),
			"recursive"=> -1
		));
		foreach ($contratos as $contrato) {
			$contratosId[] = $contrato["Contrato"]["id"];
			$datosContratos[$contrato["Contrato"]["id"]] = $tipoContratos[$contrato["Contrato"]["tipo_contrato_id"]];
		}
		$contratosProductos = $this->ContratosProducto->find('all',array(
			"fields"=> array("ContratosProducto.id","ContratosProducto.contrato_id", "ContratosProducto.precio_arriendo","ContratosProducto.precio_venta"),
			"conditions"=>array( 
				"ContratosProducto.estado" =>1,
				"ContratosProducto.contrato_id"=> $contratosId
				),
			"recursive"=>-1,
			"order"=>"ContratosProducto.contrato_id ASC, ContratosProducto.producto_id ASC"
			));		
		foreach ($contratosProductos as $productos) {
			$productosArray[] = array(
				"tipo_contrato_id"=> $datosContratos[$productos["ContratosProducto"]["contrato_id"]],
				"contratos_producto_id"=>intval($productos["ContratosProducto"]["id"]),
				"monto_cobrado" => ($productos["ContratosProducto"]["precio_arriendo"]>0)? intval($productos["ContratosProducto"]["precio_arriendo"]): intval($productos["ContratosProducto"]["precio_venta"]),
				"monto_pagado" => 0,
				"fecha_cobro" => $date->format("Y-m-d"),
				"mes_cobro" => $date->format("Ym"),
				"estado" => 0);
		}

		//pr($productosArray);exit;
		$respuesta =1;
		$this->Cobranza->saveAll($productosArray);
		$this->set('respuesta', $respuesta);
	}
}
