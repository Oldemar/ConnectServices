<div class="services view">
<h2><?php echo __('Service'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($service['Service']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Group'); ?></dt>
		<dd>
			<?php echo h($service['Service']['group']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($service['Service']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($service['Service']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Price'); ?></dt>
		<dd>
			<?php echo h($service['Service']['price']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($service['Service']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($service['Service']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Service'), array('action' => 'edit', $service['Service']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Service'), array('action' => 'delete', $service['Service']['id']), null, __('Are you sure you want to delete # %s?', $service['Service']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Services'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Service'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Saleservices'), array('controller' => 'saleservices', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Saleservice'), array('controller' => 'saleservices', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Saleservices'); ?></h3>
	<?php if (!empty($service['Saleservice'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Sale Id'); ?></th>
		<th><?php echo __('Service Id'); ?></th>
		<th><?php echo __('Installed'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($service['Saleservice'] as $saleservice): ?>
		<tr>
			<td><?php echo $saleservice['id']; ?></td>
			<td><?php echo $saleservice['sale_id']; ?></td>
			<td><?php echo $saleservice['service_id']; ?></td>
			<td><?php echo $saleservice['installed']; ?></td>
			<td><?php echo $saleservice['created']; ?></td>
			<td><?php echo $saleservice['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'saleservices', 'action' => 'view', $saleservice['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'saleservices', 'action' => 'edit', $saleservice['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'saleservices', 'action' => 'delete', $saleservice['id']), null, __('Are you sure you want to delete # %s?', $saleservice['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Saleservice'), array('controller' => 'saleservices', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
