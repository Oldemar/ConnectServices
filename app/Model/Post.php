<?php
App::uses('AppModel', 'Model');
/**
 * Post Model
 *
 * @property User $User
 */
class Post extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';


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
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function beforeSave( $options = array() ) {

		if ($this->data['Post']['File']['error'] != 0) {
			$this->errorMessage = 'Upload failed, try again. If the problem persists contact support.';
			return false;
		}

		$arrPostType = explode('/',$this->data['Post']['File']['type']);
		
		if ($arrPostType[0] == 'image') {
			$Posttype = '0';
		} else {
			$this->errorMessage = 'Only images are accepted, choose another file...';
			return false;
		}

		$fileName = md5($this->data['Post']['File']['name'].date('Y-m-d-H:i:s')).'.'.$arrPostType[1];
		$this->data['Post']['image'] = $fileName;

		move_uploaded_file($this->data['Post']['File']['tmp_name'], $this->webroot.'img/'.$fileName);
		
		return true;

	}

}
