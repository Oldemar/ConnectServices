<div class="row">
	<?php
	if (!in_array($objLoggedUser->getAttr('role_id'), array('9', '7')))
	{
	?>
	<div class=" well col-lg-6">
		<div id="salesChart"></div>
	</div>
	<?php } ?>
	<div class="well col-lg-6">
		<div id="userAgenda">
			<h4 style="border-bottom: 1px dotted #666">Agenda</h4>
			<?php
			foreach ($nextEvents as $key => $event) {
			?>
			<div class="row">
				<div class="col-lg-12">
				<?php
				echo CakeTime::format($event['Event']['start'], '%B %e, %Y %H:%M %p');
				?>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
				<?php
				echo $event['Event']['title'];
				?>
				</div>
			</div>
			<div class="row" style="border-bottom: 1px dotted #666">
				<div class="col-lg-12">
				<?php
				echo $event['Event']['details'];
				?>
				</div>
			</div>
			<?php
			}
			?>
		</div>
	</div>
	<?php
	if (!in_array($objLoggedUser->getAttr('role_id'), array('9', '7')))
	{
	?>
</div>
<div class="row">
	<?php 
	} 
	if ($objLoggedUser->getAttr('role_id') != '7') 
	{
	?>
	<div class="well col-lg-6">
		<div id="lastSale">
			<h4>Latest Sales</h4>
			<?php
			if (isset($latestSales) && !empty($latestSales)) {
				foreach ($latestSales as $key => $sale) {
					?>
			<div style="border-bottom: 1px dotted #666">
					<?php
					echo $sale['Customer']['name'].'<br>';
					echo CakeTime::format($sale['Sale']['sales_date'], '%B %e, %Y %H:%M %p').'<br>';
					echo $sale['Sale']['tv'].' - ';
					echo $sale['Sale']['internet'].' - ';
					echo $sale['Sale']['phone'].'<br>';
					echo 'Sale made by <b>'.$sale['User']['username'].'</b>';
					?>
			</div>
					<?php
				}
			}
			else
			{
				echo 'No sales..';
			}
			?>
		</div>
	</div>
	<?php
	}
	if (!in_array($objLoggedUser->getAttr('role_id'), array('9', '7')))
	{
	?>
	</div>
	<div class="well col-lg-6">
		<?php
		echo 'Top Leader => <b>'.$objLoggedUser->getUsername($myTopLeader).'</b><hr>';
		echo 'My Team Leaser => <b>'.$objLoggedUser->getUsername($myLeader).'</b>';
		?>
	</div>
	<?php } ?>
</div>
<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
  function drawChart() {
    var data1 = google.visualization.arrayToDataTable([
    	<?php
    	if ($objLoggedUser->getAttr('role_id') == 6) {
	 		$arrRow = "['Day', 'Total'],";
	 		$totSales = 0;
	    	foreach ($salesByUsersTest[0]['Sales'] as $key => $sale) {
	    		$totSales += $sale[0]['total'];
	    		$arrRow .= '[ \''.CakeTime::format($today, "%b").' '.$sale[0]['day'].' ('.$sale[0]['total'].')\', '.$totSales.'],';
	    	}
	    }
	    if ($objLoggedUser->getAttr('role_id') == '5')
	    {
	 		$arrRow = "['Sales Rep', 'Sales'],";
	    	foreach ($salesByUsersTest as $key => $sale) {
	    		$arrRow .= '[ \''.$sale['User']['username'].'\', '.$sale['Totals']['myTotal'].'],';
	    	}
		}
	    if ( in_array($objLoggedUser->getAttr('role_id'),array('2', '4')))
		
		{
	 		$arrRow = "['Team/Sales Rep', 'Sales'],";
	    	foreach ($salesByUsersTest as $key => $sale) {
	    		switch ($sale['User']['role_id'])
	    		{
	    			case '4':
	    				$tmpTot = $sale['User']['id'] == $objLoggedUser->getID() ? $sale['Totals']['myTotal'] : $sale['Totals']['franTotal']+$sale['Totals']['myTotal'];
	    				$arrRow .= '[ \''.$sale['User']['username'].'\', '.$tmpTot.'],';
    					break;
    				case '5':
	    				$tmpTot = $sale['Totals']['teamTotal']+$sale['Totals']['myTotal'];
	    				$arrRow .= '[ \''.$sale['User']['username'].'\', '.$tmpTot.'],';
    					break;
    				case '6':
	    				$arrRow .= '[ \''.$sale['User']['username'].'\', '.$sale['Totals']['myTotal'].'],';
    					break;

    			}
	    	}
		}

    	$arrRow = substr($arrRow,0,strlen($arrRow)-1);
    	echo $arrRow;

    	?>
    ]);

    	<?php
    	if ($objLoggedUser->getAttr('role_id') == 6) {
		?>
    var options1 = {
      title: 'Monthly Sales Chart (<?php echo CakeTime::format($today, "%B") ?>)',
      legend: { position: 'bottom' }
    };
    var chart = new google.visualization.LineChart(document.getElementById('salesChart'));
    chart.draw(data1, options1);
    	<?php } else { ?>
    var options1 = {
      title: 'Monthly Team Sales Chart (<?php echo CakeTime::format($today, "%B") ?>)',
      legend: { position: 'bottom' }
    };
    var chart = new google.visualization.PieChart(document.getElementById('salesChart'));
    chart.draw(data1, options1);
    	<?php } ?>
  }
</script>
