<div class="payrolls view">
<h2><?php echo __('Payroll'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($payroll['Payroll']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($payroll['User']['username'], array('controller' => 'users', 'action' => 'view', $payroll['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Payrolldate'); ?></dt>
		<dd>
			<?php echo h($payroll['Payroll']['payrolldate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comission'); ?></dt>
		<dd>
			<?php echo h($payroll['Payroll']['comission']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($payroll['Payroll']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($payroll['Payroll']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Payroll'), array('action' => 'edit', $payroll['Payroll']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Payroll'), array('action' => 'delete', $payroll['Payroll']['id']), null, __('Are you sure you want to delete # %s?', $payroll['Payroll']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Payrolls'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Payroll'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Savings'), array('controller' => 'savings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Saving'), array('controller' => 'savings', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Savings'); ?></h3>
	<?php if (!empty($payroll['Saving'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Payroll Id'); ?></th>
		<th><?php echo __('Savingdate'); ?></th>
		<th><?php echo __('Saving'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($payroll['Saving'] as $saving): ?>
		<tr>
			<td><?php echo $saving['id']; ?></td>
			<td><?php echo $saving['user_id']; ?></td>
			<td><?php echo $saving['payroll_id']; ?></td>
			<td><?php echo $saving['savingdate']; ?></td>
			<td><?php echo $saving['saving']; ?></td>
			<td><?php echo $saving['created']; ?></td>
			<td><?php echo $saving['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'savings', 'action' => 'view', $saving['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'savings', 'action' => 'edit', $saving['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'savings', 'action' => 'delete', $saving['id']), null, __('Are you sure you want to delete # %s?', $saving['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Saving'), array('controller' => 'savings', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
