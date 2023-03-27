<?php
App::uses('AppController', 'Controller');
/**
 * TipoContratos Controller
 *
 * @property TipoContrato $TipoContrato
 * @property PaginatorComponent $Paginator
 */
class TipoContratosController extends AppController {

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
		$this->TipoContrato->recursive = 0;
		$this->set('tipoContratos', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->TipoContrato->exists($id)) {
			throw new NotFoundException(__('Invalid tipo contrato'));
		}
		$options = array('conditions' => array('TipoContrato.' . $this->TipoContrato->primaryKey => $id));
		$this->set('tipoContrato', $this->TipoContrato->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TipoContrato->create();
			if ($this->TipoContrato->save($this->request->data)) {
				$this->Flash->success(__('The tipo contrato has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The tipo contrato could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->TipoContrato->exists($id)) {
			throw new NotFoundException(__('Invalid tipo contrato'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->TipoContrato->save($this->request->data)) {
				$this->Flash->success(__('The tipo contrato has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The tipo contrato could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('TipoContrato.' . $this->TipoContrato->primaryKey => $id));
			$this->request->data = $this->TipoContrato->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->TipoContrato->id = $id;
		if (!$this->TipoContrato->exists()) {
			throw new NotFoundException(__('Invalid tipo contrato'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->TipoContrato->delete()) {
			$this->Flash->success(__('The tipo contrato has been deleted.'));
		} else {
			$this->Flash->error(__('The tipo contrato could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
