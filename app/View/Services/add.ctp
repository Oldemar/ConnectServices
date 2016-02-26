<div class="well">
<?php echo $this->Form2->create('Service'); ?>
	<h2><?php echo __('Add Service'); ?></h2>
	<?php
		echo $this->Form2->input('region_id', array(
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
		echo $this->Form2->input('group', array(
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
		echo $this->Form2->input('name', array(
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
		echo $this->Form2->input('description', array(
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
		echo $this->Form2->input('sfu_in', array(
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
		echo $this->Form2->input('sfu_out', array(
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
		echo $this->Form2->input('mdu_in', array(
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
		echo $this->Form2->input('mdu_out', array(
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
		echo $this->Form2->button('Save', array(
			'type'=>'submit','class'=>'pull-right btn btn-lg btn-primary')); 
		echo $this->Form2->end(); 
	?>
	<div style="clear: both"></div>
</div>
