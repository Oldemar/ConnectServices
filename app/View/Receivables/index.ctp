<div>
	<h2><?php echo __('Receivables'); ?></h2>
	<table class="table table-condensed table-hover table-bordered">
	<tr>
		<th>Region</th>
		<th>Started in</th>
		<th>Ended in</th>
		<th>Cable TV</th>
		<th>Internet</th>
		<th>Phone</th>
		<th>xF Home</th>
		<th>Extras</th>
		<th> </th>
	</tr>
	<?php foreach ($receivables as $receivable): ?>
	<tr>
		<td><?php echo h($receivable['Receivable']['region']); ?>&nbsp;</td>
		<td><?php echo CakeTime::format($receivable['Receivable']['start'], '%B %e, %Y'); ?>&nbsp;</td>
		<td><?php echo CakeTime::format($receivable['Receivable']['end'], '%B %e, %Y'); ?>&nbsp;</td>
		<td>Basic = <?php echo h($receivable['Receivable']['basic']); ?><br>
		Economy = <?php echo h($receivable['Receivable']['economytv']); ?><br>
		Starter = <?php echo h($receivable['Receivable']['starter']); ?><br>
		Prefered = <?php echo h($receivable['Receivable']['preferred']); ?><br>
		Premier = <?php echo h($receivable['Receivable']['premier']); ?><br></td>
		<td>Economy = <?php echo h($receivable['Receivable']['economynet']); ?><br>
		Performance = <?php echo h($receivable['Receivable']['performancenet']); ?><br>
		Blast = <?php echo h($receivable['Receivable']['blastnet']); ?><br>
		Extreme = <?php echo h($receivable['Receivable']['extremenet']); ?><br></td>
		<td>Local = <?php echo h($receivable['Receivable']['localphone']); ?><br>
		Unlimited = <?php echo h($receivable['Receivable']['unlimitedphone']); ?><br></td>
		<td>XF300 = <?php echo h($receivable['Receivable']['xh300']); ?><br>
		XF 350 = <?php echo h($receivable['Receivable']['xh350']); ?><br>
		XF 100 = <?php echo h($receivable['Receivable']['xh100']); ?><br>
		XF 150 = <?php echo h($receivable['Receivable']['xh150']); ?><br></td>
		<td>Globo = <?php echo h($receivable['Receivable']['globo']); ?><br>
		PFC = <?php echo h($receivable['Receivable']['pfc']); ?><br>
		Record = <?php echo h($receivable['Receivable']['record']); ?><br></td>
		<td>
			<p>
		<?php 
			echo $this->Html->link(__('Edit'), array('controller'=>'receivables','action' => 'edit', $receivable['Receivable']['id']),array('class'=>'btn btn-sm btn-success')); 
		?>
			</p>
			<p>
		<?php 
			if (!$receivable['Receivable']['processed'])
			echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $receivable['Receivable']['id']), array('class'=>'btn btn-sm btn-danger'), __('Are you sure you want to delete # %s?', $receivable['Receivable']['id']));
		?>
			</p>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
</div>
