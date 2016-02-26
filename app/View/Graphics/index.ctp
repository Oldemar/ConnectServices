<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<div class="graphics-wrap">

	<!-- Nav tabs -->
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active">
			<a href="#sales" aria-controls="sales" role="tab" data-toggle="tab">
				Sales Growph
			</a>
		</li>
		<li role="presentation">
			<a href="#salesByRep" aria-controls="salesByRep" role="tab" data-toggle="tab">
				Sales By Rep
			</a>
		</li>
		<li role="presentation">
			<a href="#salesByRegion" aria-controls="salesByRegion" role="tab" data-toggle="tab">
				Sales By Region
			</a>
		</li>
	</ul>

	<!-- Tab panes -->
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane fade in active" id="sales" style="padding: 10px">
			<div class="well" id="salesGraph">
			</div>
		</div>
		<div role="tabpanel" class="tab-pane fade" id="salesByRep">
			<div class="well">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="SalesByRepGraph">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4 col-sm-2">
					<button type="button" class="btn-md btn-primary" id="btnRegion1"></button>
				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane fade" id="salesByRegion">
			<div class="well" id="SalesByRegionGraph">
			</div>
		</div>
	</div>

</div>
<script type="text/javascript">
	var chart1,chart2,chart3,chart4;
	var arrCat, arrSeries;
	var arrMonth = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];

	$(document).ready(function() {
	    chart1 = new Highcharts.Chart({
	        chart: {
	            renderTo: 'salesGraph',
	            type: "line",
	            events: {
	            	load: reqData1
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
	            categories:  arrMonth
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
		chart2 = new Highcharts.Chart({
	        chart: {
	        	renderTo: 'SalesByRepGraph',
	            plotBackgroundColor: null,
	            plotBorderWidth: null,
	            plotShadow: false,
	            type: 'pie',
	            events: {
	            	load: reqData2
	            }
	        },
	        title: {
	            text: 'Sales'
	        },
	        subtitle: {
	        	text: '{series.name}: <b>{point.y}</b>'
	        },
	        tooltip: {
	            pointFormat: '{series.name}: <b>{point.y}</b>'
	        },
	        plotOptions: {
	            pie: {
	                allowPointSelect: true,
	                cursor: 'pointer',
	                dataLabels: {
	                    enabled: true,
	                    format: '<b>{point.name}</b>: {point.y}',
	                    style: {
	                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
	                    }
	                }
	            }
	        },
	        series: [{
	            name: 'Brands',
	            colorByPoint: true,
	            data: [
						<?php
					    foreach ($salesByUsers as $key => $userSales) {
					       	if ( count( $userSales['Sale'] ) != 0 ) {
					       		echo "{ 'name': '".$userSales['User']['fullname']."', y: ".count( $userSales['Sale'] )." },\n";
					       	}
						}
					    ?>
					]
		        }
			]
		});

		chart3 = new Highcharts.Chart({
	        chart: {
	        	renderTo: 'SalesByRegionGraph',
	            type: 'column',
	            events: {
	            	load: reqData3
	            }
	        },
	        title: {
	            text: 'Monthly Sales By Region'
	        },
	        subtitle: {
	        	text: ''
	        },
	        xAxis: {
	            categories: arrCat,
	            crosshair: true
	        },
	        yAxis: {
	            min: 0,
	            title: {
	                text: 'Sales (#)'
	            }
	        },
	        tooltip: {
	            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
	            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
	                '<td style="padding:0"><b>{point.y}</b></td></tr>',
	            footerFormat: '</table>',
	            shared: true,
	            useHTML: true
	        },
	        plotOptions: {
	            column: {
	                pointPadding: 0.2,
	                borderWidth: 0
	            }
	        },
	        series: []

		});
		function reqData1() {
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

		function reqData2() {

		}

		function reqData3(){
			$.ajax({
				url: "<?php echo Router::url(array('controller'=>'graphics','action'=>'getsalesbyregion')); ?>",
				dataType: 'json'
			}).done(function(data) {
//				arrCat = data['arrCat'];
				chart3.xAxis[0].setCategories(arrCat,true,true);
				arrSeries = data['series'];
				$.each( arrSeries,function(i,val){
					chart3.addSeries({
						'name': val['name'],
						'data': val['data']
					});
				});
				chart3.redraw();
			});
		}

	});
</script>