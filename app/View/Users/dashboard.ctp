<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<div class="row">
	<?php
	if (!in_array($objLoggedUser->getAttr('role_id'), array('9', '7','13')))
	{
	?>
	<div class="col-xs-12 col-sm-12">
		<div class="well" id="salesChart"></div>
	</div>
	<?php } ?>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-6">
		<div class="well" id="userAgenda">
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
	if ($objLoggedUser->getAttr('role_id') != '7') 
	{
	?>
	<div class="col-xs-12 col-sm-6">
		<div class="well" id="lastSale">
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
	<?php } ?>
</div>
<script type="text/javascript">
	var chart;
	$(document).ready(function() {
	    chart1 = new Highcharts.Chart({
	        chart: {
	            renderTo: 'salesChart',
	            type: "line",
	            events: {
	            	load: reqData
	            }
	        },
	        title: {
	            text: 'Sales',
	            x: -20 //center
	        },
	        subtitle: { 
	            text: '(Last 6 Months)',
	            x: -20
	        },
	        xAxis: {
	            categories:  []
	        },
	        yAxis: {
	            title: {
	                text: 'S A L E S (#)'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        tooltip: {
	            // valueSuffix: '°C'
	        },

	        series: [
	        	{
	        		name: "Not Comissioned",
	        		data: []
	        	},
	        	{
	        		name: "Comissioned",
	        		data: []
	        	},
	        	{
	        		name: "Charged Back",
	        		data: []
	        	}
	        ]
	    });
	});
	function reqData(){
		$.ajax({
			url: "<?php echo Router::url(array('controller'=>'graphics','action'=>'getsales')); ?>",
			dataType: 'json'
		}).done(function(data) {
			arrCat = data['arrCat'];
			chart1.xAxis[0].setCategories(arrCat,true,true);
			chart1.series[0].setData(data[0].data,false,true);
			chart1.series[1].setData(data[1].data,false,true);
			chart1.series[2].setData(data[2].data,false,true);
			chart1.redraw();
		});
	}
</script>