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
		$sales = $this->Advance->Sale->find('list');
		$this->set(compact('users', 'sales'));
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
		$sales = $this->Advance->Sale->find('list');
		$this->set(compact('users', 'sales'));
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

	public function generate()
	{
		$this->loadModel('User');
		$this->loadModel('Sale');
		$this->autoRender = false;
		foreach ($this->data as $key => $userInfo) 
		{
			$this->Advance->save($userInfo['Advance']);
			$this->Advance->id = null;
			foreach ($userInfo['Sale'] as $key1 => $sale) 
			{
				$this->Sale->id = $sale['id'];
				$this->Sale->savefield('advanced',1);
			}
		}
		echo '<pre>'.print_r($this->data,true).'</pre>';
		exit;
	}

}
