<div class="advances index">
	<h2><?php echo __('Advances'); ?>
	<?php
		echo $this->Html->link('New Advance',array('action'=>'add'),array('class'=>'btn btn-md btn-info pull-right','style'=>'color: black; font-weight: bold'));
	?>
	</h2>
	<table class="table table-bordered table-hover">
	<tr>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('value'); ?></th>
			<th><?php echo $this->Paginator->sort('balance'); ?></th>
			<th><?php echo $this->Paginator->sort('advdate'); ?></th>
			<th><?php echo $this->Paginator->sort('bank'); ?></th>
			<th><?php echo $this->Paginator->sort('chknumber'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($advances as $advance): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($advance['User']['username'], array('controller' => 'users', 'action' => 'view', $advance['User']['id'])); ?>
		</td>
		<td><?php echo h($advance['Advance']['value']); ?>&nbsp;</td>
		<td><?php echo h($advance['Advance']['balance']); ?>&nbsp;</td>
		<td><?php echo h($advance['Advance']['advdate']); ?>&nbsp;</td>
		<td><?php echo h($advance['Advance']['bank']); ?>&nbsp;</td>
		<td><?php echo h($advance['Advance']['chknumber']); ?>&nbsp;</td>
		<td><?php echo h($advance['Advance']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $advance['Advance']['id']), array('class'=>'btn btn-sm btn-success')); ?>
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
