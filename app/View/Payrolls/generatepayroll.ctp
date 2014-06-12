<?php
//echo '<pre>'.print_r($salesByUsers,true).'</pre>';
?>
<table class="table table-bordered table-hover">
	<tr>
		<td></td>
<?php
$group = null;
$line1 = $line2 = '';
foreach ($services as $key1 => $service) 
{
	if ($service['Service']['group'] != $group) 
	{
		$group = $service['Service']['group'];
		$line1 .= '<td class="text-center" colspan="2"><b>'.$this->Html->link($service['Service']['group'],'#',array('id'=>$service['Service']['group'])).'</b></td>';
		$line2 .= '<td class="text-center">Qt</td><td class="text-center">$</td>';
	}
	$line1 .= '<td colspan="2" class="detail'.$service['Service']['group'].'" style="display:none"><b>'.$service['Service']['name'].'</b></td>';
	$line2 .= '<td class="text-center detail'.$service['Service']['group'].'" style="display:none">Qt</td><td class="text-center detail'.$service['Service']['group'].'" style="display:none">$</td>';
}
echo $line1;
?>	
		<td class="text-right" style="background-color: #ccc"><b>Comission</b></td>
	</tr>
	<tr>
		<td></td>
		<?php echo $line2 ?>
		<td style="background-color: #ccc"></td>
	</tr>
	
<?php
foreach ($salesByUsers as $key2 => $sale) 
{
	echo '<tr><td>'.$sale['User']['username'].'</td>';
	foreach ($services as $key3 => $service) 
	{
		if ($service['Service']['group'] != $group) 
			{
			$group = $service['Service']['group'];
			echo '
			<td class="text-center"><b>'.$sale['Total']['Qty'][$service['Service']['group']].'</b></td>
			<td class="text-right"><b>'.CakeNumber::currency($sale['Total']['Val'][$service['Service']['group']],'USD').'</td>';
		}
		echo '<td class="detail'.$service['Service']['group'].'" style="display:none">'.$sale['Total']['Qty'][$service['Service']['name']].'</td><td class="detail'.$service['Service']['group'].'" style="display:none">'.CakeNumber::currency($sale['Total']['Val'][$service['Service']['name']],'USD').'</td>';
	}
	echo '<td class="text-right" style="background-color: #ccc"><b>'.CakeNumber::currency($sale['Payroll']['comission'],'USD').'</b></td></tr>';
}
?>
</table>
	<script type="text/javascript">
		$('#TV').click(function(e){
			e.preventDefault();
			$('.detailTV').toggle();
			$('.detailINTERNET').css('display','none');
			$('.detailPHONE').css('display','none');
			$('.detailXFINITY_HOME').css('display','none');
		});
		$('#INTERNET').click(function(e){ 
			e.preventDefault();
			$('.detailTV').css('display','none');
			$('.detailINTERNET').toggle();
			$('.detailPHONE').css('display','none');
			$('.detailXFINITY_HOME').css('display','none');
		});
		$('#PHONE').click(function(e){ 
			e.preventDefault();
			$('.detailTV').css('display','none');
			$('.detailINTERNET').css('display','none');
			$('.detailPHONE').toggle();
			$('.detailXFINITY_HOME').css('display','none');
		});
		$('#XFINITY_HOME').click(function(e){ 
			e.preventDefault();
			$('.detailTV').css('display','none');
			$('.detailINTERNET').css('display','none');
			$('.detailPHONE').css('display','none');
			$('.detailXFINITY_HOME').toggle();
		});
		$('#EXTRAS').click(function(e){ 
			e.preventDefault();
			$('.detailTV').css('display','none');
			$('.detailINTERNET').css('display','none');
			$('.detailPHONE').css('display','none');
			$('.detailXFINITY_HOME').css('display','none');
		});
	</script>
<div class="text-center dispBtn" style="padding-bottom:30px;display:block">
	<?php echo $this->Html->link(__('Generate'), '#', array('class'=>'btn btn-lg btn-primary','id'=>'genPayRoll')); ?></li>
</div>
<div class="text-center dispBtn" style="padding-bottom:30px;display:none">
	<?php echo $this->Html->link(__('Back'), array('controller'=>'sales' ,'action'=>'listsales'), array('class'=>'btn btn-lg btn-primary')); ?></li>
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

