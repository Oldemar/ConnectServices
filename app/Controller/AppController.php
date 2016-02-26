<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');
App::uses('CakeTime','Utility');
App::uses('GoogleCharts', 'GoogleCharts.Lib');
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $helpers = array(
		'Js', 
		'Html', 
		'Form2', 
		'Session'
	);

	public $components = array(
		'RequestHandler',
		'Session',
		'Auth' => array(
            'loginRedirect' => array('controller'=>'users','action'=>'dashboard'),
            'logoutRedirect' => '/',
 			'authenticate' => array(
		        'Form' => array(
		            'fields' => array('username' => 'username')
		        )
            )
 		)
 	);

	public $objLoggedUser = null;
	public $isMobile = null;
	public $myTopLeader;
	public $isAuthorized;

/**
*
*	beforefilter
*
**/	
    public function beforeFilter() {

		if($this->Auth->user('id')){
			$this->loadModel('User');
		
			$this->objLoggedUser = $this->User->findById($this->Auth->user('id'));
			$this->set('myChildren', $this->User->children($this->Auth->user('id')));
			$myTopLeader = $this->getTopleader = in_array($this->objLoggedUser->getAttr('role_id'),array('2','4')) ? $this->objLoggedUser->getID() : null;
			$myLeader = null;
			if ($this->objLoggedUser->getAttr('role_id') != 1) {
				$arrMyLeader = $this->User->getParentNode($this->Auth->user('id'),'id');
				$myLeader = $arrMyLeader['User']['id'];
			}
			if (in_array($this->objLoggedUser->getAttr('role_id'),array('5','6'))) {
				$topParent = $this->User->getPath($this->Auth->user('id'));
				$myTopLeader = $this->getTopleader = $topParent[2]['User']['role_id'] == 4 ? $topParent[2]['User']['id'] : $topParent[1]['User']['id'];
			}
			$this->set('myTopLeader',$myTopLeader);
			$this->set('myLeader',$myLeader);
		}
		/*
		 * Auth component initial setup
		 */	
//		$this->Auth->Allow(array('display')); //This is used to allow users to navigate into the main index page of the site without loggin in.
		$this->Auth->authError = 'Please Log In to access the page';
		$this->Auth->loginError = 'Incorrect username/password.';
		
		
		$this->set('logged_in', $this->_loggedIn());
		$this->set('username', $this->_username());
		$this->set('isAuthorized', $this->isAuthorized());
		$this->set('isMobile', $this->_isMobile());
		$this->set('today', $this->_today());
		$this->set('objLoggedUser', $this->objLoggedUser);
		$this->set('salesByUsers', $this->salesByUsers());
		$this->set('csievents', $this->csievents());
		$this->set('users', $this->salesPerson());
		$this->set('regions', $this->salesByRegions());
		$this->set('lastpost', $this->lastpost());
		
    }

	/**
	* This function return true if user is authorized 
	**/
	public function isAuthorized() {
	    // Admin and Developers can access every action
	    if (isset($this->objLoggedUser) && is_object($this->objLoggedUser)) {
		    if (in_array($this->objLoggedUser->getAttr('role_id'),array('1', '2', '8'))) {
		        return true;
		    }
	    }

	    // Default deny
	    return false;
	}

	/**
	* This function return true if it is a mobile devive
	**/
	public function _isMobile() {
	    // Return true if is a Mobile device
		if ($this->RequestHandler->isMobile()) {
		    return true;
	    }

	    // Default deny
	    return false;
	}

	/**
	* This function return today's date
	**/
	public function _today() {
	    return date("Y-m-d H:i:s");
	}

	/**
	* This function return if there is a user logged in
	**/
	public function _loggedIn(){
		return ($this->Auth->user() ? true : false);
	}
	
	/**
	* This function return the username logged in
	**/
	function _username() {
		$username = null;
		if($this->Auth->user()) {
			$username = $this->Auth->user('username');
		}
		return $username;
		
	}

	/**
	* This function return all sales by User
	**/
	function salesPerson() {
		$arrTemp = array();
		$this->loadModel('User');
		$arrTemp = $this->User->find('list',array(
			'conditions'=>array(
				'User.role_id'=>'6')));
		return $arrTemp;
		
	}

	/**
	* This function return all sales by User
	**/
	function salesByUsers($id = null) {
		$arrTemp = array();
		$this->loadModel('User');
		$arrTemp = $this->User->find('all');
		return $arrTemp;
		
	}

	/**
	* This function return all sales by Region
	**/
	function salesByRegions($id = null) {
		$arrTemp = array();
		$this->loadModel('Region');
		$arrTemp = $this->Region->find('all');
		return $arrTemp;
		
	}

	/**
	* This function return latest appointments 
	**/
	function csievents($id = null) {
		$arrTemp = array();
		$this->loadModel('Event');
		$arrTemp = $this->Event->find('all', array(
			'conditions'=>array(
				'Event.event_type_id'=>array(
					'4','5','8'
				)),
			'order'=>'Event.start',
			'limit'=>3));
		return $arrTemp;
		
	}

	/**
	* This function return latest appointments 
	**/
	function lastpost() {
		$arrTemp = array();
		$this->loadModel('Post');
		$arrTemp = $this->Post->find('first', array(
			'order'=>array('Post.created'=>'DESC'),
			'limit'=>1));
		return $arrTemp;
		
	}

	/**
	* This function does the same thing as the View::element and return the rendered element.
	* This is useful when you need the html of an element in a controller
	**/
	function element($name, $data = array(), $options = array()){
		$tmpView = new View();
		$tmpView->helpers = $this->helpers;
		$tmpView->loadHelpers();
		$data['objRequest'] =& $this->request;
		$data['objController'] =& $this;
		
		$return = $tmpView->element($name, $data, $options);
		unset($tmpView);
		return $return;
	}
	
}
