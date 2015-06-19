<div class="well">
<?php echo $this->Form->create('Role', array('role'=>'form')); ?>
		<h3><?php echo __('New Role'); ?></h3>
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
			echo $this->Form->input('description', array(
			'class'=>'form-control pull-left',
			'style'=>'width: 250px',
			'label'=>array(
				'class'=>'pull-left',
				'style'=>'width: 120px'
				)));
	?>
	<div style="clear: both"></div>
	<?php	
		echo $this->Form->button('Save', array(
			'type'=>'submit','class'=>'pull-right btn btn-lg btn-primary')); 
		echo $this->Form->end(); 
	?>
</div>
