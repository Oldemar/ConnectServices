<div class="advances view">
<h2><?php echo __('Advance'); ?></h2>
	<dl>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($advance['User']['username'], array('controller' => 'users', 'action' => 'view', $advance['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Value'); ?></dt>
		<dd>
			<?php echo h($advance['Advance']['value']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Balance'); ?></dt>
		<dd>
			<?php echo h($advance['Advance']['balance']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Advdate'); ?></dt>
		<dd>
			<?php echo h($advance['Advance']['advdate']); ?>
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
<div class="row">
	<div class="col-xs-3 col-sm-1">
		<?php 
			echo $this->Html->link(__('Edit'), array('action' => 'edit', $advance['Advance']['id']), array('class'=>'btn btn-md btn-primary'));
		?>
	</div>
</div>
