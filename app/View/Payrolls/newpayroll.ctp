<?
//echo '<pre>'.print_r($salesByUsers,true).'</pre>';
?>
<table class="table table-condensed table-hover table-bordered">
	<tr>
		<td></td>
		<? 
		echo '<td colspan="2">'. $this->Html->link('Cable TV','#', array('id'=>'cableTV')).'</td>';
		foreach ($tvServices as $key => $serv) {
			echo '<td colspan="2" class="cableTV" style="background-color: #aaaccc; text-align: center; display: none">'.$serv.'</td>'; 
		}
		echo '<td colspan="2">'. $this->Html->link('Internet','#', array('id'=>'internet')).'</td>';
		foreach ($netServices as $key => $serv) {
			echo '<td colspan="2" class="internet" style="background-color: #444bbb; text-align: center; display: none">'.$serv.'</td>'; 
		}
		echo '<td colspan="2">'. $this->Html->link('Phone','#', array('id'=>'phone')).'</td>';
		foreach ($phServices as $key => $serv) {
			echo '<td colspan="2" class="phone" style="background-color: #ccc666; text-align: center; display: none">'.$serv.'</td>'; 
		}
		echo '<td colspan="2"">'. $this->Html->link('xFinity Home','#', array('id'=>'xHome')).'</td>';
		foreach ($xhServices as $key => $serv) {
			echo '<td colspan="2" class="xHome" style="background-color: #111ddd; text-align: center; display: none">'.$serv.'</td>'; 
		}
		?>
		<td style="text-align: right; background-color: #999; color: #fff"><b>Comission</b></td>
		<td style="text-align: right; background-color: #999; color: #fff"><b>Bonus</b></td>
		<td style="text-align: right; background-color: #999; color: #fff"><b>Savings</b></td>
		<td style="text-align: right; background-color: #999; color: darkblue"><b>Due Payroll</b></td>
	</tr>
	<script type="text/javascript">
		$('#cableTV').click(function(e){ e.preventDefault();$('.cableTV').toggle();});
		$('#internet').click(function(){ $('.internet').toggle();});
		$('#phone').click(function(){ $('.phone').toggle();});
		$('#xHome').click(function(){ $('.xHome').toggle();});
	</script>
	<tr>
		<td></td>
		<?
		echo '<td style="text-align: center;">Sales</td><td style="text-align: center;">Comiss</td>';
		foreach ($arrTotTvSales as $key => $totSale) {
			echo '<td class="cableTV" style="text-align: center; display: none">Sales</td><td class="cableTV" style="text-align: right; display: none">Comiss</td>';
		}
		echo '<td style="text-align: center;">Sales</td><td style="text-align: center;">Comiss</td>';
		foreach ($arrTotNetSales as $key => $totSale) {
			echo '<td class="internet" style="text-align: center; display: none">Sales</td><td class="internet" style="text-align: right; display: none">Comiss</td>';
		}
		echo '<td style="text-align: center;">Sales</td><td style="text-align: center;">Comiss</td>';
		foreach ($arrTotPhSales as $key => $totSale) {
			echo '<td class="phone" style="text-align: center; display: none">Sales</td><td class="phone" style="text-align: right; display: none">Comiss</td>';
		}
		echo '<td style="text-align: center;">Sales</td><td style="text-align: center;">Comiss</td>';
		foreach ($arrTotXhSales as $key => $totSale) {
			echo '<td class="xHome" style="text-align: center; display: none">Sales</td><td class="xHome" style="text-align: right; display: none">Comiss</td>';
		}
		?>
		<td style="text-align: right; background-color: #666; color: #fff"></td>
		<td style="text-align: right; background-color: #666; color: #fff"></td>
		<td style="text-align: right; background-color: #666; color: #fff"></td>
		<td style="text-align: right; background-color: #666; color: #fff"></td>
	</tr>
	<tr style="background-color: #ddd; text-align: center">
		<td>Totals</td>
		<?
		echo '<td>'. $arrTotTvSalesByTopLeader['qtd'] .'</td>';
		echo '<td style="text-align: right;"">'. CakeNumber::currency($arrTotTvSalesByTopLeader['val'],'USD') .'</td>';
		foreach ($arrTotTvSales as $key => $totSale) {
			echo '<td class="cableTV" style="text-align: center; display: none">'.$totSale.'</td><td class="cableTV" style="text-align: right; display: none">'. CakeNumber::currency($receivable['Receivable'][$key],'USD').'</td>';
		}
		echo '<td>'. $arrTotNetSalesByTopLeader['qtd'] .'</td>';
		echo '<td style="text-align: right;"">'. CakeNumber::currency($arrTotNetSalesByTopLeader['val'],'USD') .'</td>';
		foreach ($arrTotNetSales as $key => $totSale) {
			echo '<td class="internet" style="text-align: center; display: none">'.$totSale.'</td><td class="internet" style="text-align: right; display: none">'. CakeNumber::currency($receivable['Receivable'][$key],'USD').'</td>';
		}
		echo '<td>'. $arrTotPhSalesByTopLeader['qtd'] .'</td>';
		echo '<td style="text-align: right;"">'. CakeNumber::currency($arrTotPhSalesByTopLeader['val'],'USD') .'</td>';
		foreach ($arrTotPhSales as $key => $totSale) {
			echo '<td class="phone" style="text-align: center; display: none">'.$totSale.'</td><td class="phone" style="text-align: right; display: none">'. CakeNumber::currency($receivable['Receivable'][$key],'USD').'</td>';
		}
		echo '<td>'. $arrTotXhSalesByTopLeader['qtd'] .'</td>';
		echo '<td style="text-align: right;"">'. CakeNumber::currency($arrTotXhSalesByTopLeader['val'],'USD') .'</td>';
		foreach ($arrTotXhSales as $key => $totSale) {
			echo '<td class="xHome" style="text-align: center; display: none">'.$totSale.'</td><td class="xHome" style="text-align: right; display: none">'. CakeNumber::currency($receivable['Receivable'][$key],'USD').'</td>';
		}
		?>
		<td style="text-align: right; background-color: #666; color: #fff"></td>
		<td style="text-align: right; background-color: #666; color: #fff"></td>
		<td style="text-align: right; background-color: #666; color: #fff"></td>
		<td style="text-align: right; background-color: #666; color: #fff"></td>
	</tr>
	<?
	foreach ($salesByUsers as $userinfo) {
		if ( isset($userinfo['User']) && 
			($userinfo['User']['role_id'] != '2' && $userinfo['User']['topleader'] == $objLoggedUser->getID()) ) 
		{
	?>
	<tr>
		<td><?php echo $userinfo['User']['username'] ?></td>
			<? 
			echo '<td style="text-align: center;">'. $userinfo['Totals']['tv'] .'</td>';
			echo '<td style="text-align: right;">'. CakeNumber::currency($userinfo['Totals']['valtv'],'USD'). '</td>';
			foreach ($tvServices as $key => $value) 
			{
				if ($userinfo['User']['role_id'] == '4')
				{
					echo  '
					<td class="cableTV" style="text-align: center; display: none">'. $userinfo['Totals'][$key]['Fransh']['qtd'] . '</td> 
					<td class="cableTV" style="text-align: right; display: none">'. CakeNumber::currency($userinfo['Totals'][$key]['Fransh']['val'],'USD'). '</td>';

				}
				else
				{
					echo  '
					<td class="cableTV" style="text-align: center; display: none">'. $userinfo['Totals'][$key]['qtd'] . '</td> 
					<td class="cableTV" style="text-align: right; display: none">'. CakeNumber::currency($userinfo['Totals'][$key]['val'],'USD'). '</td>';

				}
			}
			echo '<td style="text-align: center;">'. $userinfo['Totals']['net'] .'</td>';
			echo '<td style="text-align: right;">'. CakeNumber::currency($userinfo['Totals']['valnet'],'USD'). '</td>';
			foreach ($netServices as $key => $value) 
			{
				if ($userinfo['User']['role_id'] == '4')
				{
					echo  '
					<td class="internet" style="text-align: center; display: none">'. $userinfo['Totals'][$key]['Fransh']['qtd'] . '</td> 
					<td class="internet" style="text-align: right; display: none">'. CakeNumber::currency($userinfo['Totals'][$key]['Fransh']['val'],'USD'). '</td>';

				}
				else
				{
					echo  '
					<td class="internet" style="text-align: center; display: none">'. $userinfo['Totals'][$key]['qtd'] . '</td> 
					<td class="internet" style="text-align: right; display: none">'. CakeNumber::currency($userinfo['Totals'][$key]['val'],'USD'). '</td>';

				}
			}
			echo '<td style="text-align: center;">'. $userinfo['Totals']['ph'] .'</td>';
			echo '<td style="text-align: right;">'. CakeNumber::currency($userinfo['Totals']['valph'],'USD'). '</td>';
			foreach ($phServices as $key => $value) 
			{
				if ($userinfo['User']['role_id'] == '4')
				{
					echo  '
					<td class="phone" style="text-align: center; display: none">'. $userinfo['Totals'][$key]['Fransh']['qtd'] . '</td> 
					<td class="phone" style="text-align: right; display: none">'. CakeNumber::currency($userinfo['Totals'][$key]['Fransh']['val'],'USD'). '</td>';

				}
				else
				{
					echo  '
					<td class="phone" style="text-align: center; display: none">'. $userinfo['Totals'][$key]['qtd'] . '</td> 
					<td class="phone" style="text-align: right; display: none">'. CakeNumber::currency($userinfo['Totals'][$key]['val'],'USD'). '</td>';
				}
			}
			echo '<td style="text-align: center;">'. $userinfo['Totals']['xh'] .'</td>';
			echo '<td style="text-align: right;">'. CakeNumber::currency($userinfo['Totals']['valxh'],'USD'). '</td>';
			foreach ($xhServices as $key => $value) 
			{
				if ($userinfo['User']['role_id'] == '4')
				{
					echo  '
					<td class="xHome" style="text-align: center; display: none">'. $userinfo['Totals'][$key]['Fransh']['qtd'] . '</td> 
					<td class="xHome" style="text-align: right; display: none">'. CakeNumber::currency($userinfo['Totals'][$key]['Fransh']['val'],'USD'). '</td>';

				}
				else
				{
					echo  '
					<td class="xHome" style="text-align: center; display: none">'. $userinfo['Totals'][$key]['qtd'] . '</td> 
					<td class="xHome" style="text-align: right; display: none">'. CakeNumber::currency($userinfo['Totals'][$key]['val'],'USD'). '</td>';
				}
			}
			echo '<td style="text-align: right; background-color: #666; color: #fff"><b>'. CakeNumber::currency($userinfo['Total'],'USD'). '</b></td>';
			echo '<td style="text-align: right; background-color: #666; color: #fff"><b>'. CakeNumber::currency($userinfo['Bonus'],'USD'). '</b></td>';
			echo '<td style="text-align: right; background-color: #666; color: #fff"><b>'. CakeNumber::currency($userinfo['Savings'],'USD'). '</b></td>';
			echo '<td style="text-align: right; background-color: #666; color: darkblue"><b>'. CakeNumber::currency($userinfo['Due'],'USD'). '</b></td>';
		}
		?>
	</tr>
	<?
	}
	?>
</table>
<div class="text-center dispBtn" style="padding-bottom:30px;display:block">
	<?php echo $this->Html->link(__('Generate'), '#', array('class'=>'btn btn-lg btn-primary','id'=>'genPayRoll')); ?></li>
</div>
<div class="text-center dispBtn" style="padding-bottom:30px;display:none">
	<?php echo $this->Html->link(__('Back'), array('action'=>'listreceivables'), array('class'=>'btn btn-lg btn-primary')); ?></li>
</div>
<script type="text/javascript">
	$('#genPayRoll').click(function(e){
		if (confirm('Are you sure you want to generate this PayRoll?\nPress OK'))
		{
			$.ajax({
				type : "POST",
				url : "<?php echo $this->Html->url(array('action'=>'generate')); ?>",
				data : <? echo json_encode($salesByUsers); ?>

			}).always(function(){
				$('.dispBtn').toggle();
				alert("PayRoll generated sucessfully...\nPress OK");
			})
		}
		e.preventDefault();
	})
</script>
