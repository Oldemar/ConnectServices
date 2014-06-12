<?php
App::uses('AppModel', 'Model');
/**
 * Payroll Model
 *
 * @property User $User
 * @property Saving $Saving
 */
class Payroll extends AppModel {


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


}
