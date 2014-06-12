<?php
App::uses('AppModel', 'Model');
/**
 * Receivable Model
 *
 */
class Receivable extends AppModel {

	function beforeSave($options = array())
	{
		$this->data['Receivable']['start'] = date('Y-m-d', strtotime($this->data['Receivable']['start']));
		$this->data['Receivable']['end'] = date('Y-m-d', strtotime($this->data['Receivable']['end'])).' 23:59:59';
	}
}
