<div class="savings view">
<h2><?php echo __('Saving'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($saving['Saving']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($saving['User']['username'], array('controller' => 'users', 'action' => 'view', $saving['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Payroll'); ?></dt>
		<dd>
			<?php echo $this->Html->link($saving['Payroll']['id'], array('controller' => 'payrolls', 'action' => 'view', $saving['Payroll']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Savingdate'); ?></dt>
		<dd>
			<?php echo h($saving['Saving']['savingdate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Saving'); ?></dt>
		<dd>
			<?php echo h($saving['Saving']['saving']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($saving['Saving']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($saving['Saving']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Saving'), array('action' => 'edit', $saving['Saving']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Saving'), array('action' => 'delete', $saving['Saving']['id']), null, __('Are you sure you want to delete # %s?', $saving['Saving']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Savings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Saving'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Payrolls'), array('controller' => 'payrolls', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Payroll'), array('controller' => 'payrolls', 'action' => 'add')); ?> </li>
	</ul>
</div>
