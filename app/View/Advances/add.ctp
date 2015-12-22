<div class="well">
<?php echo $this->Form->create('Advance'); ?>
	<h2><?php echo __('Add Advance'); ?></h2>
	<?php
		echo $this->Form->input('user_id', array(
			'empty'=>'Choose user',
			'class'=>'form-control pull-left',
			'id'=>'advUser',
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
