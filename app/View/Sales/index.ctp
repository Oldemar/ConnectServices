<div class="sales index">
	<h2><?php echo __('Sales'); ?></h2>
	<table class="table table-bordered table-hover">
	<tr>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('customer_id'); ?></th>
			<th><?php echo $this->Paginator->sort('sales_date'); ?></th>
			<th><?php echo $this->Paginator->sort('comissioned'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($sales as $sale): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($sale['User']['username'], array('controller' => 'users', 'action' => 'view', $sale['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($sale['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $sale['Customer']['id'])); ?>
		</td>
		<td><?php echo h($sale['Sale']['sales_date']); ?>&nbsp;</td>
		<td><?php echo h($sale['Sale']['comissioned']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $sale['Sale']['id']), array('class'=>'btn btn-sm btn-success')); ?>
			<?php 
			if (!$sale['Sale']['comissioned'])
				{
					echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $sale['Sale']['id']), array('class'=>'btn btn-sm btn-danger'), __('Are you sure you want to delete # %s?', $sale['Sale']['id']));
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
