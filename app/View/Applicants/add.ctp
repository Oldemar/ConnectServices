<div class="well">
	<?php 
		echo $this->Form2->create('Applicant', array('role'=>'form')); 
	?>
	<h3><?php echo __('Applicant Register'); ?></h3><br>
	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<?php
				echo $this->Form2->label('user_id', 'Manager', array(
						'class'=>'pull-left',
						'style'=>'width: 120px'
						));
				echo $this->Form2->input('user_id', array(
					'class'=>'form-control pull-left',
					'style'=>'width: 250px',
					'label'=>false
				));
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
				echo $this->Form2->input('facebook', array(
					'class'=>'form-control pull-left',
					'style'=>'width: 250px',
					'label'=>array(
						'class'=>'pull-left',
						'style'=>'width: 120px'
						)));
			?>
			<div style="clear: both"></div>
			<?php
				echo $this->Form2->input('instagram', array(
					'class'=>'form-control pull-left',
					'style'=>'width: 250px',
					'label'=>array(
						'class'=>'pull-left',
						'style'=>'width: 120px'
						)));
			?>
			<div style="clear: both"></div>
			<?php
				echo $this->Form2->input('othersocialmedia', array(
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
			if ($isAuthorized) {
				echo $this->Form2->label('hired', 'Hired ?', array(
					'style'=>'width: 120px; padding:10px 0'
					));

				echo $this->Form2->checkbox('hired', array(
					'label'=>false
					));
			?>
				<div style="clear: both"></div>
		</div>
		<div class="col-xs-12 col-sm-6">
			<div style="clear: both"></div>
			<?php
				echo $this->Form2->input('sale', array(
					'class'=>'form-control pull-left',
					'style'=>'width: 250px',
					'label'=>array(
						'class'=>'pull-left',
						'style'=>'width: 120px'
						)));
			?>
			<div style="clear: both"></div>
			<?php
				echo $this->Form2->input('certificate', array(
					'class'=>'form-control pull-left',
					'style'=>'width: 250px',
					'label'=>array(
						'class'=>'pull-left',
						'style'=>'width: 120px'
						)));
			?>
			<div style="clear: both"></div>
			<?php
				echo $this->Form2->input('leads', array(
					'type'=>'textarea',
					'class'=>'form-control pull-left',
					'style'=>'width: 250px',
					'label'=>array(
						'class'=>'pull-left',
						'style'=>'width: 120px'
						)));
			?>
			<div style="clear: both"></div>
			<?php
				echo $this->Form2->input('notes', array(
					'type'=>'textarea',
					'class'=>'form-control pull-left',
					'style'=>'width: 250px',
					'label'=>array(
						'class'=>'pull-left',
						'style'=>'width: 120px'
						)));
			}
			?>
			<div style="clear: both"></div>
		</div>
	</div>
	<?php
		echo $this->Form2->button('Save', array(
			'type'=>'submit','class'=>'pull-right btn btn-lg btn-primary')); 
		echo $this->Form2->end(); 
	?>
	<div style="clear: both"></div>
