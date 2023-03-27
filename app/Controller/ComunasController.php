<?php
App::uses('AppController', 'Controller');
/**
 * Comunas Controller
 *
 * @property Comuna $Comuna
 * @property PaginatorComponent $Paginator
 */
class ComunasController extends AppController {

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
		$this->Comuna->recursive = 0;
		$this->set('comunas', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Comuna->exists($id)) {
			throw new NotFoundException(__('Invalid comuna'));
		}
		$options = array('conditions' => array('Comuna.' . $this->Comuna->primaryKey => $id));
		$this->set('comuna', $this->Comuna->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Comuna->create();
			if ($this->Comuna->save($this->request->data)) {
				$this->Flash->success(__('The comuna has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The comuna could not be saved. Please, try again.'));
			}
		}
		$regiones = $this->Comuna->Regione->find('list');
		$this->set(compact('regiones'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Comuna->exists($id)) {
			throw new NotFoundException(__('Invalid comuna'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Comuna->save($this->request->data)) {
				$this->Flash->success(__('The comuna has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The comuna could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Comuna.' . $this->Comuna->primaryKey => $id));
			$this->request->data = $this->Comuna->find('first', $options);
		}
		$regiones = $this->Comuna->Regione->find('list');
		$this->set(compact('regiones'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Comuna->id = $id;
		if (!$this->Comuna->exists()) {
			throw new NotFoundException(__('Invalid comuna'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Comuna->delete()) {
			$this->Flash->success(__('The comuna has been deleted.'));
		} else {
			$this->Flash->error(__('The comuna could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
