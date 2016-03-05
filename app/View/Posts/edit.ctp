  <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>tinymce.init({ selector:'textarea' });</script>
<?php echo $this->Form2->create('Post', array('type'=>'file')); ?>
		<h3><?php echo __('Edit Post'); ?></h3>
<div class="well row">
	<div class="col-xs-12 col-sm-5">
		<?php
			echo $this->Form2->input('id');
			if (in_array($objLoggedUser->getAttr('role_id'), array('2','9')))
			{
				echo $this->Form2->input('user_id', array(
					'empty'=>'Choose a user',
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
			echo $this->Form2->input('category_id', array(
				'empty'=>'Choose a category',
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
			echo $this->Form2->label('File','Image',array(
					'class'=>'pull-left',
					'style'=>'width: 100px'
					));
			echo $this->Html->image($post['Post']['image'], array('width'=>'250','style'=>'border: 1px doted #cccß;padding: 5px; margin: 5px;'));
		?>
		<div style="clear: both"></div>
		<div style="width: 350px;">
		<?php
			echo $this->Form2->button('Change Image', array(
				'type'=>'button',
				'id'=>'btnInputFile',
				'class'=>'pull-right btn btn-sm btn-danger')); 

		?>
		</div>
		<div style="clear: both"></div>
		<div id="inputFile" style="display: none">
		<?php
			echo $this->Form2->input('File', array(
				'type'=>'file',
				'class'=>'form-control pull-left',
				'style'=>'width: 250px',
				'label'=> array(
					'class'=>'pull-left',
					'style'=>'width: 100px'
					)
				));
		?>
		</div>
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
	</div>
	<div class="col-xs-12 col-sm-7">
		<h4>Body</h4>
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
			echo $this->Form2->button('Save', array(
				'type'=>'submit','class'=>'pull-right btn btn-lg btn-primary')); 
			echo $this->Form2->end(); ?>
		<div style="clear: both"></div>
	</div>
</div>
<script type="text/javascript">
	$('#btnInputFile').on('click', function(){
		$('#inputFile').show();
	});
</script>
