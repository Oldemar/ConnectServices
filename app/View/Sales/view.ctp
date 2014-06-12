<div class="sales view">
<h2><?php echo __('Sale'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($sale['Sale']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($sale['User']['username'], array('controller' => 'users', 'action' => 'view', $sale['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Customer'); ?></dt>
		<dd>
			<?php echo $this->Html->link($sale['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $sale['Customer']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tv'); ?></dt>
		<dd>
			<?php echo h($sale['Sale']['tv']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Internet'); ?></dt>
		<dd>
			<?php echo h($sale['Sale']['internet']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Phone'); ?></dt>
		<dd>
			<?php echo h($sale['Sale']['phone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('HomeSecurity'); ?></dt>
		<dd>
			<?php echo h($sale['Sale']['homeSecurity']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Extras'); ?></dt>
		<dd>
			<?php echo h($sale['Sale']['extras']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sales Date'); ?></dt>
		<dd>
			<?php echo h($sale['Sale']['sales_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comissioned'); ?></dt>
		<dd>
			<?php echo h($sale['Sale']['comissioned']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($sale['Sale']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($sale['Sale']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Sale'), array('action' => 'edit', $sale['Sale']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Sale'), array('action' => 'delete', $sale['Sale']['id']), null, __('Are you sure you want to delete # %s?', $sale['Sale']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Sales'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sale'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Customers'), array('controller' => 'customers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Customer'), array('controller' => 'customers', 'action' => 'add')); ?> </li>
	</ul>
</div>
