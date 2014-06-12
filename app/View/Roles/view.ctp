<div class="roles view">
<h2><?php echo __('Role'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($role['Role']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($role['Role']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($role['Role']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($role['Role']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<?php 
if (!in_array($role['Role']['id'], array('1','2','8'))) 
{
	echo $this->Html->link(__('List'), array('action' => 'index'),array('class'=>'btn btn-sm btn-success')). ' ';
	echo $this->Html->link(__('Edit'), array('action' => 'edit', $role['Role']['id']),array('class'=>'btn btn-sm btn-primary')). ' '; 
	echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $role['Role']['id']),array('class'=>'btn btn-sm btn-danger'), __('Are you sure you want to delete # %s?', $role['Role']['id']));			
}
?>
<div class="related">
	<h3><?php echo __('Related Users'); ?></h3>
	<?php if (!empty($role['User'])): ?>
	<table class="table table-bordered table-hover">
	<tr>
		<th><?php echo __('Username'); ?></th>
		<th><?php echo __('Email'); ?></th>
		<th><?php echo __('Active'); ?></th>
		<th><?php echo __('Online'); ?></th>
		<th><?php echo __('Address1'); ?></th>
		<th><?php echo __('Address2'); ?></th>
		<th><?php echo __('City'); ?></th>
		<th><?php echo __('State'); ?></th>
		<th><?php echo __('Zipcode'); ?></th>
		<th><?php echo __('Homephone'); ?></th>
		<th><?php echo __('Cellphone'); ?></th>
		<th><?php echo __('Workphone'); ?></th>
		<th><?php echo __('Lastlogin'); ?></th>
	</tr>
	<?php foreach ($role['User'] as $user): ?>
		<tr>
			<td><?php echo $user['username']; ?></td>
			<td><?php echo $user['email']; ?></td>
			<td><?php echo $user['active']; ?></td>
			<td><?php echo $user['online']; ?></td>
			<td><?php echo $user['address1']; ?></td>
			<td><?php echo $user['address2']; ?></td>
			<td><?php echo $user['city']; ?></td>
			<td><?php echo $user['state']; ?></td>
			<td><?php echo $user['zipcode']; ?></td>
			<td><?php echo $user['homephone']; ?></td>
			<td><?php echo $user['cellphone']; ?></td>
			<td><?php echo $user['workphone']; ?></td>
			<td><?php echo $user['lastlogin']; ?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
