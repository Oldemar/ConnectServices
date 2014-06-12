<div class="carriers view">
<h2><?php echo __('Carrier'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($carrier['Carrier']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($carrier['Carrier']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Suffix'); ?></dt>
		<dd>
			<?php echo h($carrier['Carrier']['suffix']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($carrier['Carrier']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($carrier['Carrier']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
	<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $carrier['Carrier']['id']), array('class'=>'btn btn-lg btn-primary')); ?>
</div>
