<div class="savings index">
	<h2><?php echo __('Savings'); ?></h2>
	<table class="table table-bordered table-hover">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('savingdate'); ?></th>
			<th><?php echo $this->Paginator->sort('saving'); ?></th>
			<th><?php echo $this->Paginator->sort('balance'); ?></th>
	</tr>
	<?php foreach ($savings as $saving): ?>
	<tr>
		<td><?php echo h($saving['Saving']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($saving['User']['username'], array('controller' => 'users', 'action' => 'view', $saving['User']['id'])); ?>
		</td>
		<td><?php echo h($saving['Saving']['savingdate']); ?>&nbsp;</td>
		<td><?php echo h($saving['Saving']['saving']); ?>&nbsp;</td>
		<td><b><?php echo h($saving['Saving']['balance']); ?>&nbsp;</b></td>
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
