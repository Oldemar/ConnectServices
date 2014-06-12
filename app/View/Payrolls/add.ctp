<div class="payrolls form">
<?php echo $this->Form->create('Payroll'); ?>
	<fieldset>
		<legend><?php echo __('Add Payroll'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('payrolldate');
		echo $this->Form->input('comission');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Payrolls'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Savings'), array('controller' => 'savings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Saving'), array('controller' => 'savings', 'action' => 'add')); ?> </li>
	</ul>
</div>
