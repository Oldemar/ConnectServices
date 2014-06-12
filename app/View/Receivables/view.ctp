<div class="receivables view">
<h2><?php echo __('Receivable'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($receivable['Receivable']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Recdate'); ?></dt>
		<dd>
			<?php echo h($receivable['Receivable']['recdate']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Basic'); ?></dt>
		<dd>
			<?php echo h($receivable['Receivable']['basic']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Economytv'); ?></dt>
		<dd>
			<?php echo h($receivable['Receivable']['economytv']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Starter'); ?></dt>
		<dd>
			<?php echo h($receivable['Receivable']['starter']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Preferred'); ?></dt>
		<dd>
			<?php echo h($receivable['Receivable']['preferred']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Premier'); ?></dt>
		<dd>
			<?php echo h($receivable['Receivable']['premier']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Economynet'); ?></dt>
		<dd>
			<?php echo h($receivable['Receivable']['economynet']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Performancenet'); ?></dt>
		<dd>
			<?php echo h($receivable['Receivable']['performancenet']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Blastnet'); ?></dt>
		<dd>
			<?php echo h($receivable['Receivable']['blastnet']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Extremenet'); ?></dt>
		<dd>
			<?php echo h($receivable['Receivable']['extremenet']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Localphone'); ?></dt>
		<dd>
			<?php echo h($receivable['Receivable']['localphone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Unlimitedphone'); ?></dt>
		<dd>
			<?php echo h($receivable['Receivable']['unlimitedphone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Xh300'); ?></dt>
		<dd>
			<?php echo h($receivable['Receivable']['xh300']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Xh350'); ?></dt>
		<dd>
			<?php echo h($receivable['Receivable']['xh350']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Xh100'); ?></dt>
		<dd>
			<?php echo h($receivable['Receivable']['xh100']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Xh150'); ?></dt>
		<dd>
			<?php echo h($receivable['Receivable']['xh150']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($receivable['Receivable']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($receivable['Receivable']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Receivable'), array('action' => 'edit', $receivable['Receivable']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Receivable'), array('action' => 'delete', $receivable['Receivable']['id']), null, __('Are you sure you want to delete # %s?', $receivable['Receivable']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Receivables'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Receivable'), array('action' => 'add')); ?> </li>
	</ul>
</div>
