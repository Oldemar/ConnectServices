<?php
App::uses('AppController', 'Controller');
/**
 * Applicants Controller
 *
 * @property Applicant $Applicant
 * @property PaginatorComponent $Paginator
 */
class ApplicantsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
*
*	beforefilter
*
**/	
	public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add');
    }

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Applicant->recursive = 0;
		$this->set('applicants', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Applicant->exists($id)) {
			throw new NotFoundException(__('Invalid applicant'));
		}
		$options = array('conditions' => array('Applicant.' . $this->Applicant->primaryKey => $id));
		$this->set('applicant', $this->Applicant->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Applicant->create();
			if ($this->Applicant->save($this->request->data)) {
				$this->Session->setFlash(__('The applicant has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The applicant could not be saved. Please, try again.'));
			}
		}
		$users = $this->Applicant->User->find('list',array('conditions'=>array('User.role_id'=>array('2','3'))));
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Applicant->exists($id)) {
			throw new NotFoundException(__('Invalid applicant'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Applicant->save($this->request->data)) {
				$this->Session->setFlash(__('The applicant has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The applicant could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Applicant.' . $this->Applicant->primaryKey => $id));
			$this->request->data = $this->Applicant->find('first', $options);
		}
		$users = $this->Applicant->User->find('list',array('conditions'=>array('User.role_id'=>array('2','3'))));
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Applicant->id = $id;
		if (!$this->Applicant->exists()) {
			throw new NotFoundException(__('Invalid applicant'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Applicant->delete()) {
			$this->Session->setFlash(__('The applicant has been deleted.'));
		} else {
			$this->Session->setFlash(__('The applicant could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
