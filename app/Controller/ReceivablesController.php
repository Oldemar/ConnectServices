<?php
App::uses('AppController', 'Controller');
/**
 * Receivables Controller
 *
 * @property Receivable $Receivable
 * @property PaginatorComponent $Paginator
 */
class ReceivablesController extends AppController {

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
		$this->Receivable->recursive = 0;
    	$this->Paginator->settings = array(
        	'conditions' => array(
         		'Receivable.user_id'=>$this->objLoggedUser->getID()
        		));
        $this->set('receivables', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Receivable->exists($id)) {
			throw new NotFoundException(__('Invalid receivable'));
		}
		$options = array('conditions' => array('Receivable.' . $this->Receivable->primaryKey => $id));
		$this->set('receivable', $this->Receivable->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Receivable->create();
			if ($this->Receivable->save($this->request->data)) {
				$this->Session->setFlash(__('The receivable has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The receivable could not be saved. Please, try again.'));
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
		if (!$this->Receivable->exists($id)) {
			throw new NotFoundException(__('Invalid receivable'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Receivable->save($this->request->data)) {
				$this->Session->setFlash(__('The receivable has been saved.'));
				return $this->redirect($this->referer());
			} else {
				$this->Session->setFlash(__('The receivable could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Receivable.' . $this->Receivable->primaryKey => $id));
			$this->request->data = $this->Receivable->find('first', $options);
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
		$this->Receivable->id = $id;
		if (!$this->Receivable->exists()) {
			throw new NotFoundException(__('Invalid receivable'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Receivable->delete()) {
			$this->Session->setFlash(__('The receivable has been deleted.'));
		} else {
			$this->Session->setFlash(__('The receivable could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
