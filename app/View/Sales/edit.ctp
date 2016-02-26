
<?php echo $this->Form2->create('Sale'); ?>
		<h3><?php echo __('Edit Sale'); ?></h3>
<div class="row">
	<div class="col-lg-4">
		<h4 class="text-center">Sale Info</h4>
		<?php
			echo $this->Form2->input('id');
			if (in_array($objLoggedUser->getAttr('role_id'), array('1', '2', '8', '9')))
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
			echo $this->Form2->input('sales_date', array(
				'type'=>'text',
				'readonly'=>'readonly',
				'id'=>'saleDate',
				'class'=>'form-control pull-left',
				'style'=>'width: 250px',
				'label'=>array(
					'class'=>'pull-left',
					'style'=>'width: 100px'
					)));
		?>
		<div style="clear: both"></div>
		<?php
				echo $this->Form2->input('jobnumber', array(
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
			echo $this->Form2->input('accnumber', array(
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
			echo $this->Form2->input('instalation', array(
				'type'=>'text',
				'id'=>'installDate',
				'required'=>'required',
				'placeholder'=>'This field is required',
				'class'=>'form-control pull-left',
				'style'=>'width: 250px',
				'label'=>array(
					'class'=>'pull-left',
					'style'=>'width: 100px'
					)));
		?>
		<div style="clear: both"></div>
		<?php
				echo $this->Form2->label('installed', 'Is installed?', array(
					'style'=>'width: 120px; padding:10px 0'
					));

				echo $this->Form2->checkbox('installed', array(
					'disabled'=>'disabled',
					'label'=>false
					));
		?>
		<div style="clear: both"></div>
		<?php
			if (in_array($objLoggedUser->getAttr('role_id'), array('2','9')))
			{
				echo $this->Form2->input('notes', array(
					'type'=>'textarea',
					'class'=>'form-control pull-left',
					'style'=>'width: 250px;min-height:200px',
					'label'=>array(
						'class'=>'pull-left',
						'style'=>'width: 100px'
					)));
			}
		?>
	</div>
	<div class="col-lg-4">
		<h4 class="text-center">Customer Info</h4>
			<?php
				echo $this->Form2->input('Customer.id');
				echo $this->Form2->input('Customer.user_id', array(
					'type'=>'hidden'
					));
				echo $this->Form2->input('Customer.name', array(
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
			echo $this->Form2->input('Customer.email', array(
				'type'=>'email',
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
				echo $this->Form2->input('Customer.address1', array(
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
				echo $this->Form2->input('Customer.address2', array(
				'class'=>'form-control pull-left',
				'style'=>'width: 250px',
				'label'=>array(
					'class'=>'pull-left',
					'style'=>'width: 100px'
					)));
		?>
		<div style="clear: both"></div>
		<?php
				echo $this->Form2->input('Customer.city', array(
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
				echo $this->Form2->input('Customer.state', array(
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
				echo $this->Form2->input('Customer.zipcode', array(
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
				echo $this->Form2->input('Customer.homephone', array(
				'class'=>'form-control pull-left',
				'style'=>'width: 250px',
				'label'=>array(
					'class'=>'pull-left',
					'style'=>'width: 100px'
					)));
		?>
		<div style="clear: both"></div>
		<?php
				echo $this->Form2->input('Customer.cellphone', array(
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
				echo $this->Form2->input('Customer.workphone', array(
				'class'=>'form-control pull-left',
				'style'=>'width: 250px',
				'label'=>array(
					'class'=>'pull-left',
					'style'=>'width: 100px'
					)));
		?>
		<div style="clear: both"></div>
	</div>
	<div class="col-lg-4">
		<h4 class="text-center">Services</h4>
		<?php
				echo $this->Form2->input('category', array(
				'class'=>'form-control pull-left',
				'style'=>'width: 250px',
				'label'=>array(
					'class'=>'pull-left',
					'style'=>'width: 100px'
					)));
		?>
		<div style="clear: both"></div>
		<?php
				echo $this->Form2->input('tv', array(
				'class'=>'form-control pull-left',
				'style'=>'width: 250px',
				'label'=>array(
					'class'=>'pull-left',
					'style'=>'width: 100px'
					)));
		?>
		<div style="clear: both"></div>
		<?php
				echo $this->Form2->input('internet', array(
				'class'=>'form-control pull-left',
				'style'=>'width: 250px',
				'label'=>array(
					'class'=>'pull-left',
					'style'=>'width: 100px'
					)));
		?>
		<div style="clear: both"></div>
		<?php
				echo $this->Form2->input('phone', array(
				'class'=>'form-control pull-left',
				'style'=>'width: 250px',
				'label'=>array(
					'class'=>'pull-left',
					'style'=>'width: 100px'
					)));
		?>
		<div style="clear: both"></div>
		<?php
				echo $this->Form2->input('xfinity_home', array(
				'class'=>'form-control pull-left',
				'style'=>'width: 250px',
				'label'=>array(
					'class'=>'pull-left',
					'style'=>'width: 100px'
					)));
		?>
		<div style="clear: both"></div><hr>
		<?php 
				echo $this->Form2->input('bonus', array(
				'class'=>'form-control pull-left',
				'style'=>'width: 250px',
				'label'=>array(
					'class'=>'pull-left',
					'style'=>'width: 100px'
					)));
		?>
		<div style="clear: both"></div><hr>
		<br>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<?php 
			echo $this->Form2->button('Save', array(
				'type'=>'submit','class'=>'pull-right btn btn-lg btn-primary')); 
			echo $this->Form2->end(); ?>
		<div style="clear: both"></div>
	</div>
</div>
	<script type="text/javascript">
		$( "#installDate" ).datepicker({
			dateformat: 'yy-mm-dd'
		});
  	</script>
