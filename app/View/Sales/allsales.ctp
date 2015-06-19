<div class="sales index">
	<h2><?php echo __('Not comissioned Sales'); ?></h2>
	<div class="row" style="padding-bottom: 15px">
		<div class="col-lg-5" style="padding:5px; border: 1px solid #ccc; border-radius: 10px">
			<div class="row">
				<div class="col-lg-4">
					<h5><b>Region:</b></h5>
				</div>
				<div class="col-lg-8">
				<?php
					echo $this->Form2->input('region_id', array(
						'label'=>false,
						'div'=>false,
						'id'=>'region',
						'class'=>'form-control srcInput'
						));
				?>
				</div>
			</div>
		</div>
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
				$.ajax({
					url: "<?php echo Router::url(array('controller'=>'sales','action'=>'allsalesAJAX')); ?>",
					type : "post",
					dataType: "json",
					data: { 
						region: $('#region').val(), 
						start: $('#startDate').val(), 
						end: $('#endDate').val() 
					}
				}).done(function(html){
					$("#salesList").html(html);
				}).fail(function(){
					alert('ERROR - Plese Contact the Developer');
				});
				e.preventDefault();
			}).change();
	  	</script>
	</div>
	<div id="salesList">
	</div>
</div>
