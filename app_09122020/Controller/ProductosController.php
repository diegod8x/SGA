<?php
App::uses('AppController', 'Controller');
/**
 * Productos Controller
 *
 * @property Producto $Producto
 * @property PaginatorComponent $Paginator
 */
class ProductosController extends AppController {

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
		$this->loadModel('Contrato');
		$this->loadModel('Producto');
		$this->loadModel('ContratosProducto');
		if (!$this->Producto->exists($id)) {
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Producto no válido.",
				"id"=>null
				);
		}
		$contratosVigentes = $this->Contrato->find("list", array(
			"conditions"=>array("Contrato.tipo_contrato_id"=>1,
				"Contrato.estado"=>1),
			"recursive"=>0));
		$cantProductoMovimiento = $this->ContratosProducto->find("count", array(
			"conditions"=>array("ContratosProducto.producto_id"=>$id,
				"ContratosProducto.contrato_id"=>$contratosVigentes,
				"ContratosProducto.estado"=>1),
			"recursive"=>0));		
		$options = array('conditions' => array('Producto.' . $this->Producto->primaryKey => $id));
		$productos = $this->Producto->find('first', $options);
		$productos["Producto"]["disponibles"] = intval($productos["Producto"]["existencias"])-intval($cantProductoMovimiento);
		$this->set('producto', $productos);
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
			$this->Producto->create();
			if ($this->Producto->save($this->request->data)) {
				$respuesta = array(
					"estado"=>1,
					"mensaje"=>"Registrado correctamente",
					"id"=>$this->Producto->id
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

		if (!$this->Producto->exists($id)) {
			$respuesta = array(
				"estado"=>0,
				"mensaje"=>"Producto no válido.",
				"id"=>null
				);
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Producto->save($this->request->data)) {
				$respuesta = array(
					"estado"=>1,
					"mensaje"=>"Registrado correctamente.",
					"id"=>$this->Producto->id
					);
				
			} else {
				$respuesta = array(
					"estado"=>0,
					"mensaje"=>"Producto no pudo ser guardado.",
					"id"=>null
				);
			}
		} else {
			$this->request->data = ProductosController::formulario($id);

		}
		$respuesta = $this->request->data;
		$this->set("respuesta", $respuesta);
	}


	public function index() {
		AppController::controlAcceso();
		$this->layout = "angular";
	}

	public function listado_productos(){
		$this->layout = "ajax";
		$this->response->type('json');

		$this->loadModel("Producto");
		$this->loadModel("Contrato");
		$this->loadModel("ContratosProducto");

		$contratosVigentes = $this->Contrato->find("list", array(
			"conditions"=>array("Contrato.tipo_contrato_id"=>1,
				"Contrato.estado"=>1),
			"recursive"=>0));
			
		/*$cantProductoMovimiento = $this->ContratosProducto->find("list", array(
			"fields"=>array("ContratosProducto.producto_id AS producto_id","ContratosProducto.count AS ''"),
			"conditions"=>array(
				"ContratosProducto.contrato_id"=>$contratosVigentes,
				"ContratosProducto.estado"=>1),			
			"group"=>"ContratosProducto.producto_id",
			"recursive"=>0
		));*/
		//pr($contratosVigentes);

		$valores = array(); 
		foreach($contratosVigentes as $key => $item) {
			$valores[] = $key; 
		}

		$query = "SELECT `ContratosProducto`.`producto_id`, (COUNT(`ContratosProducto`.`id`)) AS `ContratosProducto__count`
		FROM `sga`.`contratos_productos` AS `ContratosProducto` 
		LEFT JOIN `sga`.`contratos` AS `Contrato` ON (`ContratosProducto`.`contrato_id` = `Contrato`.`id`) 
		LEFT JOIN `sga`.`productos` AS `Producto` ON (`ContratosProducto`.`producto_id` = `Producto`.`id`) 
		WHERE  `ContratosProducto`.`contrato_id` IN ( " . implode(',',$valores) . " )
		AND `ContratosProducto`.`estado` = 1
		group by `ContratosProducto`.`producto_id`;";
			
		$cantProductoMovimiento = $this->ContratosProducto->query( $query  );

		$productos = $this->Producto->find("all", array(
			"conditions"=> array("Producto.estado"=>1),
			"recursive"=>0
			));
		
		foreach ($productos as $producto) {
			$enMovimiento = (array_key_exists($producto["Producto"]["id"],$cantProductoMovimiento))? $cantProductoMovimiento[$producto["Producto"]["id"]]: 0;
			$producto["Producto"]["disponibles"] = intval($producto["Producto"]["existencias"])-intval($enMovimiento);
			$listadoProductos[] = array_merge($producto["Producto"]);
		}
		
		$this->set("listadoProductos",$listadoProductos);

	}


	public function formulario($id = null) {
		$this->layout = "ajax";
		$this->response->type('json');
		$this->loadModel("Producto");
		$this->loadModel("Contrato");
		$this->loadModel("ContratosProducto");
		
		$formulario = $this->Producto->find("first", array(
			"conditions"=>array("Producto.id"=>$id),
			"recursive"=>0));

		$contratosVigentes = $this->Contrato->find("list", array(
			"conditions"=>array("Contrato.tipo_contrato_id"=>1,
				"Contrato.estado"=>1),
			"recursive"=>0));
		$cantProductoMovimiento = $this->ContratosProducto->find("count", array(
			"conditions"=>array("ContratosProducto.producto_id"=>$id,
				"ContratosProducto.contrato_id"=>$contratosVigentes,
				"ContratosProducto.estado"=>1),
			"recursive"=>0));

		$formulario["Producto"]["precio_arriendo"] = intval($formulario["Producto"]["precio_arriendo"]);
		$formulario["Producto"]["precio_venta"] = intval($formulario["Producto"]["precio_venta"]);
		$formulario["Producto"]["existencias"] = intval($formulario["Producto"]["existencias"]);
		$formulario["Producto"]["disponibles"] = intval($formulario["Producto"]["existencias"])-intval($cantProductoMovimiento);

		$this->set("formulario",$formulario);
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
		$this->Producto->id = $id;
		if (!$this->Producto->exists()) {
			throw new NotFoundException(__('Producto Inválido'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Producto->delete()) {
			$this->Flash->success(__('El producto ha sido eliminado.'));
		} else {
			$this->Flash->error(__('El producto no pudo ser eliminado. Intente mas tarde.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
