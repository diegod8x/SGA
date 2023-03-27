<?php
App::uses('AppController', 'Controller');
/**
 * HistoricoPagos Controller
 *
 * @property HistoricoPago $HistoricoPago
 * @property PaginatorComponent $Paginator
 */
class HistoricoPagosController extends AppController {

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
		AppController::controlAcceso();
		$this->HistoricoPago->recursive = 0;
		$this->set('historicoPagos', $this->Paginator->paginate());
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
		if (!$this->HistoricoPago->exists($id)) {
			throw new NotFoundException(__('Invalid historico pago'));
		}
		$options = array('conditions' => array('HistoricoPago.' . $this->HistoricoPago->primaryKey => $id));
		$this->set('historicoPago', $this->HistoricoPago->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		AppController::controlAcceso();
		if ($this->request->is('post')) {
			$this->HistoricoPago->create();
			if ($this->HistoricoPago->save($this->request->data)) {
				$this->Flash->success(__('The historico pago has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The historico pago could not be saved. Please, try again.'));
			}
		}
		$tipoDocumentos = $this->HistoricoPago->TipoDocumento->find('list');
		$this->set(compact('tipoDocumentos'));
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
		if (!$this->HistoricoPago->exists($id)) {
			throw new NotFoundException(__('Invalid historico pago'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->HistoricoPago->save($this->request->data)) {
				$this->Flash->success(__('The historico pago has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The historico pago could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('HistoricoPago.' . $this->HistoricoPago->primaryKey => $id));
			$this->request->data = $this->HistoricoPago->find('first', $options);
		}
		$tipoDocumentos = $this->HistoricoPago->TipoDocumento->find('list');
		$this->set(compact('tipoDocumentos'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->HistoricoPago->id = $id;
		if (!$this->HistoricoPago->exists()) {
			throw new NotFoundException(__('Invalid historico pago'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->HistoricoPago->delete()) {
			$this->Flash->success(__('The historico pago has been deleted.'));
		} else {
			$this->Flash->error(__('The historico pago could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
