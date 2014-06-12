	<table class="table table-bordered table-hover">
	<tr>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('customer_id'); ?></th>
			<th><?php echo $this->Paginator->sort('tv'); ?></th>
			<th><?php echo $this->Paginator->sort('internet'); ?></th>
			<th><?php echo $this->Paginator->sort('phone'); ?></th>
			<th><?php echo $this->Paginator->sort('homeSecurity'); ?></th>
			<th><?php echo $this->Paginator->sort('sales_date'); ?></th>
			<th><?php echo $this->Paginator->sort('instalation'); ?></th>
			<th><?php echo __('Installed'); ?></th>
	</tr>
	<?php foreach ($sales as $sale): ?>
	<tr>
		<td>
			<?php echo $this->Html->link($sale['User']['username'], array('controller' => 'users', 'action' => 'view', $sale['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($sale['Customer']['name'], array('controller' => 'customers', 'action' => 'view', $sale['Customer']['id'])); ?>
		</td>
		<td><?php echo h($sale['Sale']['tv']); ?>&nbsp;</td>
		<td><?php echo h($sale['Sale']['internet']); ?>&nbsp;</td>
		<td><?php echo h($sale['Sale']['phone']); ?>&nbsp;</td>
		<td><?php echo h($sale['Sale']['homeSecurity']); ?>&nbsp;</td>
		<td><?php echo CakeTime::format($sale['Sale']['sales_date'], '%B %e, %Y '); ?>&nbsp;</td>
		<td><?php if ($sale['Sale']['instalation'] != '0000-00-00 00:00:00') echo CakeTime::format($sale['Sale']['instalation'], '%B %e, %Y '); ?>&nbsp;</td>
		<td>
			<?php
				if ($sale['Sale']['installed'])
				{
					echo $this->Html->link('Yes','#', array('class'=>'btnYes btn btn-sm btn-success','data-sid'=>$sale['Sale']['id']));
				}
				else
				{
					echo $this->Html->link('No','#', array('class'=>'btnNo btn btn-sm btn-danger','data-sid'=>$sale['Sale']['id']));
				}
			?>
		</td>
	</tr>
	<?php endforeach; ?>
	</table>
			<script type="text/javascript">
				$('.btnNo').click(function(e){
				$.ajax({
					url: "<? echo Router::url(array('controller'=>'sales','action'=>'updateInstalled')); ?>",
					type : "post",
					dataType: "Json",
					data: { 
						region: $('#region').val(), 
						start: $('#startDate').val(), 
						end: $('#endDate').val(),
						sid: $(this).attr('data-sid'),
						installed: '1'
					}
				}).done(function(html){
					$("#salesList").html(html);
				}).fail(function(){
					alert('ERROR - Plese Contact the Developer');
				});
					e.preventDefault();
				});
				$('.btnYes').click(function(e){
				$.ajax({
					url: "<? echo Router::url(array('controller'=>'sales','action'=>'updateInstalled')); ?>",
					type : "post",
					dataType: "Json",
					data: { 
						region: $('#region').val(), 
						start: $('#startDate').val(), 
						end: $('#endDate').val(),
						sid: $(this).attr('data-sid'),
						installed: '0'
					}
				}).done(function(html){
					$("#salesList").html(html);
				});
				e.preventDefault();
				});
			</script>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
