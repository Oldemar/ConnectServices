<div class="applicants index">
	<h2><?php echo __('Applicants'); ?></h2>
	<table class="table table-condensed table-hover table-bordered">
	<tr>
			<th><?php echo $this->Paginator->sort('Manager'); ?></th>
			<th><?php echo $this->Paginator->sort('fullname'); ?></th>
			<th><?php echo $this->Paginator->sort('email'); ?></th>
			<th><?php echo $this->Paginator->sort('facebook'); ?></th>
			<th><?php echo $this->Paginator->sort('instagram'); ?></th>
			<th><?php echo $this->Paginator->sort('othersocialmedia'); ?></th>
			<th><?php echo $this->Paginator->sort('city'); ?></th>
			<th><?php echo $this->Paginator->sort('cellphone'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($applicants as $applicant): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($applicant['User']['username'], array('controller' => 'users', 'action' => 'view', $applicant['User']['id'])); ?>
		</td>
		<td><?php echo h($applicant['Applicant']['fullname']); ?>&nbsp;</td>
		<td><?php echo h($applicant['Applicant']['email']); ?>&nbsp;</td>
		<td><?php echo h($applicant['Applicant']['facebook']); ?>&nbsp;</td>
		<td><?php echo h($applicant['Applicant']['instagram']); ?>&nbsp;</td>
		<td><?php echo h($applicant['Applicant']['othersocialmedia']); ?>&nbsp;</td>
		<td><?php echo h($applicant['Applicant']['city']); ?>&nbsp;</td>
		<td><?php echo h($applicant['Applicant']['cellphone']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $applicant['Applicant']['id']),array('class'=>'btn btn-xs btn-success')); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $applicant['Applicant']['id']),array('class'=>'btn btn-xs btn-primary')); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $applicant['Applicant']['id']), array('class'=>'btn btn-xs btn-danger'), __('Are you sure you want to delete # %s?', $applicant['Applicant']['id'])); ?>
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
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Applicant'), array('action' => 'add')); ?></li>
	</ul>
</div>
