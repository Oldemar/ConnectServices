<?php echo $this->Form2->create('Post', array('type'=>'file')); ?>
		<h3><?php echo __('New Post'); ?></h3>
<div class="row">
	<div class="col-lg-4">
		<?php
			if (in_array($objLoggedUser->getAttr('role_id'), array('2','9')))
			{
				echo $this->Form2->input('user_id', array(
				'class'=>'form-control pull-left',
				'style'=>'width: 250px',
				'label'=>array(
					'class'=>'pull-left',
					'style'=>'width: 100px'
					)));
			}
			else
			{
				echo $this->Form2->input('user_id', array(
					'type'=>'hidden',
					'value'=>$objLoggedUser->getID()
					));
			}
		?>
		<?php
			echo $this->Form2->input('image', array(
//				'type'=>'file',
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
			echo $this->Form2->input('title', array(
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
			echo $this->Form2->input('body', array(
				'type'=>'textarea',
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
				echo $this->Form2->label('active', 'Is Active?', array(
					'style'=>'width: 120px; padding:10px 0'
					));

				echo $this->Form2->checkbox('active', array(
					'label'=>false
					));
		?>
		<div style="clear: both"></div>
		<?php
				echo $this->Form2->label('allowcomments', 'Allow Comments?', array(
					'style'=>'width: 120px; padding:10px 0'
					));

				echo $this->Form2->checkbox('allowcomments', array(
					'label'=>false
					));
		?>
		<div style="clear: both"></div>
		<?php 
			echo $this->Form2->button('Save', array(
				'type'=>'submit','class'=>'pull-right btn btn-lg btn-primary')); 
			echo $this->Form2->end(); ?>
		<div style="clear: both"></div>
	</div>
</div>
