<h3 class="text-center">Edit Receivable</h3>
<?php 
	echo $this->Form2->create('Receivable',array(
		'role'=>'form',
		'class'=>'form-horizontal'
	)); 
	echo $this->Form2->input('id');
?>
<div class="row" style="padding-bottom: 15px">
	<div class="col-lg-6" style="padding:5px; border: 1px solid #ccc; border-radius: 10px">
		<div class="row">
			<div class="col-lg-4">
				<h5><b>Region:</b></h5>
			</div>
			<div class="col-lg-8">
			<?php
				echo $this->Form2->input('region', array(
					'label'=>false,
					'div'=>false,
					'class'=>'form-control'
					));
			?>
			</div>
		</div>
	</div>
	<div class="col-lg-6" style="padding:5px; border: 1px solid #ccc; border-radius: 10px">
		<div class="row">
			<div class="col-lg-1">
				<h5><b>From</b></h5>
			</div>
			<div class="col-lg-5">
			<?php
				echo $this->Form2->input('start', array(
					'type'=>'text',
					'class'=>'form-control',
					'id'=>'startDate',
					'label'=>false,
					'div'=>false
					));
			?>
			</div>
			<div class="col-lg-1">
				<h5><b>To</b></h5>
			</div>
			<div class="col-lg-5">
			<?php
				echo $this->Form2->input('end', array(
					'type'=>'text',
					'id'=>'endDate',
					'class'=>'form-control',
					'label'=>false,
					'div'=>false
					));
			?>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$( "#startDate" ).datepicker({
			dateformat: 'yy-mm-dd'
		});
		$( "#endDate" ).datepicker({
			dateformat: 'yy-mm-dd'
		});
  	</script>
</div>
<div class="row" style="padding-bottom: 15px">
	<div class="col-lg-3" style="padding:5px; border: 1px solid #ccc; border-radius: 10px">
		<h4 class="text-center">Cable TV</h4>
	<?php
		echo $this->Form2->input('basic', array(
			'class'=>'form-control'));
		echo $this->Form2->input('economytv', array(
			'class'=>'form-control'));
		echo $this->Form2->input('starter', array(
			'class'=>'form-control'));
		echo $this->Form2->input('preferred', array(
			'class'=>'form-control'));
		echo $this->Form2->input('premier', array(
			'class'=>'form-control'));
	?>
	</div>
	<div class="col-lg-3" style="padding:5px; border: 1px solid #ccc; border-radius: 10px">
		<h4 class="text-center">Internet</h4>
	<?php
		echo $this->Form2->input('economynet', array(
			'class'=>'form-control'));
		echo $this->Form2->input('performancenet', array(
			'class'=>'form-control'));
		echo $this->Form2->input('blastnet', array(
			'class'=>'form-control'));
		echo $this->Form2->input('extremenet', array(
			'class'=>'form-control'));
	?>
	</div>
	<div class="col-lg-3" style="padding:5px; border: 1px solid #ccc; border-radius: 10px">
		<h4 class="text-center">Phone</h4>
	<?php
		echo $this->Form2->input('localphone', array(
			'class'=>'form-control'));
		echo $this->Form2->input('unlimitedphone', array(
			'class'=>'form-control'));
	?>
		<hr><h4 class="text-center">Extras</h4>
	<?php
		echo $this->Form2->input('globo', array(
			'class'=>'form-control'));
		echo $this->Form2->input('pfc', array(
			'class'=>'form-control'));
		echo $this->Form2->input('record', array(
			'class'=>'form-control'));
	?>
	</div>
	<div class="col-lg-3" style="padding:5px; border: 1px solid #ccc; border-radius: 10px"	>
		<h4 class="text-center">xFinity Home</h4>
	<?php
		echo $this->Form2->input('xh300', array(
			'class'=>'form-control'));
		echo $this->Form2->input('xh350', array(
			'class'=>'form-control'));
		echo $this->Form2->input('xh100', array(
			'class'=>'form-control'));
		echo $this->Form2->input('xh150', array(
			'class'=>'form-control'));
	?>
	</div>
</div>
<div class="row">
	<div class="col-lg-3" style="padding:5px; border: 1px solid #ccc; border-radius: 10px">
		Processed
	<?
		echo $this->Form2->checkbox('processed', array(
			'class'=>'form-control'));
	?>	
	</div>
</div>
<?php 
echo $this->Form2->button('Save', array(
	'type'=>'submit','class'=>'pull-right btn btn-lg btn-primary')); 
echo $this->Form2->end()
?>
