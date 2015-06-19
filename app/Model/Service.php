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
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Region' => array(
			'className' => 'Region',
			'foreignKey' => 'region_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
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
