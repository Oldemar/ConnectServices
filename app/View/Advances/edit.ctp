<div class="well">
<?php echo $this->Form->create('Advance'); ?>
	<h2><?php echo __('Edit Advance'); ?></h2>
	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<?php
				echo $this->Form->input('id');
				echo $this->Form->input('user_id', array(
					'class'=>'form-control pull-left',
					'id'=>'advUser',
					'readonly'=>'readonly',
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
					'id'=>'advDate',
					'readonly'=>'readonly',
					'class'=>'form-control pull-left',
					'required'=>'required',
					'placeholder'=>'This field is required',
					'style'=>'width: 250px',
					'label'=>array(
						'class'=>'pull-left',
						'style'=>'width: 120px'
						)));
				?>
			<div style="clear: both"></div>
			<?php

				echo $this->Form->input('value', array(
					'class'=>'form-control pull-left',
					'id'=>'advValue',
					'readonly'=>'readonly',
					'placeholder'=>'This field is required',
					'style'=>'width: 250px',
					'label'=>array(
						'class'=>'pull-left',
						'style'=>'width: 120px'
						)));
			?>
			<div style="clear: both"></div>
			<?php

				echo $this->Form->input('balance', array(
					'class'=>'form-control pull-left',
					'readonly'=>'readonly',
					'id'=>'advBalance',
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
			<?php

				echo $this->Form->input('notes', array(
					'type'=>'textarea',
					'class'=>'form-control pull-left',
					'style'=>'width: 250px',
					'label'=>array(
						'class'=>'pull-left',
						'style'=>'width: 120px'
					)));
			?>
			<div style="clear: both"></div>
		</div>
		<div class="col-xs-12 col-sm-6">
			<?php
				echo $this->Form->label('charge', 'Charge it?', array(
					'style'=>'width: 120px; padding:10px 0 0 0'
					));

				echo $this->Form->checkbox('charge', array(
					'label'=>false
					));
			?>
			<div style="clear: both"></div>
			<?php
				echo $this->Form->label('received', 'Received ?', array(
					'style'=>'width: 120px; padding:10px 0'
					));

				echo $this->Form->checkbox('received', array(
					'label'=>false
					));
			?>
			<div style="clear: both"></div>
			<?php

				echo $this->Form->input('authorizedby', array(
				'value'=>$objLoggedUser->getID(),	
				'class'=>'form-control pull-left',
				'style'=>'width: 250px',
				'readonly'=>'readonly',
				'label'=>array(
					'class'=>'pull-left',
					'style'=>'width: 120px'
					)));
			?>
			<div style="clear: both"></div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<?php 
					echo $this->Form->button('Save', array(
						'type'=>'submit',
						'id'=>'btnSave',
						'class'=>'pull-right btn btn-lg btn-primary'
						)); 
					echo $this->Form->end(); ?>
				<div style="clear: both"></div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var balance = 0;
	$( "#advDate" ).datepicker({
		dateformat: 'yy-mm-dd'
	});
	$('#advUser').change(function(e){
		$.ajax({
			url: "<?php echo Router::url(array('controller'=>'advances','action'=>'getbalance')); ?>",
			type : "post",
			dataType: "json",
			data: { 
				userID: $('#advUser').val()
			}
		}).done(function(data){
			balance = data;
			$('#advBalance').val(balance);
		});
	});
	$('#advValue').change(function(e){
		var balanceAdd = parseInt(balance) + parseInt($('#advValue').val());
		$('#advBalance').val(balanceAdd);
	});
</script>
