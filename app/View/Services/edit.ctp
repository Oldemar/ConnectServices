<div class="well">
<?php echo $this->Form->create('Service'); ?>
	<h2><?php echo __('Edit Service'); ?></h2>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('Region.name', array(
			'class'=>'form-control pull-left',
			'style'=>'width: 250px',
			'readonly'=>'readonly',
			'label'=>array(
				'class'=>'pull-left',
				'style'=>'width: 100px'
				)));
	?>
	<div style="clear: both"></div>
	<?php
		echo $this->Form->input('group', array(
			'class'=>'form-control pull-left',
			'style'=>'width: 250px',
			'readonly'=>'readonly',
			'label'=>array(
				'class'=>'pull-left',
				'style'=>'width: 100px'
				)));
	?>
	<div style="clear: both"></div>
	<?php
		echo $this->Form->input('name', array(
			'class'=>'form-control pull-left',
			'style'=>'width: 250px',
			'readonly'=>'readonly',
			'label'=>array(
				'class'=>'pull-left',
				'style'=>'width: 100px'
				)));
	?>
	<div style="clear: both"></div>
	<?php
		echo $this->Form->input('description', array(
			'class'=>'form-control pull-left',
			'style'=>'width: 250px',
			'label'=>array(
				'class'=>'pull-left',
				'style'=>'width: 100px'
				)));
	?>
	<div style="clear: both"></div>
	<h4>Prices</h4>
	<?php
		echo $this->Form->input('sfu_in', array(
			'class'=>'form-control pull-left',
			'style'=>'width: 250px',
			'required'=>'required',
			'placeholder'=>'This field is required',
			'label'=>array(
				'class'=>'pull-left',
				'style'=>'width: 100px'
				)));
	?>
	<div style="clear: both"></div>
	<?php
		echo $this->Form->input('sfu_out', array(
			'class'=>'form-control pull-left',
			'style'=>'width: 250px',
			'required'=>'required',
			'placeholder'=>'This field is required',
			'label'=>array(
				'class'=>'pull-left',
				'style'=>'width: 100px'
				)));
	?>
	<div style="clear: both"></div>
	<?php
		echo $this->Form->input('mdu_in', array(
			'class'=>'form-control pull-left',
			'style'=>'width: 250px',
			'required'=>'required',
			'placeholder'=>'This field is required',
			'label'=>array(
				'class'=>'pull-left',
				'style'=>'width: 100px'
				)));
	?>
	<div style="clear: both"></div>
	<?php
		echo $this->Form->input('mdu_out', array(
			'class'=>'form-control pull-left',
			'style'=>'width: 250px',
			'required'=>'required',
			'placeholder'=>'This field is required',
			'label'=>array(
				'class'=>'pull-left',
				'style'=>'width: 100px'
				)));
	?>
	<div style="clear: both"></div>
	<?php 
		echo $this->Form->button('Save', array(
			'type'=>'submit','class'=>'pull-right btn btn-lg btn-primary')); 
		echo $this->Form->end(); 
	?>
	<div style="clear: both"></div>
</div>
