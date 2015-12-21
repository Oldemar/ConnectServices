<div class="applicants view">
<h2><?php echo __('Applicant'); ?></h2>
	<dl>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($applicant['User']['username'], array('controller' => 'users', 'action' => 'view', $applicant['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fullname'); ?></dt>
		<dd>
			<?php echo h($applicant['Applicant']['fullname']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($applicant['Applicant']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Facebook'); ?></dt>
		<dd>
			<?php echo h($applicant['Applicant']['facebook']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Instagram'); ?></dt>
		<dd>
			<?php echo h($applicant['Applicant']['instagram']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Othersocialmedia'); ?></dt>
		<dd>
			<?php echo h($applicant['Applicant']['othersocialmedia']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address1'); ?></dt>
		<dd>
			<?php echo h($applicant['Applicant']['address1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Address2'); ?></dt>
		<dd>
			<?php echo h($applicant['Applicant']['address2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('City'); ?></dt>
		<dd>
			<?php echo h($applicant['Applicant']['city']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('State'); ?></dt>
		<dd>
			<?php echo h($applicant['Applicant']['state']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Zipcode'); ?></dt>
		<dd>
			<?php echo h($applicant['Applicant']['zipcode']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cellphone'); ?></dt>
		<dd>
			<?php echo h($applicant['Applicant']['cellphone']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Notes'); ?></dt>
		<dd>
			<?php echo h($applicant['Applicant']['notes']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($applicant['Applicant']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($applicant['Applicant']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
