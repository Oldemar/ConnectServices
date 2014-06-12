<?php
/*
 * Model/Event.php
 * CakePHP Full Calendar Plugin
 *
 * Copyright (c) 2010 Silas Montgomery
 * http://silasmontgomery.com
 *
 * Licensed under MIT
 * http://www.opensource.org/licenses/mit-license.php
 */
 
class Event extends AppModel {
	public $uses = 'User';
	var $name = 'Event';
	var $displayField = 'title';
	var $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'start' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		)
	);

	var $belongsTo = array(
		'EventType' => array(
			'className' => 'EventType',
			'foreignKey' => 'event_type_id'
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		)
	);

	function beforeSave($created) {
//		$this->data['Event']['user_id'] = $this->data['Event']['User']['id'];
		//echo '<pre>'.print_r($this->data['Event'],true).'</pre>';
		//die();
		return true;
	}
	public function childEvents($ids)
	{
		return 
		$this->find('all', array(
					'recursive'=>0,
					'conditions'=>array(
						'AND'=>array(
							'Event.user_id'=>$ids,
							'DATE(Event.start) >='=>date('Y-m-d'))),
					'order'=>'start',
					'limit'=>3));
	}
}
?>
