<?php
App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');
App::uses('CakeTime', 'Utility');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

	public $helpers = array('GoogleCharts.GoogleCharts');

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
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

/**
 * dashboard method
 *
 * @return void
 */
	public function dashboard() {

		$this->loadModel('Sale');
		$salesByUsersTest = array();
		$parentForChildrenIds = $this->objLoggedUser->getAttr('role_id') == '9' ? $this->objLoggedUser->getAttr('topleader') : $this->objLoggedUser->getID();
		$childrenIds = Hash::extract($this->User->children($parentForChildrenIds,true), '{n}.User.id');
		$childrenIds[] = $this->objLoggedUser->getID();
		foreach ($childrenIds as $key => $child) {
			$objChild = $this->User->findById($child);
			$salesByUsersTest[$key]['User'] = $objChild->data['User'];
			$salesByUsersTest[$key]['Totals'] = $objChild->getTotals($objChild->id);
			$salesByUsersTest[$key]['Sales'] = $objChild->Sale->getMonthlySales($objChild->getID());
			$salesByUsersTest[$key]['Children'] = $objChild->myChildren();
			$salesByUsersTest[$key]['Events'] = $objChild->Event->childEvents($salesByUsersTest[$key]['Children']);
		}

		$this->set('latestSales', $this->Sale->find('all', array(
			'conditions'=> array(
				'Sale.user_id'=>$childrenIds
				),
			'order'=>'sales_date DESC',
			'limit'=>3)));

		$this->set('nextEvents',$this->User->Event->find('all', array(
			'conditions'=>array(
				'AND'=>array(
					'Event.user_id'=>$childrenIds,
					'DATE(Event.start) >='=>date('Y-m-d')
				)
			),
			'order'=>'start',
			'limit'=>3)));

		$this->set('salesByUsersTest',$salesByUsersTest);

	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->saveAssociated($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		}
		$roles = $this->User->Role->find('list');
		$carriers = $this->User->Carrier->find('list');
		$this->set(compact('roles','carriers'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				if ($isAuthorized) {
					$this->redirect(array('action' => 'index'));
				} else {
					$this->redirect(array('action' => 'dashboard'));
				}
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$roles = $this->User->Role->find('list');
		$carriers = $this->User->Carrier->find('list');
		$parents = $this->User->ParentUser->find('list');
		$leaders = $this->User->find('list', array('conditions'=>array('User.role_id'=>array('2','4'))));
		$this->set(compact('roles','carriers','parents','leaders'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

	public function login() {
	    if ($this->request->is('post')) {
	        if ($this->Auth->login()) {
	        	$this->User->id = $this->Auth->user('id');
				$this->User->savefield('online',1);
				$this->User->savefield('lastlogin',date('Y-m-d H:i:s'));
	            $this->redirect(array('controller'=>'users','action'=>'dashboard'));
	        } else {
	            $this->Session->setFlash(__('Invalid username or password, try again'));
	        }
	    }
	}
	public function logout() {
	    $this->User->id = $this->Auth->user('id');
		$this->User->savefield('online',0);
		$this->Session->destroy();
	    $this->redirect('/');
	}

}
