<script src="http://cdn.datatables.net/1.10.5/js/jquery.dataTables.min.js"></script>
<script src="<?php echo $this->webroot; ?>js/accounting.js"></script>
	<div class="row" id="payrollHeader">
		<div class="col-lg-6">
			<h2>Prepare Payroll</h2>
		</div>
		<div class="col-lg-6 text-right">
			<div class="row">
				<div class="col-lg-6">
					
				</div>
				<div class="col-lg-3">
				<?php
					echo $this->Form2->button('Back', array(
							'type'=>'button',
							'class'=>'btn btn-lg btn-primary btnVisible',
							'style'=>'color: black; font-weigth:bold',
							'id'=>'btnBack',
							'style'=>'display: none'
						));
				?>
				</div>
				<div class="col-lg-3">
				<?php
					echo $this->Form2->button('Preview', array(
							'type'=>'button',
							'class'=>'btn btn-lg btn-primary btnVisible',
							'style'=>'color: black; font-weigth:bold',
							'id'=>'btnPreview'
						));

					echo $this->Form2->button('Generate', array(
							'type'=>'button',
							'class'=>'btn btn-lg btn-primary btnVisible',
							'style'=>'color: black; font-weigth:bold',
							'id'=>'btnGenerate',
							'style'=>'display: none'
						));
				?>
				</div>
			</div>
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
				$('#btnBack, #btnGenerate').hide();
				listSales();
				e.preventDefault();
			});
			$('#btnBack').click(function(e){
				$('.btnVisible').toggle();
				listSales();
				e.preventDefault();
			});
			$(document).on('click', '#savePayroll',function(){
				$.ajax({
					url: "<?php echo Router::url(array('controller'=>'payrolls','action'=>'savepayroll')); ?>",	
					type: 'POST',
					dataType: 'json',
					data: 
						{ 
							'regionID': $('#regionID').val(), 
							'start': $('#startDate').val(), 
							'end': $('#endDate').val(),
							'userID': $('#userID').val()
						}
				}).done(function(data){
					window.location = "<?php echo Router::url(array('controller'=>'payrolls','action'=>'listsales')); ?>";
				});
			});
			$('#btnGenerate').on('click', function(){
				$('#myGeneratePayrollModal').modal('show');
			});
			$('#btnPreview').click(function(e){
				subtotalInfo = $('#subtotalInfo');
				var varTable = $('#salesTable').DataTable();
					varTable.destroy();
				td1 = "";
				$('#salesTable').empty();
				$('.btnVisible').toggle();
				$('salesTable').hide();
				$('#previewPayrollTable').show();
				var payrollTable = $('#previewPayrollTable').DataTable({
					'destroy': true,
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
							{'data': 'User.fullname'},
							{
								'data': 'SFUIN.sfuinTot',
								'render': function(d)
									{
										return accounting.formatMoney(d);
									},
								'className':'SFUIN text-right'
							},
							{
								'data': 'SFUOUT.sfuouTot',
								'render': function(d)
									{
										return accounting.formatMoney(d);
									},
								'className':'SFUOUT text-right'
							},
							{
								'data': 'MDUIN.mduinTot',
								'render': function(d)
									{
										return accounting.formatMoney(d);
									},
								'className':'MDUIN text-right'
							},
							{
								'data': 'MDUOUT.mduouTot',
								'render': function(d)
									{
										return accounting.formatMoney(d);
									},
								'className':'MDUOUT text-right'
							},
							{
								'data': 'bonusTot',
								'render': function(d)
									{
										return accounting.formatMoney(d);
									},
								'className':'text-right'

							},
							{
								'data': 'User.bonus',
								'render': function(d)
									{
										return accounting.formatMoney(d);
									},
								'className':'text-right'

							},
							{
								'data': 'subtotal',
								'render': function(d)
									{
										return accounting.formatMoney(d);
									},
								'className':'text-right'

							},
							{
								'data': 'savings',
								'render': function(d)
									{
										return accounting.formatMoney(d);
									},
								'className':'text-right'

							},
							{
								'data': 'Advance.balance',
								'render': function(d)
									{
										return accounting.formatMoney(d);
									},
								'className':'text-right'

							},
							{
								'data': 'chargeback',
								'render': function(d)
									{
										return accounting.formatMoney(d);
									},
								'className':'text-right'

							},
							{
								'data': 'totaldue',
								'render': function(d)
									{
										return accounting.formatMoney(d);
									},
								'className':'text-right'

								 }
						]
				});

			    $('#previewPayrollTable tbody').on('click', 'td.SFUIN', function () {
			        var tr = $(this).closest('tr');
			        var row4 = payrollTable.row( tr );
			        if ( row4.child.isShown() ) {
			            row4.child.hide();
			            tr.removeClass('shown');
			            if (tr.context.classList[0] != td1) {
				            row4.child( formatSFUIN(row4.data()) ).show();
				            tr.addClass('shown');
			            }
			        } else {
			            row4.child( formatSFUIN(row4.data()) ).show();
			            tr.addClass('shown');
			        }
			    	td1 = 'SFUIN';
			    } );
			    $('#previewPayrollTable tbody').on('click', 'td.SFUOUT', function () {
			        var tr = $(this).closest('tr');
			        var row5 = payrollTable.row( tr );
			        if ( row5.child.isShown() ) {
			            row5.child.hide();
			            tr.removeClass('shown');
			            if (tr.context.classList[0] != td1) {
				            row5.child( formatSFUOUT(row5.data()) ).show();
				            tr.addClass('shown');
			            }
			        } else {
			            row5.child( formatSFUOUT(row5.data()) ).show();
			            tr.addClass('shown');
			        }
			    	td1 = 'SFUOUT';
			    } );
			    $('#previewPayrollTable tbody').on('click', 'td.MDUIN', function () {
			        var tr = $(this).closest('tr');
			        var row6 = payrollTable.row( tr );
			        if ( row6.child.isShown() ) {
			            row6.child.hide();
			            tr.removeClass('shown');
			            if (tr.context.classList[0] != td1) {
				            row6.child( formatMDUIN(row6.data()) ).show();
				            tr.addClass('shown');
			            }
			        } else {
			            row6.child( formatMDUIN(row6.data()) ).show();
			            tr.addClass('shown');
			        }
			    	td1 = 'MDUIN';
			    } );
			    $('#previewPayrollTable tbody').on('click', 'td.MDUOUT', function () {
			        var tr = $(this).closest('tr');
			        var row7 = payrollTable.row( tr );
			        if ( row7.child.isShown() ) {
			            row7.child.hide();
			            tr.removeClass('shown');
			            if (tr.context.classList[0] != td1) {
				            row7.child( formatMDUOUT(row7.data()) ).show();
				            tr.addClass('shown');
			            }
			        } else {
			            row7.child( formatMDUOUT(row7.data()) ).show();
			            tr.addClass('shown');
			        }
			    	td1 = 'MDUOUT';
			    } );
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
								'title': 'Sales Date',
								'width': '145px'
							},
							{
								"data": "Sale.jobnumber",
								'title': "Job Number",
								'width': '100px'
							},
							{
								"data": "Sale.accnumber",
								'title': "Acc Number"
							},
							{
								"data": "Sale.instalation",
								"title": 'Instalation Date',
								'width':'145px'
							},
							{
								"data": "Sale",
								'title': 'Installed?',
								'className': 'installed',
								"render": function(data)
								{
									return data.installed == '0' ? '<button type="button" id="noInst'+data.id+'" class="btn btn-sm btn-danger">No</button>': '<button type="button" id="yesInst'+data.id+'" class="btn btn-sm btn-success">Yes</button>';
								}
							},
							{
								"data": "Sale",
								"title": "Action",
								"className": "editSale",
								"render": function(data)
								{
									return '<button type="button" id="editSale" data-sid="'+data.id+'" class="btn btn-sm btn-success">Edit</button>';
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
			    $('#salesTable tbody').on('click','td.installed',function(){
			        var trI = $(this).closest('tr');
			        var rowI = salesTable.row( trI );
			        changeInstallStatus(rowI.data());
			    });
			    $('#salesTable tbody').on('click','td.editSale',function(){
			        var trS = $(this).closest('tr');
			        var rowS = salesTable.row( trS );
			        var thisData = rowS.data();
			        window.location = "<?php echo Router::url(array('controller'=>'sales','action'=>'edit')); ?>"+'/'+thisData.Sale.id;
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
				varSaleInfo.find('#extras').html('<br>'+d.Sale.bonus)
				return varSaleInfo;
			}
			function formatSFUIN(d) {
				subtotalInfo.find('#catTitle').html('SFU-IN');
				subtotalInfo.find('#basictv').html(accounting.formatMoney(d.SFUIN.tv['Basic TV']));
				subtotalInfo.find('#economytv').html(accounting.formatMoney(d.SFUIN.tv['Economy TV']));
				subtotalInfo.find('#startertv').html(accounting.formatMoney(d.SFUIN.tv['Starter TV']));
				subtotalInfo.find('#preferredtv').html(accounting.formatMoney(d.SFUIN.tv['Preferred TV']));
				subtotalInfo.find('#premiertv').html(accounting.formatMoney(d.SFUIN.tv['Premier TV']));
				subtotalInfo.find('#economynet').html(accounting.formatMoney(d.SFUIN.internet['Economy Internet']));
				subtotalInfo.find('#performancenet').html(accounting.formatMoney(d.SFUIN.internet['Performance Internet']));
				subtotalInfo.find('#blastnet').html(accounting.formatMoney(d.SFUIN.internet['Blast Internet']));
				subtotalInfo.find('#extremenet').html(accounting.formatMoney(d.SFUIN.internet['Extreme Internet']));
				subtotalInfo.find('#localphone').html(accounting.formatMoney(d.SFUIN.phone['Local Phone']));
				subtotalInfo.find('#unlimitedphone').html(accounting.formatMoney(d.SFUIN.phone['Unlimited Phone']));
				subtotalInfo.find('#xf300').html(accounting.formatMoney(d.SFUIN.xfinity_home['XH 300']));
				subtotalInfo.find('#xf350').html(accounting.formatMoney(d.SFUIN.xfinity_home['XH 350']));
				subtotalInfo.find('#xf100').html(accounting.formatMoney(d.SFUIN.xfinity_home['XH 100']));
				subtotalInfo.find('#xf150').html(accounting.formatMoney(d.SFUIN.xfinity_home['XH 150']));
				return subtotalInfo;
			}
			function formatSFUOUT(d) {
				subtotalInfo.find('#catTitle').html('SFU-OUT');
				subtotalInfo.find('#basictv').html(d.SFUOUT.tv['Basic TV']);
				subtotalInfo.find('#economytv').html(d.SFUOUT.tv['Economy TV']);
				subtotalInfo.find('#startertv').html(d.SFUOUT.tv['Starter TV']);
				subtotalInfo.find('#preferredtv').html(d.SFUOUT.tv['Preferred TV']);
				subtotalInfo.find('#premiertv').html(d.SFUOUT.tv['Premier TV']);
				subtotalInfo.find('#economynet').html(d.SFUOUT.internet['Economy Internet']);
				subtotalInfo.find('#performancenet').html(d.SFUOUT.internet['Performance Internet']);
				subtotalInfo.find('#blastnet').html(d.SFUOUT.internet['Blast Internet']);
				subtotalInfo.find('#extremenet').html(d.SFUOUT.internet['Extreme Internet']);
				subtotalInfo.find('#localphone').html(d.SFUOUT.phone['Local Phone']);
				subtotalInfo.find('#unlimitedphone').html(d.SFUOUT.phone['Unlimited Phone']);
				subtotalInfo.find('#xf300').html(d.SFUOUT.xfinity_home['XH 300']);
				subtotalInfo.find('#xf350').html(d.SFUOUT.xfinity_home['XH 350']);
				subtotalInfo.find('#xf100').html(d.SFUOUT.xfinity_home['XH 100']);
				subtotalInfo.find('#xf150').html(d.SFUOUT.xfinity_home['XH 150']);
				return subtotalInfo;
			}
			function formatMDUIN(d) {
				subtotalInfo.find('#catTitle').html('MDU-IN');
				subtotalInfo.find('#basictv').html(d.MDUIN.tv['Basic TV']);
				subtotalInfo.find('#economytv').html(d.MDUIN.tv['Economy TV']);
				subtotalInfo.find('#startertv').html(d.MDUIN.tv['Starter TV']);
				subtotalInfo.find('#preferredtv').html(d.MDUIN.tv['Preferred TV']);
				subtotalInfo.find('#premiertv').html(d.MDUIN.tv['Premier TV']);
				subtotalInfo.find('#economynet').html(d.MDUIN.internet['Economy Internet']);
				subtotalInfo.find('#performancenet').html(d.MDUIN.internet['Performance Internet']);
				subtotalInfo.find('#blastnet').html(d.MDUIN.internet['Blast Internet']);
				subtotalInfo.find('#extremenet').html(d.MDUIN.internet['Extreme Internet']);
				subtotalInfo.find('#localphone').html(d.MDUIN.phone['Local Phone']);
				subtotalInfo.find('#unlimitedphone').html(d.MDUIN.phone['Unlimited Phone']);
				subtotalInfo.find('#xf300').html(d.MDUIN.xfinity_home['XH 300']);
				subtotalInfo.find('#xf350').html(d.MDUIN.xfinity_home['XH 350']);
				subtotalInfo.find('#xf100').html(d.MDUIN.xfinity_home['XH 100']);
				subtotalInfo.find('#xf150').html(d.MDUIN.xfinity_home['XH 150']);
				return subtotalInfo;
			}
			function formatMDUOUT(d) {
				subtotalInfo.find('#catTitle').html('MDU-OUT');
				subtotalInfo.find('#basictv').html(d.MDUOUT.tv['Basic TV']);
				subtotalInfo.find('#economytv').html(d.MDUOUT.tv['Economy TV']);
				subtotalInfo.find('#startertv').html(d.MDUOUT.tv['Starter TV']);
				subtotalInfo.find('#preferredtv').html(d.MDUOUT.tv['Preferred TV']);
				subtotalInfo.find('#premiertv').html(d.MDUOUT.tv['Premier TV']);
				subtotalInfo.find('#economynet').html(d.MDUOUT.internet['Economy Internet']);
				subtotalInfo.find('#performancenet').html(d.MDUOUT.internet['Performance Internet']);
				subtotalInfo.find('#blastnet').html(d.MDUOUT.internet['Blast Internet']);
				subtotalInfo.find('#extremenet').html(d.MDUOUT.internet['Extreme Internet']);
				subtotalInfo.find('#localphone').html(d.MDUOUT.phone['Local Phone']);
				subtotalInfo.find('#unlimitedphone').html(d.MDUOUT.phone['Unlimited Phone']);
				subtotalInfo.find('#xf300').html(d.MDUOUT.xfinity_home['XH 300']);
				subtotalInfo.find('#xf350').html(d.MDUOUT.xfinity_home['XH 350']);
				subtotalInfo.find('#xf100').html(d.MDUOUT.xfinity_home['XH 100']);
				subtotalInfo.find('#xf150').html(d.MDUOUT.xfinity_home['XH 150']);
				return subtotalInfo;
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
	                <th>SFU-IN</th>
	                <th>SFU-OUT</th>
	                <th>MDU-IN</th>
	                <th>MDU-OUT</th>
	                <th data-toggle="tooltip" data-placement="top" title="This value is already included on category
	                 total">Trip/Quad</th>
	                <th>Bonus</th>
	                <th>Sub Total</th>
	                <th>Saving</th>
	                <th>Advances</th>
	                <th>Charge Back</th>
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
	   					<tr>
	   						<td>
	   							<br>Sale Bonus: 
	   						</td>
	   						<td id="extras" style="padding: 0 10px">
	   						</td>
	   					</tr>

	   				</table>
	   			</div>
	   		</div>
	   	</div>
	</div>
	<div style="display: none;">
		<div id="subtotalInfo" class="well">
			<div>
				<h4 id="catTitle"></h4>
			</div>
	   		<div class="row">
	   			<div class="col-lg-3">
	   				<h5>TV</h5>
	   				<table>
	   					<tr>
	   						<td style="width:40">
	   							Basic: 
	   						</td>
	   						<td id="basictv" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							Economy: 
	   						</td>
	   						<td id="economytv" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							Starter: 
	   						</td>
	   						<td id="startertv" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							Preferred: 
	   						</td>
	   						<td id="preferredtv" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							Premier: 
	   						</td>
	   						<td id="premiertv" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   				</table>
	   			</div>
	   			<div class="col-lg-3">
	   				<h5>Internet</h5>
	   				<table>
	   					<tr>
	   						<td style="width:40">
	   							Economy Internet: 
	   						</td>
	   						<td id="economynet" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							Performance Internet: 
	   						</td>
	   						<td id="performancenet" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							Blast Internet: 
	   						</td>
	   						<td id="blastnet" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							Extreme Internet: 
	   						</td>
	   						<td id="extremenet" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   				</table>
	   			</div>
	   			<div class="col-lg-3">
	   				<h5>PHONE</h5>
	   				<table>
	   					<tr>
	   						<td style="width:40">
	   							Local: 
	   						</td>
	   						<td id="localphone" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							Economy: 
	   						</td>
	   						<td id="unlimitedphone" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   				</table>
	   			</div>
	   			<div class="col-lg-3">
	   				<h5>Xfinity Home</h5>
	   				<table>
	   					<tr>
	   						<td style="width:40">
	   							XF 300: 
	   						</td>
	   						<td id="xf300" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							XF 350: 
	   						</td>
	   						<td id="xf350" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							XF 100: 
	   						</td>
	   						<td id="xf100" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   					<tr>
	   						<td>
	   							XF 150: 
	   						</td>
	   						<td id="xf150" style="padding: 0 10px">
	   						</td>
	   					</tr>
	   				</table>
	   			</div>
	   		</div>			
		</div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="myGeneratePayrollModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">PayRoll Generation</h4>
				</div>
				<div class="modal-body">
					<div class="alert alert-warning" role="alert">
						<em><b>Note:</b> Once you have started saving the Payroll, there's NO going back. So please be sure you're doing the right thing.<br>Click the SAVE button below to start the Payroll saving.</em>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
					<button type="button" class="btn btn-primary" id="savePayroll"  data-dismiss="modal" >Save</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
