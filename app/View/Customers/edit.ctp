<div class="customers form">
<?php echo $this->Form->create('Customer', array('role'=>'form')); ?>
		<h3><?php echo __('Edit Customer'); ?></h3>
	<?php
		echo $this->Form->input('id');
		if ($objLoggedUser->getAttr('role_id') != '6')
		{
			echo $this->Form->input('user_id', array(
				'class'=>'form-control pull-left',
				'style'=>'width: 250px',
				'label'=>array(
					'class'=>'pull-left',
					'style'=>'width: 120px'
					)));
		}
		else
		{
			echo $this->Form->input('user_id', array(
				'type'=>'hidden',
				'value'=>$objLoggedUser->getID()
				));
		}
?>
<div style="clear: both"></div>
<?php

		echo $this->Form->input('name', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php

		echo $this->Form->input('email', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php

		echo $this->Form->input('address1', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php

		echo $this->Form->input('address2', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php

		echo $this->Form->input('city', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php

		echo $this->Form->input('state', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php

		echo $this->Form->input('zipcode', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php

		echo $this->Form->input('homephone', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php

		echo $this->Form->input('cellphone', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php

		echo $this->Form->input('carrier_id', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php

		echo $this->Form->input('workphone', array(
		'class'=>'form-control pull-left',
		'style'=>'width: 250px',
		'label'=>array(
			'class'=>'pull-left',
			'style'=>'width: 120px'
			)));
?>
<div style="clear: both"></div>
<?php
	echo $this->Form2->button('Save', array(
		'type'=>'submit','class'=>'pull-right btn btn-lg btn-primary')); 
?>
<?php echo $this->Form->end(); ?>
</div>
