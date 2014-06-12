<?php
App::uses('AppController', 'Controller');
/**
 * Savings Controller
 *
 * @property Saving $Saving
 * @property PaginatorComponent $Paginator
 */
class SavingsController extends AppController {

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
		$this->Saving->recursive = 0;
		$this->set('savings', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Saving->exists($id)) {
			throw new NotFoundException(__('Invalid saving'));
		}
		$options = array('conditions' => array('Saving.' . $this->Saving->primaryKey => $id));
		$this->set('saving', $this->Saving->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Saving->create();
			if ($this->Saving->save($this->request->data)) {
				$this->Session->setFlash(__('The saving has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The saving could not be saved. Please, try again.'));
			}
		}
		$users = $this->Saving->User->find('list');
		$payrolls = $this->Saving->Payroll->find('list');
		$this->set(compact('users', 'payrolls'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Saving->exists($id)) {
			throw new NotFoundException(__('Invalid saving'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Saving->save($this->request->data)) {
				$this->Session->setFlash(__('The saving has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The saving could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Saving.' . $this->Saving->primaryKey => $id));
			$this->request->data = $this->Saving->find('first', $options);
		}
		$users = $this->Saving->User->find('list');
		$payrolls = $this->Saving->Payroll->find('list');
		$this->set(compact('users', 'payrolls'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Saving->id = $id;
		if (!$this->Saving->exists()) {
			throw new NotFoundException(__('Invalid saving'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Saving->delete()) {
			$this->Session->setFlash(__('The saving has been deleted.'));
		} else {
			$this->Session->setFlash(__('The saving could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
