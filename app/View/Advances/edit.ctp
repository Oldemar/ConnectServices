<div>
<?php echo $this->Form->create('Advance'); ?>
	<fieldset>
		<h3><?php echo __('Edit Advance'); ?></h3>
	<?php
		echo $this->Form->input('id');
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

		echo $this->Form->input('value', array(
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

		echo $this->Form->input('balance', array(
			'class'=>'form-control pull-left',
			'style'=>'width: 250px',
			'label'=>array(
				'class'=>'pull-left',
				'style'=>'width: 120px'
				)));
	?>
	<div style="clear: both"></div>
	<?php

		echo $this->Form->input('advdate', array(
			'type'=>'text',
			'readonly'=>'readonly',
			'id'=>'advDate',
			'class'=>'form-control pull-left',
			'style'=>'width: 250px',
			'label'=>array(
				'class'=>'pull-left',
				'style'=>'width: 120px'
				)));
		?>
	<div style="clear: both"></div>
	<?php

		echo $this->Form->input('received', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
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
	<div class="row">
		<div class="col-lg-12">
			<?php 
				echo $this->Form->button('Save', array(
					'type'=>'submit','class'=>'pull-right btn btn-lg btn-primary')); 
				echo $this->Form->end(); ?>
			<div style="clear: both"></div>
		</div>
	</div>
</div>
