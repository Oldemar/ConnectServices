<?php
$controllerAction = $controllerText == 'Advance' ? 'advance' : 'payroll';
?>
<div class="sales index">
	<h2><?php echo __($controllerText.' - Not comissioned Sales'); ?></h2>
	<div class="row" style="padding-bottom: 15px">
		<div class="col-lg-4 col-md-4" style="padding:5px; border: 1px solid #ccc; border-radius: 10px">
			<div class="row">
				<div class="col-lg-4 col-md-4">
					<h5><b>Region:</b></h5>
				</div>
				<div class="col-lg-8 col-md-8">
				<?php
					echo $this->Form2->create('Payroll',array('action'=>'generate'.$controllerAction));
					echo $this->Form2->input('User.region', array(
						'label'=>false,
						'div'=>false,
						'id'=>'region',
						'class'=>'form-control srcInput'
						));
				?>
				</div>
			</div>
		</div>
		<div class="col-lg-1 col-md-1">
		</div>
		<div class="col-lg-5 col-md-5" style="padding:5px; border: 1px solid #ccc; border-radius: 10px">
			<div class="row">
				<div class="col-lg-1 col-md-1">
					<h5><b>From</b></h5>
				</div>
				<div class="col-lg-5 col-md-5">
				<?php
					echo $this->Form2->input('start', array(
						'type'=>'text',
						'required'=>'required',
						'class'=>'form-control srcInput',
						'id'=>'startDate',
						'label'=>false,
						'div'=>false
						));
				?>
				</div>
				<div class="col-lg-1 col-md-1">
					<h5><b>To</b></h5>
				</div>
				<div class="col-lg-5 col-md-5">
				<?php
					echo $this->Form2->input('end', array(
						'type'=>'text',
						'required'=>'required',
						'id'=>'endDate',
						'class'=>'form-control srcInput',
						'label'=>false,
						'div'=>false
						));
				?>
				</div>
			</div>
		</div>
		<div class="col-lg-1 col-md-1 text-right">
		<?php
		echo $this->Form2->button('Preview', array(
			'type'=>'submit', 
			'class'=>'btn btn-lg btn-primary'));
		echo $this->Form2->end();
		?>
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
				$.ajax({
					url: "<? echo Router::url(array('controller'=>'sales','action'=>'listsalesAJAX',$controllerText)); ?>",
					type : "post",
					dataType: "Json",
					data: { 
						region: $('#region').val(), 
						start: $('#startDate').val(), 
						end: $('#endDate').val() 
					}
				}).done(function(html){
					$("#salesList").html(html);
				})
				e.preventDefault();
			}).change();

	  	</script>
	</div>
	<div id="salesList">
	</div>
</div>
