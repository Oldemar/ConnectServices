<div class="customers index">
	<h2><?php echo __('Customers'); ?>
	<?php
		echo $this->Html->link('New Customer',array('action'=>'add'),array('class'=>'btn btn-lg btn-info pull-right','style'=>'color: black; font-weight: bold'));
	?>
	</h2>
	<table class="table table-bordered table-hover">
	<tr>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('email'); ?></th>
			<th><?php echo $this->Paginator->sort('address1'); ?></th>
			<th><?php echo $this->Paginator->sort('address2'); ?></th>
			<th><?php echo $this->Paginator->sort('city'); ?></th>
			<th><?php echo $this->Paginator->sort('state'); ?></th>
			<th><?php echo $this->Paginator->sort('zipcode'); ?></th>
			<th><?php echo $this->Paginator->sort('cellphone'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($customers as $customer): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($customer['User']['username'], array('controller' => 'users', 'action' => 'view', $customer['User']['id'])); ?>
		</td>
		<td><?php echo h($customer['Customer']['name']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['email']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['address1']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['address2']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['city']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['state']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['zipcode']); ?>&nbsp;</td>
		<td><?php echo h($customer['Customer']['cellphone']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $customer['Customer']['id']), array('class'=>'btn btn-sm btn-success')); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $customer['Customer']['id']), array('class'=>'btn btn-sm btn-primary')); ?>

			<?php 
				if ( in_array($objLoggedUser->getAttr('role_id'),array('1', '2', '8', '9')) )
				{

					echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $customer['Customer']['id']), array('class'=>'btn btn-sm btn-danger'), __('Are you sure you want to delete # %s?', $customer['Customer']['id'])); 
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
