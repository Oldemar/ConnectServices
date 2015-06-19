<div class="well">
<?php 
	echo $this->Form2->create('User', array('role'=>'form')); 
?>
	<h3><?php echo __('New User'); ?></h3>
<?php
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
	echo $this->Form2->input('password', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php
	echo $this->Form2->input('fullname', array(
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
	echo $this->Form2->input('region_id', array(
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
	echo $this->Form2->input('comission', array(
		'value'=>25,
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php
	echo $this->Form2->input('bonus', array(
		'value'=>0,
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php
	echo $this->Form2->input('saving', array(
		'value'=>10,
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<?php /*
	if ($isAuthorized) {
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
?>
<div style="clear: both"></div>
<?php
	}
	else
	{
		echo $this->Form2->input('role_id', array(
			'type'=>'hidden',
			'value'=>'7'));
		echo $this->Form2->input('parent_id', array(
			'type'=>'hidden',
			'value'=>'2'));
	}
	*/
	echo $this->Form2->button('Save', array(
		'type'=>'submit','class'=>'pull-right btn btn-lg btn-primary')); 
	echo $this->Form2->end(); 
?>
</div>