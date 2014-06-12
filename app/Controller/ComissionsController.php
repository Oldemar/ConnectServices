<?php
App::uses('AppController', 'Controller');
/**
 * Comissions Controller
 *
 * @property Comission $Comission
 * @property PaginatorComponent $Paginator
 */
class ComissionsController extends AppController {

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
		$this->Comission->recursive = 0;
		$this->set('comissions', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Comission->exists($id)) {
			throw new NotFoundException(__('Invalid comission'));
		}
		$options = array('conditions' => array('Comission.' . $this->Comission->primaryKey => $id));
		$this->set('comission', $this->Comission->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Comission->create();
			if ($this->Comission->save($this->request->data)) {
				$this->Session->setFlash(__('The comission has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The comission could not be saved. Please, try again.'));
			}
		}
		$this->loadModel('Role');
		$roles = $this->Role->find('list');
		$this->set(compact('roles'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Comission->exists($id)) {
			throw new NotFoundException(__('Invalid comission'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Comission->save($this->request->data)) {
				$this->Session->setFlash(__('The comission has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The comission could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Comission.' . $this->Comission->primaryKey => $id));
			$this->request->data = $this->Comission->find('first', $options);
		}
		$this->loadModel('User');
		$this->loadModel('Role');
		$users = $this->User->find('list');
		$roles = $this->Role->find('list');
		$this->set(compact('users', 'roles'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Comission->id = $id;
		if (!$this->Comission->exists()) {
			throw new NotFoundException(__('Invalid comission'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Comission->delete()) {
			$this->Session->setFlash(__('The comission has been deleted.'));
		} else {
			$this->Session->setFlash(__('The comission could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
