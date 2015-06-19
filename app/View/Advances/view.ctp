<div class="advances view">
<h2><?php echo __('Advance'); ?></h2>
	<dl>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($advance['User']['username'], array('controller' => 'users', 'action' => 'view', $advance['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sale'); ?></dt>
		<dd>
			<?php echo $this->Html->link($advance['Sale']['id'], array('controller' => 'sales', 'action' => 'view', $advance['Sale']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Value'); ?></dt>
		<dd>
			<?php echo h($advance['Advance']['value']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Advdate'); ?></dt>
		<dd>
			<?php echo h($advance['Advance']['advdate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Received'); ?></dt>
		<dd>
			<?php echo h($advance['Advance']['received']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Bank'); ?></dt>
		<dd>
			<?php echo h($advance['Advance']['bank']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Chknumber'); ?></dt>
		<dd>
			<?php echo h($advance['Advance']['chknumber']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($advance['Advance']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($advance['Advance']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Advance'), array('action' => 'edit', $advance['Advance']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Advance'), array('action' => 'delete', $advance['Advance']['id']), null, __('Are you sure you want to delete # %s?', $advance['Advance']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Advances'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Advance'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Sales'), array('controller' => 'sales', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sale'), array('controller' => 'sales', 'action' => 'add')); ?> </li>
	</ul>
</div>
