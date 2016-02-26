<div class="payrolls view">
<h2><?php echo __('Payroll'); ?></h2>
	<dl>
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
	</dl>
</div>
