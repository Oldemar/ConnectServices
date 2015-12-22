<?php
App::uses('AppModel', 'Model');
/**
 * Advance Model
 *
 * @property User $User
 * @property Advance $Sale
 */
class Advance extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function beforeSave($options = array())
	{

		if (isset($this->data['Advance']['advdate']))
		{
			$this->data['Advance']['advdate'] = date('Y-m-d h:i:s', strtotime($this->data['Advance']['advdate']));
		}
	}


}
