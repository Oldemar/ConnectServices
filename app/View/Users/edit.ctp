<?php echo $this->Form2->create('User'); ?>
		<h3><?php echo __('Edit User'); ?></h3>
<?php
	echo $this->Form2->input('id');
	echo $this->Form2->input('username', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php
	echo $this->Form2->input('email', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php
	echo $this->Form2->input('address1', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php
	echo $this->Form2->input('address2', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php
	echo $this->Form2->input('city', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php
	echo $this->Form2->input('state', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php
	echo $this->Form2->input('zipcode', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php
	echo $this->Form2->input('homephone', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php
	echo $this->Form2->input('cellphone', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
	echo $this->Form2->input('carrier_id', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px; padding-left: 20px'
			)));
?>
<div style="clear: both"></div>
<?php
	echo $this->Form2->input('workphone', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php
	if ($isAuthorized) {
		echo $this->Form2->input('topleader', array(
		'options'=>$leaders,
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php
		echo $this->Form2->input('role_id', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php
		echo $this->Form2->input('parent_id', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
	}
?>
<div style="clear: both"></div>
<?php
	echo $this->Form2->button('Save', array(
		'type'=>'submit','class'=>'pull-right btn btn-lg btn-primary')); 
	echo $this->Form2->end(); ?>
