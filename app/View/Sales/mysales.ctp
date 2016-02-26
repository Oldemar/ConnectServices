<script src="http://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>

<div class="sales index">
	<h2><?php echo __('My Sales'); ?></h2>
	<div class="row" style="padding-bottom: 15px">
		<div class="col-lg-1">
		</div>
		<div class="col-lg-6" style="padding:5px; border: 1px solid #ccc; border-radius: 10px">
			<div class="row">
				<div class="col-lg-1">
					<h5><b>From</b></h5>
				</div>
				<div class="col-lg-5">
				<?php
					echo $this->Form2->input('start', array(
						'type'=>'text',
						'class'=>'form-control srcInput',
						'id'=>'startDate',
						'label'=>false,
						'div'=>false
						));
				?>
				</div>
				<div class="col-lg-1">
					<h5><b>To</b></h5>
				</div>
				<div class="col-lg-5">
				<?php
					echo $this->Form2->input('end', array(
						'type'=>'text',
						'id'=>'endDate',
						'class'=>'form-control srcInput',
						'label'=>false,
						'div'=>false
						));
				?>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			$( "#startDate" ).datepicker({
				dateformat: 'yy-mm-dd',
				onClose: function( selectedDate ) {
					$( "#endDate" ).datepicker( "option", "minDate", selectedDate );
				}
			});
			$( "#endDate" ).datepicker({
				dateformat: 'yy-mm-dd',
				onClose: function( selectedDate ) {
					$( "#startDate" ).datepicker( "option", "maxDate", selectedDate );
				}
			});
			$('.srcInput').change(function(e){

				drawSalesTable();
				e.preventDefault();
			});
			
			function drawSalesTable() {
				varUserInfo = $('#userInfo');
				varCustomerInfo = $('#customerInfo');
				varSaleInfo = $('#saleInfo');
				td = "";
				$('#previewPayrollTable').hide();
				$('#salesTable').empty()
				var salesTable = $('#salesTable').show().DataTable({
					'destroy': true,
					'ajax': 
						{
							'url': "<?php echo Router::url(array('controller'=>'sales','action'=>'mysalesJSON')); ?>",
							'type' : "POST",
							'dataType': 'json',
							'data': 
								{ 
									start: $('#startDate').val(), 
									end: $('#endDate').val()
								}
						},
					'columns':
						[
							{
								"data": "Customer.name",
								"title": "Customer",
								'className':'customer'
							},
							{
								"data": "Customer.cellphone",
								"title": "Customer Phone",
								'className':'customer'
							},
							{
								"data": "Sale",
								"title": "Services",
								"render": function(data)
								{
									var varReturn = "";
									if (data.tv != 'Not Purchased') varReturn = 'TV';
									if (data.internet != 'Not Purchased') {
										if (varReturn.length > 0) varReturn += ", ";
										varReturn += 'INTERNET';
									}
									if (data.phone != 'Not Purchased') {
										if (varReturn.length > 0) varReturn += ", ";
										varReturn += 'PHONE';
									}
									if (data.xfinity_home != 'Not Purchased') {
										if (varReturn.length > 0) varReturn += ", ";
										varReturn += 'XFINITY HOME';
									}

									return varReturn;
								},
								'className': 'services'
							},
							{
								"data": "Sale.sales_date",
								'title': 'Sales Date'
							},
							{
								"data": "Sale.instalation",
								"title": 'Instalation Date'
							},
							{
								"data": "Sale",
								'title': 'Actions',
								'className': 'test',
								"render": function(data)
								{
									return "<a href=<?php echo Router::url(array('controller'=>'sales','action'=>'edit')); ?>/"+data.id+'" class="btn btn-sm btn-danger">Edit</a>';
								}
							}
						]						
				});
			};

	  	</script>
	</div>
	<div>
		<table id="salesTable" class="table table-bordered table-striped table-hover data-table">
			<thead>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
	<div id="salesList">
	</div>

</div>
