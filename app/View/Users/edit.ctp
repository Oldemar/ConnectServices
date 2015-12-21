<?php echo $this->Form2->create('User'); ?>
<h3><?php echo __('Edit User'); ?></h3>
<div class="row">
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<?php
			echo $this->Form2->input('id');
			if ($isAuthorized){
				echo $this->Form2->input('username', array(
					'class'=>'form-control pull-left',
					'style'=>'width: 250px',
					'label'=>array(
						'class'=>'pull-left',
						'style'=>'width: 120px'
						)));
			} else {
				echo $this->Form2->input('username', array(
					'class'=>'form-control pull-left',
					'style'=>'width: 250px',
					'readonly'=>'readonly',
					'label'=>array(
						'class'=>'pull-left',
						'style'=>'width: 120px'
						)));
			}
		?>
		<div style="clear: both"></div>
		<?php
			if ($isAuthorized) {
				echo $this->Form2->input('region_id', array(
					'class'=>'form-control pull-left',
					'style'=>'width: 250px',
					'label'=>array(
						'class'=>'pull-left',
						'style'=>'width: 120px'
						)));
			} else {
				echo $this->Form2->input('Region.name', array(
					'class'=>'form-control pull-left',
					'style'=>'width: 250px',
					'readonly'=>'readonly',
					'label'=>array(
						'class'=>'pull-left',
						'style'=>'width: 120px'
						)));
			}
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
	</div>
	<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		<?php
			if ($isAuthorized) {
				echo $this->Form2->input('comission', array(
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
					'class'=>'form-control pull-left',
					'style'=>'width: 250px',
					'label'=>array(
						'class'=>'pull-left',
						'style'=>'width: 120px'
						)));
		?>
		<div style="clear: both"></div>
		<?php
				echo $this->Form2->input('triplebonus', array(
					'class'=>'form-control pull-left',
					'style'=>'width: 250px',
					'label'=>array(
						'class'=>'pull-left',
						'style'=>'width: 120px'
						)));
		?>
		<div style="clear: both"></div>
		<?php
				echo $this->Form2->input('quadbonus', array(
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
	</div>
</div>
<?php
	}
	else
	{
		echo $this->Form2->input('role_id', array(
			'type'=>'hidden'
			));
	}
	echo $this->Form2->input('parent_id', array(
		'type'=>'hidden',
		'value'=>'2'));
	echo $this->Form2->button('Save', array(
		'type'=>'submit','class'=>'pull-right btn btn-lg btn-primary')); 
	echo $this->Form2->end(); 
?>
