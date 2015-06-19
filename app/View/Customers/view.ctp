<div class="customers view">
<h2><?php echo __('Customer'); ?></h2>
	<dl>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($customer['User']['username'], array('controller' => 'users', 'action' => 'view', $customer['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address1'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['address1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address2'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['address2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('State'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['state']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Zipcode'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['zipcode']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Homephone'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['homephone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cellphone'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['cellphone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Carrier'); ?></dt>
		<dd>
			<?php 
				if (in_array($objLoggedUser->getAttr('role_id'), array('1', '2', '8', '9'))) 
				{
					echo $this->Html->link($customer['Carrier']['name'], array('controller' => 'carriers', 'action' => 'view', $customer['Carrier']['id'])); 
				}
				else
				{
					echo h($customer['Carrier']['name']);
				}
				?>
			&nbsp;
		</dd>
		<dt><?php echo __('Workphone'); ?></dt>
		<dd>
			<?php echo h($customer['Customer']['workphone']); ?>
			&nbsp;
		</dd>
	</dl>
	<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $customer['Customer']['id']), array('class'=>'btn btn-lg btn-primary')); ?>
</div>
