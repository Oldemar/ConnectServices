<?php
App::uses('AppController', 'Controller');
/**
 * Advances Controller
 *
 * @property Advance $Advance
 * @property PaginatorComponent $Paginator
 */
class AdvancesController extends AppController {

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
		$this->Advance->recursive = 0;
		$this->set('advances', $this->Paginator->paginate());
	}

/**
 * myadvances method
 *
 * @return void
 */
	public function myadvances($id) {
		$this->Advance->recursive = 0;
		$this->set('advances', $this->Paginator->paginate('Advance',array('Advance.user_id'=>$id)));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Advance->exists($id)) {
			throw new NotFoundException(__('Invalid advance'));
		}
		$options = array('conditions' => array('Advance.' . $this->Advance->primaryKey => $id));
		$this->set('advance', $this->Advance->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Advance->create();
			if ($this->Advance->save($this->request->data)) {
				$this->Session->setFlash(__('The advance has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The advance could not be saved. Please, try again.'));
			}
		}
		$users = $this->Advance->User->find('list',array(
			'conditions'=> array(
				'User.role_id !='=>array('1','2','8','9'))));
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
		if (!$this->Advance->exists($id)) {
			throw new NotFoundException(__('Invalid advance'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Advance->save($this->request->data)) {
				$this->Session->setFlash(__('The advance has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The advance could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Advance.' . $this->Advance->primaryKey => $id));
			$this->request->data = $this->Advance->find('first', $options);
		}
		$users = $this->Advance->User->find('list',array(
			'conditions'=> array(
				'User.role_id !='=>array('1','2','8','9'))));
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
		$this->Advance->id = $id;
		if (!$this->Advance->exists()) {
			throw new NotFoundException(__('Invalid advance'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Advance->delete()) {
			$this->Session->setFlash(__('The advance has been deleted.'));
		} else {
			$this->Session->setFlash(__('The advance could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function getbalance()
	{
		$this->autoRender = false;
		$lastAdvance = $this->Advance->find('first', array(
			'conditions'=>array(
				'Advance.user_id'=>$this->data['userID']),
			'order'=>'Advance.advdate DESC'
		));
		$arrReturn = (isset($lastAdvance['Advance']['balance']) ? $lastAdvance['Advance']['balance'] : 0 );

//		echo '<pre>'.print_r($lastAdvance,true).'</pre>';
		echo json_encode($arrReturn);
		exit;
	}

}
