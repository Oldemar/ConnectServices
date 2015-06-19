<?php
App::uses('AppController', 'Controller');
/**
 * Carriers Controller
 *
 * @property Carrier $Carrier
 * @property PaginatorComponent $Paginator
 */
class CarriersController extends AppController {

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
		$this->Carrier->recursive = 0;
		$this->set('carriers', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Carrier->exists($id)) {
			throw new NotFoundException(__('Invalid carrier'));
		}
		$options = array('conditions' => array('Carrier.' . $this->Carrier->primaryKey => $id));
		$this->set('carrier', $this->Carrier->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Carrier->create();
			if ($this->Carrier->save($this->request->data)) {
				$this->Session->setFlash(__('The carrier has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The carrier could not be saved. Please, try again.'));
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
		if (!$this->Carrier->exists($id)) {
			throw new NotFoundException(__('Invalid carrier'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Carrier->save($this->request->data)) {
				$this->Session->setFlash(__('The carrier has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The carrier could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Carrier.' . $this->Carrier->primaryKey => $id));
			$this->request->data = $this->Carrier->find('first', $options);
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
		$this->Carrier->id = $id;
		if (!$this->Carrier->exists()) {
			throw new NotFoundException(__('Invalid carrier'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Carrier->delete()) {
			$this->Session->setFlash(__('The carrier has been deleted.'));
		} else {
			$this->Session->setFlash(__('The carrier could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
