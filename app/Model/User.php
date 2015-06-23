<?php
App::uses('AppModel', 'Model');
App::uses('AuthComponent', 'Controller/Component');
/**
 * User Model
 *
 * @property Picture $Picture
 * @property Role $Role
 * @property Event $Event
 */
class User extends AppModel {

public $actsAs = array('Tree','Containable');
/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'username';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'username' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            )
        ),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Role' => array(
			'className' => 'Role',
			'foreignKey' => 'role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Region' => array(
			'className' => 'Region',
			'foreignKey' => 'region_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Carrier' => array(
			'className' => 'Carrier',
			'foreignKey' => 'carrier_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ParentUser' => array(
			'className' => 'User',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ChildUser' => array(
			'className' => 'User',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Event' => array(
			'className' => 'Event',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Sale' => array(
			'className' => 'Sale',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Payroll' => array(
			'className' => 'Payroll',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Saving' => array(
			'className' => 'Saving',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Advance' => array(
			'className' => 'Advance',
			'foreignKey' => 'user_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)

	);
	/**
	 * beforeSave method
	 */
		public function beforeSave($options = array()) {
	    if (isset($this->data[$this->alias]['password'])) {
	        $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
	    }
	    return true;
	}

	/**
	 * afterSave method
	 */
		public function afterSave($created, $options = array()) {
	    if (isset($this->data[$this->alias]['id'])) {
	        $this->saveField('topleader', $this->getTopleader($this->data[$this->alias]['id']), array('callbacks'=>false));
	        return true;
	    }
	    return true;
	}

	/**
	 * Activate the user changing his status to 1
	 */
	public function activate(){
		if($this->getID()){
			$this->data['User']['active']='1';
			if($this->saveField('active','1')){
				return $this->saveField('activate',date('Y-m-d'));
			}
		}

		return false;

	}

	/**
	 * Return username for a given ID
	 */
	public function getUsername($id){

		$return = $this->find('first', array(
			'conditions'=>array(
				'User.id'=>$id)));

		return $return['User']['username'];

	}

	/**
	 * Returns true if the user is active
	 * Returns false if not
	 */
	public function checkIsActive(){
		if($this->getAttr('active') == '1'){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * Return top leader's user_id for a given ID
	 */
	public function getTopleader($id){

		$userinfo = $this->find('first',array(
			'conditions'=> array(
				'User.id'=>$id
				)));
		return $userinfo['User']['topleader'];

	}

	public function getTotals($id = null)
	{
		$this->loadModel('Sale');
		$arrReturn = array();
		$arrReturn['myTotal'] = $this->Sale->find('count', array(
					'conditions'=> array(
						'AND'=> array(
							'Sale.user_id'=>$id,
							'MONTH(Sale.sales_date)'=> date('m'),
							))));
		if ($this->data['User']['role_id'] == '5')
		{
		$arrReturn['teamTotal'] = $this->Sale->find('count', array(
					'conditions'=> array(
						'AND'=> array(
							'User.parent_id'=>$id,
							'User.role_id'=>'6',
							'MONTH(Sale.sales_date)'=> date('m'),
							))));
		}
		if ($this->data['User']['role_id'] == '4')
		{
			$arrReturn['franTotal'] = $this->Sale->find('count', array(
					'conditions'=> array(
						'AND'=> array(
							'MONTH(Sale.sales_date)'=> date('m'),
							'User.topleader'=>$id
							))));
		}

		return $arrReturn;
	}

	public function myChildren()
	{

		$childrenIds = $this->id;

		if ( $this->getAttr('role_id') != '6' ) 
		{
			$childrenIds = Hash::extract($this->children($this->id), '{n}.User.id');
			$childrenIds[] = $this->id;
		}

		return $childrenIds;

	}

}
