<?php
App::uses('AppModel', 'Model');
/**
 * Service Model
 *
 * @property Saleservice $Saleservice
 */
class Service extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Saleservice' => array(
			'className' => 'Saleservice',
			'foreignKey' => 'service_id',
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

	public function getPrice($service) {
		$return = $this->find('first', array(
			'conditions'=>array(
				'Service.name'=>$service
				)));
		return $return['Service']['price'];
	}


}
