<?php
App::uses('AppController', 'Controller');
/**
 * TipoActividades Controller
 *
 * @property TipoActividade $TipoActividade
 * @property PaginatorComponent $Paginator
 */
class TipoActividadesController extends AppController {

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
		$this->TipoActividade->recursive = 0;
		$this->set('tipoActividades', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->TipoActividade->exists($id)) {
			throw new NotFoundException(__('Invalid tipo actividade'));
		}
		$options = array('conditions' => array('TipoActividade.' . $this->TipoActividade->primaryKey => $id));
		$this->set('tipoActividade', $this->TipoActividade->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->TipoActividade->create();
			if ($this->TipoActividade->save($this->request->data)) {
				$this->Flash->success(__('The tipo actividade has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The tipo actividade could not be saved. Please, try again.'));
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
		if (!$this->TipoActividade->exists($id)) {
			throw new NotFoundException(__('Invalid tipo actividade'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->TipoActividade->save($this->request->data)) {
				$this->Flash->success(__('The tipo actividade has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The tipo actividade could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('TipoActividade.' . $this->TipoActividade->primaryKey => $id));
			$this->request->data = $this->TipoActividade->find('first', $options);
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
		$this->TipoActividade->id = $id;
		if (!$this->TipoActividade->exists()) {
			throw new NotFoundException(__('Invalid tipo actividade'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->TipoActividade->delete()) {
			$this->Flash->success(__('The tipo actividade has been deleted.'));
		} else {
			$this->Flash->error(__('The tipo actividade could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
