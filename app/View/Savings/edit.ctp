<div class="savings form">
<?php echo $this->Form->create('Saving'); ?>
	<fieldset>
		<legend><?php echo __('Edit Saving'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('payroll_id');
		echo $this->Form->input('savingdate');
		echo $this->Form->input('saving');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Saving.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Saving.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Savings'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Payrolls'), array('controller' => 'payrolls', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Payroll'), array('controller' => 'payrolls', 'action' => 'add')); ?> </li>
	</ul>
</div>
