<div class="roles index">
	<h2><?php echo __('Roles'); ?><?php echo $this->Html->link(__('New Role'), array('action' => 'add'),array('class'=>'btn btn-info pull-right','style'=>'color:black;font-weight:bold')); ?></h2>
	<table class="table table-bordered table-hover">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($roles as $role): ?>
	<tr>
		<td><?php echo h($role['Role']['id']); ?>&nbsp;</td>
		<td><?php echo h($role['Role']['name']); ?>&nbsp;</td>
		<td><?php echo h($role['Role']['description']); ?>&nbsp;</td>
		<td><?php echo h($role['Role']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php 
			if (!in_array($role['Role']['id'], array('1','2','8'))) 
			{
				echo $this->Html->link(__('View'), array('action' => 'view', $role['Role']['id']),array('class'=>'btn btn-sm btn-success')). ' ';
				echo $this->Html->link(__('Edit'), array('action' => 'edit', $role['Role']['id']),array('class'=>'btn btn-sm btn-primary')). ' '; 
				//echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $role['Role']['id']),array('class'=>'btn btn-sm btn-danger'), __('Are you sure you want to delete # %s?', $role['Role']['id']));			
			}
			?>
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
