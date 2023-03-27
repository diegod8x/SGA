<?php
App::uses('AppController', 'Controller');
/**
 * ContratosProductos Controller
 *
 * @property ContratosProducto $ContratosProducto
 * @property PaginatorComponent $Paginator
 */
class ContratosProductosController extends AppController {

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
	public function index() {
		$this->ContratosProducto->recursive = 0;
		$this->set('contratosProductos', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ContratosProducto->exists($id)) {
			throw new NotFoundException(__('Invalid contratos producto'));
		}
		$options = array('conditions' => array('ContratosProducto.' . $this->ContratosProducto->primaryKey => $id));
		$this->set('contratosProducto', $this->ContratosProducto->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ContratosProducto->create();
			if ($this->ContratosProducto->save($this->request->data)) {
				$this->Flash->success(__('The contratos producto has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The contratos producto could not be saved. Please, try again.'));
			}
		}
		$contratos = $this->ContratosProducto->Contrato->find('list');
		$productos = $this->ContratosProducto->Producto->find('list');
		$this->set(compact('contratos', 'productos'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->ContratosProducto->exists($id)) {
			throw new NotFoundException(__('Invalid contratos producto'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ContratosProducto->save($this->request->data)) {
				$this->Flash->success(__('The contratos producto has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The contratos producto could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ContratosProducto.' . $this->ContratosProducto->primaryKey => $id));
			$this->request->data = $this->ContratosProducto->find('first', $options);
		}
		$contratos = $this->ContratosProducto->Contrato->find('list');
		$productos = $this->ContratosProducto->Producto->find('list');
		$this->set(compact('contratos', 'productos'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->ContratosProducto->id = $id;
		if (!$this->ContratosProducto->exists()) {
			throw new NotFoundException(__('Invalid contratos producto'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->ContratosProducto->delete()) {
			$this->Flash->success(__('The contratos producto has been deleted.'));
		} else {
			$this->Flash->error(__('The contratos producto could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
