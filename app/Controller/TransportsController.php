<?php
App::uses('AppController', 'Controller');
/**
 * Transports Controller
 *
 * @property Transport $Transport
 */
class TransportsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Transport->recursive = 0;
		$this->set('transports', $this->paginate());
	}

/**
 * index method
 *
 * @return void
 */
	public function search() {
		$this->layout='layout';
		debug($this->request->data);
		//$this->Transport->recursive = 0;
		//$this->set('transports', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Transport->exists($id)) {
			throw new NotFoundException(__('Invalid transport'));
		}
		$options = array('conditions' => array('Transport.' . $this->Transport->primaryKey => $id));
		$this->set('transport', $this->Transport->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Transport->create();
			if ($this->Transport->save($this->request->data)) {
				$this->Session->setFlash(__('The transport has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transport could not be saved. Please, try again.'));
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
		if (!$this->Transport->exists($id)) {
			throw new NotFoundException(__('Invalid transport'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Transport->save($this->request->data)) {
				$this->Session->setFlash(__('The transport has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The transport could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Transport.' . $this->Transport->primaryKey => $id));
			$this->request->data = $this->Transport->find('first', $options);
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
		$this->Transport->id = $id;
		if (!$this->Transport->exists()) {
			throw new NotFoundException(__('Invalid transport'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Transport->delete()) {
			$this->Session->setFlash(__('Transport deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Transport was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
