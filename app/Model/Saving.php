<?php
App::uses('AppModel', 'Model');
/**
 * Saving Model
 *
 * @property User $User
 * @property Payroll $Payroll
 */
class Saving extends AppModel {


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
		),
		'Receivable' => array(
			'className' => 'Receivable',
			'foreignKey' => 'receivable_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	public function afterSave($created, $options = array())
	{
		if ($created) 
		{
			$x=0;
		}
	}
}
