<?php
App::uses('AppController', 'Controller');
/**
 * Posts Controller
 *
 * @property Post $Post
 * @property PaginatorComponent $Paginator
 */
class PostsController extends AppController {

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
		$this->Post->recursive = 0;
		$this->set('posts', $this->Paginator->paginate());
	}

/**
 * blog method
 *
 * @return void
 */

	public function blog($uid = null, $cid = null, $month = null) {
		$uid   = isset($this->request->query['uid'])   ? $this->request->query['uid']   : null;
		$cid   = isset($this->request->query['cid'])   ? $this->request->query['cid']   : null;
    	$month = isset($this->request->query['month']) ? $this->request->query['month'] : null;
		if ( isset( $cid ) && !is_null( $cid ) ) {
			$this->set('posts', $this->Post->find('all', array(
				'conditions'=>array(
					'Post.category_id'=>$cid),
				'order'=>array(
					'Post.created'=>'DESC'))));
		} elseif ( isset( $month ) && !is_null( $month ) ) {
			$this->set('posts', $this->Post->find('all', array(
				'conditions'=>array(
					'MONTH(Post.created)'=>$month),
				'order'=>array(
					'Post.created'=>'DESC'))));
		} elseif ( isset( $uid ) && !is_null( $uid ) ) {
			$this->set('posts', $this->Post->find('all', array(
				'conditions'=>array(
					'Post.user_id'=>$uid),
				'order'=>array(
					'Post.created'=>'DESC'))));
		} else {
			$this->set('posts', $this->Post->find('all'));
		}

		$this->set('postsbycategory', $this->Post->Category->find('all'));
		$this->set('postsbymonth', $this->Post->find('all', array(
				'fields'=>'DISTINCT MONTH(Post.created) AS month, COUNT(MONTH(Post.created)) AS total',
				'group'=>'MONTH(Post.created)',
				'order'=> array(
					'MONTH(Post.created)'=> 'DESC'
				))));		
		$this->set('recentposts', $this->Post->find('all', array(
				'order'=>array(
					'Post.created'=>'DESC'),
				'limit'=>3)));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Post->exists($id)) {
			throw new NotFoundException(__('Invalid post'));
		}
		$options = array('conditions' => array('Post.' . $this->Post->primaryKey => $id));
		$this->set('post', $this->Post->find('first', $options));
		$this->set('posts', $this->Post->find('all', array(
			'limit'=>3
			)));
		$this->set('postsbycategory', $this->Post->Category->find('all'));
		$this->set('postsbymonth', $this->Post->find('all', array(
				'fields'=>'DISTINCT MONTH(Post.created) AS month, COUNT(MONTH(Post.created)) AS total',
				'group'=>'MONTH(Post.created)',
				'order'=> array(
					'MONTH(Post.created)'=> 'DESC'
				))));		
		$this->set('recentposts', $this->Post->find('all', array(
				'order'=>array(
					'Post.created'=>'DESC'),
				'limit'=>3)));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Post->create();
			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash(__('The post has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The post could not be saved. Please, try again.'));
			}
		}
		$categories = $this->Post->Category->find('list');
		$users = $this->Post->User->find('list', array(
			'conditions'=>array(
				'NOT'=>array(
					'User.id'=>array(
						'1','8','13'
						)))));
		$this->set(compact('users','categories'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Post->exists($id)) {
			throw new NotFoundException(__('Invalid post'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Post->save($this->request->data)) {
				$this->Session->setFlash(__('The post has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The post could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Post.' . $this->Post->primaryKey => $id));
			$this->request->data = $this->Post->find('first', $options);
		}
		$categories = $this->Post->Category->find('list');
		$users = $this->Post->User->find('list', array(
			'conditions'=>array(
				'User.id !='=>array(
					'1','8','13'
					))));
		$this->set(compact('users','categories'));
		$this->set('post',$this->Post->find('first', $options));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Post->id = $id;
		if (!$this->Post->exists()) {
			throw new NotFoundException(__('Invalid post'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Post->delete()) {
			$this->Session->setFlash(__('The post has been deleted.'));
		} else {
			$this->Session->setFlash(__('The post could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
