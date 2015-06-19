<div class="well">
<?php echo $this->Form2->create('Region'); ?>
	<h3><?php echo __('Edit Region'); ?></h3>
	<?php
	echo $this->Form2->input('id');
	echo $this->Form2->input('name', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php
	echo $this->Form2->input('abbreviation', array(
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
	echo $this->Form2->end(); 
?>
</div>
