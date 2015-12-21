<div class="payrolls index">
	<h2><?php echo __('Payrolls'); ?></h2>
	<table class="table table-condensed table-hover table-bordered">
	<tr>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th class="text-center"><?php echo $this->Paginator->sort('payrolldate'); ?></th>
			<th class="text-right"><?php echo $this->Paginator->sort('comission'); ?></th>
			<th class="text-right"><?php echo $this->Paginator->sort('saving'); ?></th>
			<th class="text-right"><?php echo $this->Paginator->sort('bonus'); ?></th>
			<th class="text-right"><?php echo $this->Paginator->sort('advance'); ?></th>
			<th class="text-right"><?php echo $this->Paginator->sort('total due'); ?></th>
			<th><?php echo $this->Paginator->sort('bank'); ?></th>
			<th><?php echo $this->Paginator->sort('chknumber'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>

	</tr>
	<?php foreach ($payrolls as $payroll): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($payroll['User']['username'], array('controller' => 'users', 'action' => 'view', $payroll['User']['id'])); ?>
		</td>
		<td class="text-center"><?php echo CakeTime::format($payroll['Payroll']['payrolldate'], '%B %e, %Y '); ?>&nbsp;</td>
		<td class="text-right"><?php echo h($payroll['Payroll']['comission']); ?>&nbsp;</td>
		<td class="text-right"><?php echo h($payroll['Payroll']['saving']); ?>&nbsp;</td>
		<td class="text-right"><?php echo h($payroll['Payroll']['bonus']); ?>&nbsp;</td>
		<td class="text-right"><?php echo h($payroll['Payroll']['advance']); ?>&nbsp;</td>
		<td class="text-right"><big><b><?php echo h($payroll['Payroll']['totaldue']); ?>&nbsp;</b></big></td>
		<td><?php echo h($payroll['Payroll']['bank']); ?>&nbsp;</td>
		<td><?php echo h($payroll['Payroll']['chknumber']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $payroll['Payroll']['id']),array('class'=>'btn btn-sm btn-primary')); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
