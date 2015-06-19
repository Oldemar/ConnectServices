<div class="carriers index">
	<h2><?php echo __('Carriers'); ?><?php echo $this->Html->link(__('New Carrier'), array('action' => 'add'),array('class'=>'btn btn-info pull-right','style'=>'color:black;font-weight:bold')); ?></h2>
	<table class="tale table-bordered table-hover">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('suffix'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($carriers as $carrier): ?>
	<tr>
		<td><?php echo h($carrier['Carrier']['id']); ?>&nbsp;</td>
		<td><?php echo h($carrier['Carrier']['name']); ?>&nbsp;</td>
		<td><?php echo h($carrier['Carrier']['suffix']); ?>&nbsp;</td>
		<td><?php echo h($carrier['Carrier']['created']); ?>&nbsp;</td>
		<td><?php echo h($carrier['Carrier']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $carrier['Carrier']['id']), array('class'=>'btn btn-sm btn-success')); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $carrier['Carrier']['id']), array('class'=>'btn btn-sm btn-primary')); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $carrier['Carrier']['id']), array('class'=>'btn btn-sm btn-danger'), __('Are you sure you want to delete # %s?', $carrier['Carrier']['id'])); ?>
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
