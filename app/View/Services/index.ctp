<div class="services index">
	<h2><?php echo __('Services'); ?></h2>
	<table class="table table-condensed table-hover table-bordered">
	<tr>
			<th><?php echo $this->Paginator->sort('region_id'); ?></th>
			<th><?php echo $this->Paginator->sort('group'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('sfu_in'); ?></th>
			<th><?php echo $this->Paginator->sort('sfu_out'); ?></th>
			<th><?php echo $this->Paginator->sort('mdu_in'); ?></th>
			<th><?php echo $this->Paginator->sort('mdu_out'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($services as $service): ?>
	<tr>
		<td><?php echo h($service['Region']['name']); ?>&nbsp;</td>
		<td><?php echo h($service['Service']['group']); ?>&nbsp;</td>
		<td><?php echo h($service['Service']['name']); ?>&nbsp;</td>
		<td><?php echo h($service['Service']['description']); ?>&nbsp;</td>
		<td><?php echo h($service['Service']['sfu_in']); ?>&nbsp;</td>
		<td><?php echo h($service['Service']['sfu_out']); ?>&nbsp;</td>
		<td><?php echo h($service['Service']['mdu_in']); ?>&nbsp;</td>
		<td><?php echo h($service['Service']['mdu_out']); ?>&nbsp;</td>
		<td class="actions">
			<?php
				echo $this->Html->link(__('View'), array('action' => 'view', $service['Service']['id']), array('class'=>'btn btn-sm btn-success')); ?>
			<?php
				echo $this->Html->link(__('Edit'), array('action' => 'edit', $service['Service']['id']), array('class'=>'btn btn-sm btn-primary')); ?>
			<?php
				echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $service['Service']['id']), array('class'=>'btn btn-sm btn-danger'), __('Are you sure you want to delete # %s?', $service['Service']['id'])); 
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
