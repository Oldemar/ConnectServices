<?php
//	echo '<pre>'.print_r($servicesPrices,true).'</pre>';
?>
<script src="http://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
	<div class="row" id="payrollHeader">
		<div class="col-lg-6">
			<h2>Not comissioned Sales</h2>
		</div>
		<div class="col-lg-6 text-right" id="previewLink">
		<?php
			echo $this->Form2->button('Preview', array(
					'type'=>'button',
					'class'=>'btn btn-lg btn-primary btnVisible',
					'style'=>'color: black; font-weigth:bold',
					'id'=>'btnPreview'
				));

			echo $this->Form2->button('Back', array(
					'type'=>'button',
					'class'=>'btn btn-lg btn-primary btnVisible',
					'style'=>'color: black; font-weigth:bold',
					'id'=>'btnBack',
					'style'=>'display: none'
				));
		?>
		</div>
	</div>

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
				maxDate: 0,
				onClose: function( selectedDate ) {
					$( "#endDate" ).datepicker("option", "minDate", selectedDate )
				}
			});
			$( "#endDate" ).datepicker({
				dateformat: 'yy-mm-dd',
				maxDate: 0,
				onClose: function( selectedDate ) {
					$( "#startDate" ).datepicker( "option", "maxDate", selectedDate );
				}
			});
			$('.srcInput').change(function(e){
				$('#btnPreview').show();
				$('#btnBack').hide();
				listSales();
				e.preventDefault();
			});
			$('#btnBack').click(function(e){
				$('.btnVisible').toggle();
				listSales();
				e.preventDefault();
			});
			$('#btnPreview').click(function(e){
				var varTable = $('#salesTable').DataTable();
					varTable.destroy();
				$('#salesTable').empty();
				$('.btnVisible').toggle();
				$('salesTable').hide();
				$('#previewPayrollTable').show();
				var payrollTable = $('#previewPayrollTable').DataTable({
					'destroy': true,
					'empty': true,
					'ajax': 
						{
							'url': "<?php echo Router::url(array('controller'=>'payrolls','action'=>'previewpayrollAJAX')); ?>",
							'type': 'POST',
							'dataType': 'json',

							'data': 
								{ 
									'regionID': $('#regionID').val(), 
									'start': $('#startDate').val(), 
									'end': $('#endDate').val(),
									'userID': $('#userID').val()
								}
						},
					'columns':
						[
							{'data':'name'},
							{'data':'SFU-IN.Total'},
							{'data':'SFU-OUT.Total'},
							{'data':'MDU-IN.Total'},
							{'data':'MDU-OUT.Total'}
						]
				});
				e.preventDefault();
			});
			function listSales() {
				varUserInfo = $('#userInfo');
				varCustomerInfo = $('#customerInfo');
				varSaleInfo = $('#saleInfo');
				td = "";
				$('#previewPayrollTable').hide();
				$('#salesTable').empty()
				var salesTable = $('#salesTable').show().DataTable({
					'destroy': true,
					'empty': true,
					'ajax': 
						{
							'url': "<?php echo Router::url(array('controller'=>'payrolls','action'=>'listsalesAJAX')); ?>",
							'type' : "POST",
							'dataType': 'json',
							'data': 
								{ 
									regionID: $('#regionID').val(), 
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
								"data": "Sale.sales_date",
								'title': 'Sales Date'
							},
							{
								"data": "Sale.notes",
								'title': "Notes",
								"width": "150px"
							},
							{
								"data": "Sale.instalation",
								"title": 'Instalation Date'
							},
							{
								"data": "Sale",
								'title': 'Installed?',
								'className': 'test',
								"render": function(data)
								{
									return data.installed == '0' ? '<button type="button" id="noInst'+data.id+'" class="btn btn-sm btn-danger">No</button>': '<button type="button" id="yesInst'+data.id+'" class="btn btn-sm btn-success">Yes</button>';
								}
							}
						]						
				});
			    $('#salesTable tbody').on('click', 'td.salesRep', function () {
			        var tr = $(this).closest('tr');
			        var row1 = salesTable.row( tr );
			        if ( row1.child.isShown() ) {
			            row1.child.hide();
			            tr.removeClass('shown');
			            if (tr.context.classList[0] != td) {
				            row1.child( formatSalesRep(row1.data()) ).show();
				            tr.addClass('shown');
			            }
			        } else {
			            row1.child( formatSalesRep(row1.data()) ).show();
			            tr.addClass('shown');
			        }
			    	td = 'salesRep';
			    } );
			    $('#salesTable tbody').on('click', 'td.customer', function () {
			        var tr = $(this).closest('tr');
			        var row2 = salesTable.row( tr );
			        if ( row2.child.isShown() ) {
			            row2.child.hide();
			            tr.removeClass('shown');
			            if (tr.context.classList[0] != td) {
				            row2.child( formatCustomer(row2.data()) ).show();
				            tr.addClass('shown');
			            }
			        } else {
			            row2.child( formatCustomer(row2.data()) ).show();
			            tr.addClass('shown');
			        }
			    	td = 'customer';
			    } );
			    $('#salesTable tbody').on('click', 'td.services', function () {
			        var tr = $(this).closest('tr');
			        var row3 = salesTable.row( tr );
			        if ( row3.child.isShown() ) {
			            row3.child.hide();
			            tr.removeClass('shown');
			            if (tr.context.classList[0] != td) {
				            row3.child( formatServices(row3.data()) ).show();
				            tr.addClass('shown');
			            }
			        } else {
			            row3.child( formatServices(row3.data()) ).show();
			            tr.addClass('shown');
			        }
			    	td = 'services';
			    } );
			    $('#salesTable tbody').on('click','td.test',function(){
			        var trI = $(this).closest('tr');
			        var rowI = salesTable.row( trI );
			        changeInstallStatus(rowI.data());
			    });
			};
			function changeInstallStatus(dI) {
				var dIInstalled = (dI.Sale.installed == '1' ? '0' : '1');
				$.ajax({
					url: "<?php echo Router::url(array('controller'=>'sales','action'=>'updateInstalled')); ?>",
					type : "POST",
					data: { 
						'sid': dI.Sale.id, 
						'installed': dIInstalled,
					}
				}).done(function(arrReturn){
					if (dI.Sale.installed == '1') {
				    	$('#yesInst'+dI.Sale.id).removeClass('btn-success').addClass('btn-danger').html('No').removeAttr('id').attr('id','noInst'+dI.Sale.id);
					} else {
				    	$('#noInst'+dI.Sale.id).removeClass('btn-danger').addClass('btn-success').html('Yes').removeAttr('id').attr('id','yesInst'+dI.Sale.id);
					}					
					dI.Sale.installed = dIInstalled;
				});
			}
			function formatSalesRep(d) {
				varUserInfo.find('#comission').html(d.User.comission)
				varUserInfo.find('#bonus').html(d.User.bonus)
				varUserInfo.find('#savings').html(d.User.savings)
				varUserInfo.find('#fullname').html(d.User.fullname)
				varUserInfo.find('#email').html(d.User.email)
				varUserInfo.find('#cellphone').html(d.User.cellphone)
				varUserInfo.find('#phones').html(d.User.homephone + '/'+d.User.workphone)
				varUserInfo.find('#lastLogin').html(d.User.lastlogin)
				return varUserInfo;
			}
			function formatCustomer(d) {
				varCustomerInfo.find('#address1').html(d.Customer.address1+', '+d.Customer.address2)
				varCustomerInfo.find('#city').html(d.Customer.city)
				varCustomerInfo.find('#statezip').html(d.Customer.state+' - '+d.Customer.zipcode)
				varCustomerInfo.find('#email').html(d.Customer.email)
				varCustomerInfo.find('#cellphone').html(d.Customer.customeCellphone)
				varCustomerInfo.find('#workphone').html(d.Customer.workphone)
				varCustomerInfo.find('#homephone').html(d.Customer.homephone)
				varCustomerInfo.find('#chargeBack').html(d.Customer.chargeBack)
				return varCustomerInfo;
			}
			function formatServices(d) {
				varSaleInfo.find('#category').html(d.Sale.category)
				varSaleInfo.find('#jobnumber').html(d.Sale.jobnumber)
				varSaleInfo.find('#accnumber').html(d.Sale.accnumber)
				varSaleInfo.find('#tv').html(d.Sale.tv)
				varSaleInfo.find('#internet').html(d.Sale.internet)
				varSaleInfo.find('#phone').html(d.Sale.phone)
				varSaleInfo.find('#xfinity_home').html(d.Sale.xfinity_home)
				varSaleInfo.find('#extras').html('TBD')
				return varSaleInfo;
			}
	  	</script>
	</div>
		<table id="salesTable" class="table table-bordered table-hover" style="display: none">
	        <thead>
	            <tr>
	                <th>Sales Rep</th>
	                <th>Customer</th>
	                <th>Services</th>
	                <th>Sales Date</th>
	                <th>Notes</th>
	                <th>Instalation date</th>
	                <th>Installed</th>
	            </tr>
	        </thead>
	    </table>
	    <table id="previewPayrollTable" class="table table-bordered table-hover" style="display: none">
	        <thead>
	            <tr>
	                <th>Sales Rep</th>
	                <th>SFU_IN</th>
	                <th>SFU-OUT</th>
	                <th>MDU-IN</th>
	                <th>MDU-OUT</th>
	                <th>Sub Total</th>
	                <th>Bonus</th>
	                <th>Advances</th>
	                <th>Total Due</th>
	            </tr>
	        </thead>
	    </table>
   	</div>


   	<div style="display: none">
   		<div id="userInfo" class="well">
	   		<div class="row">
	   			<div class="col-lg-12">
	   				<h4>Sales Representative Informations</h4>
	   			</div>
	   		</div>
	   		<div class="row">
	   			<div class="col-lg-4">
	   				<h5>Personal Info</h5>
	   				<table>
	   					<tr>
	   						<td>
	   							Full Name: 
	   						</td>
	   						<td id="fullname" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							Email: 
	   						</td>
	   						<td id="email" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							Cellphone: 
	   						</td>
	   						<td id="cellphone" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   				</table>
	   			</div>
	   			<div class="col-lg-4">
	   				<h5>Financial Info</h5>
	   				<table>
	   					<tr>
	   						<td>
	   							Comission (%): 
	   						</td>
	   						<td id="comission" class="text-right" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							Bonus ($): 
	   						</td>
	   						<td id="bonus" class="text-right" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							Savings ($): 
	   						</td>
	   						<td id="savings" class="text-right" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   				</table>
	   			</div>
	   			<div class="col-lg-4">
	   				<h5>Miscellaneous</h5>
	   				<table>
	   					<tr>
	   						<td>
	   							Homephone/Workphone: 
	   						</td>
	   						<td id="phones" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							Last Login: 
	   						</td>
	   						<td id="lastLogin" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   				</table>
	   			</div>
	   		</div>
	   	</div>
	</div>
   	<div style="display: none">
   		<div id="customerInfo" class="well">
	   		<div class="row">
	   			<div class="col-lg-12">
	   				<h4>Customer Informations</h4>
	   			</div>
	   		</div>
	   		<div class="row">
	   			<div class="col-lg-4">
	   				<h5>Personal Info</h5>
	   				<table>
	   					<tr>
	   						<td>
	   							Address:
	   						</td>
	   						<td id="address1" style="padding: 0 10px">
	   							&nbsp
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							City: 
	   						</td>
	   						<td id="city" style="padding: 0 10px">
	   							&nbsp
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							State - Zipcode:
	   						</td>
	   						<td id="statezip" style="padding: 0 10px">
	   							&nbsp
	   						</td>
	   					</tr>
	   				</table>
	   			</div>
	   			<div class="col-lg-4">
	   				<h5>Phones</h5>
	   				<table>
	   					<tr>
	   						<td>
	   							Cell:
	   						</td>
	   						<td id="customerCellphone" style="padding: 0 10px">
	   							&nbsp
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							Home: 
	   						</td>
	   						<td id="homephone" style="padding: 0 10px">
	   							&nbsp
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							Work:
	   						</td>
	   						<td id="workphone" style="padding: 0 10px">
	   							&nbsp
	   						</td>
	   					</tr>
	   				</table>
	   			</div>
	   			<div>
	   				<h5>Other Important Info</h5>
	   				<table>
	   					<tr>
	   						<td>
	   							CHARGE BACK:
	   						</td>
	   						<td id="chargeBack" class="text-right" style="padding: 0 10px">
	   							&nbsp
	   						</td>
	   					</tr>
	   				</table>
	   				
	   			</div>
	   		</div>
	   	</div>
	</div>
   	<div style="display: none">
   		<div id="saleInfo" class="well">
	   		<div class="row">
	   			<div class="col-lg-12">
	   				<h4>Sale Informations</h4>
	   			</div>
	   		</div>
	   		<div class="row">
	   			<div class="col-lg-6">
	   				<h5>Services</h5>
	   				<table>
	   					<tr>
	   						<td style="width:40">
	   							TV: 
	   						</td>
	   						<td id="tv" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							Internet: 
	   						</td>
	   						<td id="internet" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							Phone: 
	   						</td>
	   						<td id="phone" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							Xfinity Home: 
	   						</td>
	   						<td id="xfinity_home" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							Extras: 
	   						</td>
	   						<td id="extras" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   				</table>
	   			</div>
	   			<div class="col-lg-6">
	   				<h5>Comcast Info</h5>
	   				<table>
	   					<tr>
	   						<td style="width:40">
	   							Category: 
	   						</td>
	   						<td id="category" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							Job Number: 
	   						</td>
	   						<td id="jobnumber" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							Account Number: 
	   						</td>
	   						<td id="accnumber" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   				</table>
	   			</div>
	   		</div>
	   	</div>
	</div>
