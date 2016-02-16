<div class="payrolls form">
<?php echo $this->Form->create('Payroll', array('role'=>'form','class'=>'form-horizontal')); ?>
		<h3><?php echo __('Insert Bank Info'); ?></h3>
	<?php
		echo $this->Form->input('id');
		echo '<div style="padding: 5px 0; width:120px; float: left; font-weight: bold">Date</div><b>'.CakeTime::format($this->data['Payroll']['payrolldate'], '%B %e, %Y').'</b><div style="clear: both"></div>';
	?>
	<div style="clear: both"></div>
	<?php
		echo $this->Form->input('User.username', array(
			'class'=>'form-control pull-left',
			'style'=>'width: 250px',
			'readonly'=>'readonly',
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
			'readonly'=>'readonly',
			'label'=>array(
				'class'=>'pull-left',
				'style'=>'width: 120px'
				)));
	?>
	<div style="clear: both"></div>
	<?php
		echo $this->Form->input('saving', array(
			'class'=>'form-control pull-left',
			'style'=>'width: 250px',
			'readonly'=>'readonly',
			'label'=>array(
				'class'=>'pull-left',
				'style'=>'width: 120px'
				)));
	?>
	<div style="clear: both"></div>
	<?php
		echo $this->Form->input('bonus', array(
			'class'=>'form-control pull-left',
			'style'=>'width: 250px',
			'readonly'=>'readonly',
			'label'=>array(
				'class'=>'pull-left',
				'style'=>'width: 120px'
				)));
	?>
	<div style="clear: both"></div>
	<?php
		echo $this->Form->input('advance', array(
			'readonly'=>'readonly',
			'class'=>'form-control pull-left',
			'style'=>'width: 250px',
			'label'=>array(
				'class'=>'pull-left',
				'style'=>'width: 120px'
				)));
	?>
	<div style="clear: both"></div>
	<?php
		echo $this->Form->input('totaldue', array(
			'readonly'=>'readonly',
			'class'=>'form-control pull-left',
			'style'=>'width: 250px;font-weight: bold',
			'label'=>array(
				'class'=>'pull-left',
				'style'=>'width: 120px'
				)));
	?>
	<div style="clear: both"></div>
	<?php
		echo $this->Form->input('bank', array(
			'class'=>'form-control pull-left',
			'style'=>'width: 250px',
			'label'=>array(
				'class'=>'pull-left',
				'style'=>'width: 120px'
				)));
	?>
	<div style="clear: both"></div>
	<?php	
		echo $this->Form->input('chknumber', array(
			'class'=>'form-control pull-left',
			'style'=>'width: 250px',
			'label'=>array(
				'class'=>'pull-left',
				'style'=>'width: 120px'
				)));
	?>
	<div style="clear: both"></div>
	<?php	
		echo $this->Form->input('notes', array(
			'type'=>'textarea',
			'escape'=>true,
			'class'=>'form-control pull-left',
			'style'=>'width: 250px',
			'label'=>array('Notes',
				'class'=>'pull-left',
				'style'=>'width: 120px'
				)));
	?>
	<div style="clear: both"></div>
<?php 
echo $this->Form2->button('Save', array(
	'type'=>'submit','class'=>'btn btn-lg btn-primary')); 
echo $this->Form->end(); ?>
</div>
