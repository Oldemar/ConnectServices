<script src="http://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>

<div class="sales index">
	<h2><?php echo __('Comissioned Sales'); ?></h2>
	<div class="row" style="padding-bottom: 15px">
		<div class="col-lg-4" style="padding: 5px; ">
			<div style="padding: 5px; border: 1px solid #ccc; border-radius: 10px">
				<div class="row">
					<div class="col-lg-4">
						<h5><b>Region:</b></h5>
					</div>
					<div class="col-lg-8">
					<?php
						echo $this->Form2->input('region_id', array(
							'empty'=>'Choose a region',
							'label'=>false,
							'div'=>false,
							'id'=>'regionID',
							'class'=>'form-control srcInput'
							));
					?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-5" style="padding:5px;">
			<div style="padding: 5px; border: 1px solid #ccc; border-radius: 10px">
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
		</div>
		<div class="col-lg-3" style="padding:5px;">
			<div style="padding: 5px; border: 1px solid #ccc; border-radius: 10px">
				<div class="row">
					<div class="col-lg-4">
						<h5><b>User:</b></h5>
					</div>
					<div class="col-lg-8">
					<?php
						echo $this->Form2->input('user_id', array(
							'empty'=>'All Users',
							'label'=>false,
							'div'=>false,
							'id'=>'userID',
							'class'=>'form-control srcInput'
							));
					?>
					</div>
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
							'url': "<?php echo Router::url(array('controller'=>'sales','action'=>'chargebackJSON')); ?>",
							'type' : "POST",
							'dataType': 'json',
							'data': 
								{ 
									region: $('#regionID').val(), 
									start: $('#startDate').val(), 
									end: $('#endDate').val(),
									userID: $('#userID').val()
								}
						},
					'columns':
						[
							{
								"data": "User.username",
								"title": "Sales Rep",
								"className": "salesRep"
							},
							{
								"data": "Customer.name",
								"title": "Customer",
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
								"data": "Sale.accnumber",
								'title': 'Account #'
							},
							{
								"data": "Sale.comission",
								"title": 'Comission'
							},
							{
								"data": "Sale",
								'title': 'Charge Back ?',
								'className': 'chargeback',
								"render": function(data)
								{
									return data.chargeback == '0' ? '<button type="button" id="noChgBck'+data.id+'" class="btn btn-sm btn-danger text-center">No</button>': '<button type="button" id="yesChgBck'+data.id+'" class="btn btn-sm btn-success text-center">Yes</button>';
								}
							}
						]						
				});
			    $('#salesTable tbody').on('click','td.chargeback',function(){
			        var tr = $(this).closest('tr');
			        var row = salesTable.row( tr );
			        changeChargebackStatus(row.data());
			    });

			};
			function changeChargebackStatus(dI) {
				var dIChargeback = (dI.Sale.chargeback == '1' ? '0' : '1');
				$.ajax({
					url: "<?php echo Router::url(array('controller'=>'sales','action'=>'updatechargeback')); ?>",
					type : "POST",
					data: { 
						'sid': dI.Sale.id, 
						'chargeback': dIChargeback,
					}
				}).done(function(arrReturn){
					if (dI.Sale.chargeback == '1') {
				    	$('#yesChgBck'+dI.Sale.id).removeClass('btn-success').addClass('btn-danger').html('No').removeAttr('id').attr('id','noChgBck'+dI.Sale.id);
					} else {
				    	$('#noChgBck'+dI.Sale.id).removeClass('btn-danger').addClass('btn-success').html('Yes').removeAttr('id').attr('id','yesChgBck'+dI.Sale.id);
					}					
					dI.Sale.chargeback = dIChargeback;
				});
			}

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
