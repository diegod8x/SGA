<?php
App::uses('AppController', 'Controller');
/**
 * Regiones Controller
 *
 * @property Regione $Regione
 * @property PaginatorComponent $Paginator
 */
class RegionesController extends AppController {

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
		$this->Regione->recursive = 0;
		$this->set('regiones', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Regione->exists($id)) {
			throw new NotFoundException(__('Invalid regione'));
		}
		$options = array('conditions' => array('Regione.' . $this->Regione->primaryKey => $id));
		$this->set('regione', $this->Regione->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Regione->create();
			if ($this->Regione->save($this->request->data)) {
				$this->Flash->success(__('The regione has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The regione could not be saved. Please, try again.'));
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
		if (!$this->Regione->exists($id)) {
			throw new NotFoundException(__('Invalid regione'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Regione->save($this->request->data)) {
				$this->Flash->success(__('The regione has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The regione could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Regione.' . $this->Regione->primaryKey => $id));
			$this->request->data = $this->Regione->find('first', $options);
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
		$this->Regione->id = $id;
		if (!$this->Regione->exists()) {
			throw new NotFoundException(__('Invalid regione'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Regione->delete()) {
			$this->Flash->success(__('The regione has been deleted.'));
		} else {
			$this->Flash->error(__('The regione could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
