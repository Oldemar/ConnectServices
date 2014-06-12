<?php
//echo '<pre>'.print_r($comissions,true).'</pre>';
?>
<div class="comissions index">
	<h2><?php echo __('Comissions'); ?><?php echo $this->Html->link(__('New comission'), array('action' => 'add'),array('class'=>'btn btn-info pull-right','style'=>'color:black;font-weight:bold')); ?></h2>
	<table class="table table-bordered table-hover">
	<tr>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('region'); ?></th>
			<th><?php echo $this->Paginator->sort('comission'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($comissions as $comission): ?>
	<tr>
		<td><?php echo h($comission['Comission']['name']); ?>&nbsp;</td>
		<td><?php echo h($comission['Comission']['user_id']); ?>&nbsp;</td>
		<td><?php echo h($comission['Comission']['region']); ?>&nbsp;</td>
		<td><?php echo h($comission['Comission']['comission']); ?>&nbsp;</td>
		<td><?php echo h($comission['Comission']['created']); ?>&nbsp;</td>
		<td><?php echo h($comission['Comission']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $comission['Comission']['id']), array('class'=>'btn btn-sm btn-success')); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $comission['Comission']['id']), array('class'=>'btn btn-sm btn-primary')); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $comission['Comission']['id']), array('class'=>'btn btn-sm btn-danger'), __('Are you sure you want to delete # %s?', $comission['Comission']['id'])); ?>
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
