<div class="well">
<?php echo $this->Form->create('Carrier', array('role'=>'form')); ?>
		<legend><?php echo __('Add Carrier'); ?></legend>
	<?php
		echo $this->Form->input('id');
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
		echo $this->Form->input('suffix', array(
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
