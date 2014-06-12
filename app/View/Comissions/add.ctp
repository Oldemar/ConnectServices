<div class="well">
<?php echo $this->Form->create('Comission'); ?>
		<h3><?php echo __('New Comission'); ?></h3>
	<?php
		echo $this->Form->input('user_id', array(
			'type'=>'hidden',
			'value'=>$objLoggedUser->getID()));
?>
<div style="clear: both"></div>
<?php

		echo $this->Form->input('role_id', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php
		echo $this->Form->input('name', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php

		echo $this->Form->input('comission', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php
		echo $this->Form->input('range', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php
	echo $this->Form2->button('Save', array(
		'type'=>'submit','class'=>'pull-right btn btn-lg btn-primary')); 
?>
<?php echo $this->Form->end(); ?>
</div>
