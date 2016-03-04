<div class="posts index">
	<h2 style="padding: 10px 0">
		<?php echo __('Posts'); ?>
		<?php echo $this->Html->link(__('New Post'), array('action' => 'add'),array('class'=>'btn btn-md btn-success pull-right')); ?>
	</h2>
	<table class="table table-hover table-bordered">
	<tr>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('image'); ?></th>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('body'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($posts as $post): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($post['User']['username'], array('controller' => 'users', 'action' => 'view', $post['User']['id'])); ?>
		</td>
		<td><?php echo $this->Html->image($post['Post']['image'],array('width'=>'80')); ?>&nbsp;</td>
		<td><?php echo h($post['Post']['title']); ?>&nbsp;</td>
		<td style="max-width: 475px;"><?php echo substr(h($post['Post']['body']),0,500); ?>&nbsp;</td>
		<td><?php echo h($post['Post']['created']); ?>&nbsp;</td>
		<td><?php echo h($post['Post']['modified']); ?>&nbsp;</td>
		<td class="actions" style="min-width: 175px">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $post['Post']['id']), array('class'=>'btn btn-sm btn-primary')); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $post['Post']['id']), array('class'=>'btn btn-sm btn-success')); ?>
			<?php 
				echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $post['Post']['id']), array('class'=>'btn btn-sm btn-danger'), __('Are you sure you want to delete # %s?', $post['Post']['id']));
			?>
		</td>
	</tr>
	<?php endforeach; ?>
	</table>
	<div class="pagination pagination-large">
	    <ul class="pagination">
	    <?php
	        echo $this->Paginator->prev(__('Previous'), array('tag' => 'li'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
	        echo $this->Paginator->numbers(array('separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li','first' => 1));
	        echo $this->Paginator->next(__('Next'), array('tag' => 'li','currentClass' => 'disabled'), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a'));
	    ?>
	    </ul>
	</div>
</div>
