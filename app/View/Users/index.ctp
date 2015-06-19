<div>
	<h2 style="padding: 10px 0">
		<?php echo __('Users'); ?>
		<?php echo $this->Html->link(__('New User'), array('action' => 'add'),array('class'=>'btn btn-lg btn-success pull-right')); ?>
	</h2>
	<table class="table table-condensed table-hover table-bordered">
	<tr>
			<th><?php echo $this->Paginator->sort('username'); ?></th>
			<th><?php echo $this->Paginator->sort('email'); ?></th>
			<th><?php echo $this->Paginator->sort('region_id'); ?></th>
			<th><?php echo $this->Paginator->sort('cellphone'); ?></th>
			<th><?php echo $this->Paginator->sort('role_id'); ?></th>
			<th><?php echo $this->Paginator->sort('lastlogin'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($users as $user): ?>
	<tr>
		<td><?php echo h($user['User']['username']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
		<td><?php echo h($user['Region']['name']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['cellphone']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($user['Role']['name'], array('controller' => 'roles', 'action' => 'view', $user['Role']['id'])); ?>
		</td>
		<td><?php echo h($user['User']['lastlogin']); ?>&nbsp;</td>
		<td class="actions">
			<?php
				if (!in_array($user['User']['role_id'], array('1','2','8')))
					echo $this->Html->link(__('View'), array('action' => 'view', $user['User']['id']), array('class'=>'btn btn-sm btn-success')); ?>
			<?php
				if (!in_array($user['User']['role_id'], array('1','2','8')))
					echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id']), array('class'=>'btn btn-sm btn-primary')); ?>
			<?php
				if (!in_array($user['User']['role_id'], array('1','2','8')))
					echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $user['User']['id']), array('class'=>'btn btn-sm btn-danger'), __('Are you sure you want to delete # %s?', $user['User']['id'])); 
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
