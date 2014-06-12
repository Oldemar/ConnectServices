<div class="services form">
<?php echo $this->Form->create('Service'); ?>
	<fieldset>
		<legend><?php echo __('Add Service'); ?></legend>
	<?php
		echo $this->Form->input('group');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('price');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Services'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Saleservices'), array('controller' => 'saleservices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Saleservice'), array('controller' => 'saleservices', 'action' => 'add')); ?> </li>
	</ul>
</div>
