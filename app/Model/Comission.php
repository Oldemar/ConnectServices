<?php
App::uses('AppModel', 'Model');
/**
 * Comission Model
 *
 */
class Comission extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

	public function getComissionPerc($topleader,$roleId,$saleQt)
	{
		$return = $this->find ('first',array(
			'conditions'=>array(
				'AND'=>array(
					'Comission.user_id'=>$topleader,
					'Comission.role_id'=>$roleId,
					'Comission.range >='=>$saleQt
					))));
		return $return['Comission']['comission'];
	}

	public function getPerc($region,$topleader,$roleId,$saleQt)
	{
		$return = $this->find ('first',array(
			'conditions'=>array(
				'AND'=>array(
					'Comission.user_id'=>$topleader,
					'Comission.role_id'=>$roleId,
					'Comission.region'=>$region,
					'Comission.range >='=>$saleQt
					))));
		return $return['Comission']['comission'];
	}
}
