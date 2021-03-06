<?php
/*
 * View/Events/agenda.ctp
 *
 * Licensed under MIT
 * http://www.opensource.org/licenses/mit-license.php
 */
$qtdUsers = count($eventByUser);
//echo '<pre>'.print_r($usersList,true).'</pre>';
$userslist = '<select name=\'selecUser\' class=\'form-control\'>';
foreach ($users as $key => $value) {
	$userslist .= "<option value='$key'>$value</option>";
}
$userslist .= '</select>';
?>
<script type="text/javascript">
var varDivDragged = "";
var newEventForm = $('#newEventForm');
</script>
<!-- NEW EVENT FORM -->
<div style="display: none">
	<span id="newEventForm">
	<?php
		echo $this->Form2->create('Event');
		echo $this->Form2->input('title');
		echo $this->Form2->input('details');
		echo $this->Form2->end();
	?>
	</span>
</div>
<!-- END NEW EVENT FORM -->

<div class="row">
	<div class="col-sm-1 col-lg-1 text-center">
	<?php
		echo $this->Html->link('Previous', 
			array('action'=>'dairyAgenda',$eventDate), 
			array('class'=>'btn btn-sm btn-info'));
	?>
	</div>
	<div class="col-sm-5 col-lg-5 text-center">
	</div>
	<div class="col-sm-5 col-lg-5 text-center">
	<?php
		echo $this->Form2->select('User',$usersList);
	?>
	</div>
	<div class="col-sm-1 col-lg-1 text-center">
	<?php
		echo $this->Html->link('Next', 
			array('action'=>'dairyAgenda',$eventDate), 
			array('class'=>'btn btn-sm btn-info'));
	?>
	</div>

</div>

<div class="row agendaTitle">
	<div class="col-lg-2 text-center" style="border-right:1px dotted #ccc"><?php echo date('F d, Y',strtotime($eventDate)); ?></div>
	<div class="col-lg-10">
		<div class="row">
			<?php
			for ($t=0;$t<$qtdUsers;$t++){
			?>
			<div class="widthSize col-lg-<?php echo round(12 / $qtdUsers); ?> text-center" style="border-right:1px dotted #ccc">
				<?php echo $eventByUser[$t]['User']['username']; ?>
			</div>
			<?php
			}
			?>
		</div>
	</div>
</div>
<div id="todaysAgenda">
	<?php
	for ($i=16;$i<=45;$i++){
	?>
	<div class="row" style="border-bottom: 1px dotted #ccc; height: 25px">
		<div class="col-lg-2 timeColumn text-center">
			<?php echo $i % 2 == 0 ? gmdate('h:i a', $i*1800) : ' ' ; ?>
		</div>
		<div class="col-lg-10">
			<div class="row">
				<?php
				for ($t=0;$t<$qtdUsers;$t++){
				?>
				<div id="slot-<?php echo $i.'-'.$eventByUser[$t]['User']['id']; ?>" class="col-lg-<?php echo round(12 / $qtdUsers); ?>" style="border-right:1px dotted #ccc;height:20px">

				</div>
				<script type="text/javascript">
					$( "#slot-<?php echo $i.'-'.$eventByUser[$t]['User']['id']; ?>" ).droppable({
						tolerance: "pointer",
						accept: function(d){
							if (!$(this).children().length > 0){
								return true;
							};
						},
						drop: function(event, ui) {
							var slotNumIDAnt = ui.draggable.attr('id');
							var eventSplitted =slotNumIDAnt.split('-');
							var slotNumID = $( this ).attr('id');
							var slotNumIDSplitted = slotNumID.split('-');
							if (!$('#event-'+slotNumIDSplitted[1]+"-<?php echo $eventByUser[$t]['User']['id']; ?>-"+eventSplitted[3] ).length > 0 ) 
							{
								$(this).append(ui.draggable.css({position: "relative", top:"", left:""}));
								ui.draggable.attr('id','event-'+slotNumIDSplitted[1]+"-<?php echo $eventByUser[$t]['User']['id']; ?>-"+eventSplitted[3]);
								var endEvent = Math.round((ui.draggable.height()/25));
								$.ajax({
									url: "<?php echo Router::url(array('controller'=>'events','action'=>'update'));?>",
									type: 'post',
									dataType: 'Json',
									data: {
										id: eventSplitted[3],
										user: "<?php echo $eventByUser[$t]['User']['id']; ?>",
										start: "<?php echo date('Y-m-d ', strtotime($eventDate)).gmdate('h:i:s', $i*1800); ?>",
										end: endEvent
									} 
								})
							};
						}
					}).click(function(){
						$( '.modal-title' ).html("New Event");
						$( '.modal-body' ).html(newEventForm);
						$( '#myModal' ).modal({
							keyboard: false
						});
					});
				</script>
				<?php
				}
				?>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel"><?php echo $i; ?></h4>
			</div>
			<div class="modal-body">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button id="saveEvent" type="button" class="btn btn-primary">Save</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script type="text/javascript">
	<?php
	foreach ($events as $key => $event) {
		for ($i=0; $i < 47; $i++) 
		{ 
			if ((date('h:i a', strtotime($event['Event']['start'])) == gmdate('h:i a', $i*1800) && ($objLoggedUser->getAttr('role_id') < 6 && $event['Event']['event_type_id'] != '6')) || 
				(date('h:i a', strtotime($event['Event']['start'])) == gmdate('h:i a', $i*1800) && ($objLoggedUser->getAttr('role_id') == 6 )) || 
				(date('h:i a', strtotime($event['Event']['start'])) == gmdate('h:i a', $i*1800) && ($objLoggedUser->getID()) == ($event['Event']['user_id'] ))) 
			{
				$heightFactor = ( ( (strtotime($event['Event']['end'] ) - strtotime($event['Event']['start'])) / 60 ) / 30 );
				$height =  $heightFactor * 25 ; 
				?>
	var formEditEvent<?php echo $i ?> = "<form method=\"POST\" class='well' action='#'><input name='title' value='<?php echo $event['Event']['title'] ?>' class='form-control'><?php echo $userslist ; ?><input name='details' value='<?php echo $event['Event']['details'] ?>' class='form-control'><input name='details' value='<?php echo $event['Event']['details'] ?>' class='form-control'><input name='details' value='<?php echo $event['Event']['details'] ?>' class='form-control'><input name='details' value='<?php echo $event['Event']['details'] ?>' class='form-control'></form>"
	$( "#slot-<?php echo $i.'-'.$event['Event']['user_id'] ; ?>" ).html("<div class=\"event<?php echo $event['Event']['pinned']?'':' draggable'; ?>\" id=\"event-<?php echo $i.'-'.$event['Event']['user_id'].'-'.$event['Event']['id'] ; ?>\"style=\"background-color: <?php echo $event['EventType']['color'].'; height: '.$height.'px'; ?>; top: 0; <?php echo $event['Event']['pinned']?'z-index: 90000':''; ?>\"><div class=\"eventTitle\"><?php echo $event['Event']['title'].' - '.$height ; ?><?php echo $event['Event']['pinned']?'<span class=\"pull-right eventInfoIcon\"><span class=\"glyphicon glyphicon-pushpin\"></span></span>':''; ?></div></div>").click( function(){
			$( '.modal-title' ).html("<?php echo $event['Event']['title'] ?>")
			$( '.modal-body' ).html(formEditEvent<?php echo $i ?>);
			$( '[name=selecUser]' ).val("<?php echo $event['Event']['user_id']; ?>")
			$( '#myModal' ).modal({
				keyboard: false
		})
	})
				<?php
				for ($i0=$i+1; $i0 < ($i+$heightFactor);$i0++)
				{
					?>
	$( "#slot-<?php echo $i0.'-'.$event['Event']['user_id'] ; ?>" ).html("<div class=\"no-dropable\"></div>");
					<?php
				}
			}
		}
	}
	?>
</script>
 
<script>
	var varMaxWidth = $(' .widthSize ').width();
	$( ".draggable" ).draggable({ 
		containment: "#todaysAgenda",
		revert: 'invalid',
		start: function(event,ui){
			var slotHeight = Math.round(($( this ).height() / 25)) ;
			var slotNumID = $( this ).attr('id');
			var slotNumIDSplitted = slotNumID.split('-');
			for (i=parseInt(slotNumIDSplitted[1])+1; i < parseInt(slotNumIDSplitted[1])+slotHeight; i++){
				$('#slot-'+i+'-'+slotNumIDSplitted[2]).empty();
			}
		},
		stop: function(event,ui){
			var slotHeight = Math.round(($( this ).height() / 25)) ;
			var slotNumID = $( this ).attr('id');
			var slotNumIDSplitted = slotNumID.split('-');
			for (i=parseInt(slotNumIDSplitted[1])+1; i < parseInt(slotNumIDSplitted[1])+slotHeight; i++){
				$('#slot-'+i+'-'+slotNumIDSplitted[2]).html("<div class=\"no-dropable\">NO</div>");
			}
		}
	}).resizable({ 
		grid: [ 0, 25 ],
		maxWidth: varMaxWidth,
		minWidth: varMaxWidth,
		minHeight: 25,
		start: function(event,ui){
			var slotHeight = Math.round(($( this ).height() / 25)) ;
			var slotNumID = $( this ).attr('id');
			var slotNumIDSplitted = slotNumID.split('-');
			for (i=parseInt(slotNumIDSplitted[1])+1; i < parseInt(slotNumIDSplitted[1])+slotHeight; i++){
				$('#slot-'+i+'-'+slotNumIDSplitted[2]).empty();
			}
		},
		stop: function() {
			var thisHeight = $( this ).height();
			var slotNumID = $( this ).attr('id');
			var slotNumIDSplitted = slotNumID.split('-');
			var endEvent = Math.round((thisHeight/25));
			for (i=parseInt(slotNumIDSplitted[1])+1; i < parseInt(slotNumIDSplitted[1])+endEvent; i++){
				$('#slot-'+i+'-'+slotNumIDSplitted[2]).html("<div class=\"no-dropable\">NO</div>");
			}
			$.ajax({
				url: "<?php echo Router::url(array('controller'=>'events','action'=>'resize'));?>",
				type: 'post',
				dataType: 'Json',
				data: {
					id: slotNumIDSplitted[3],
					user: slotNumIDSplitted[2],
					start: "<?php echo date('Y-m-d ', strtotime($events[0]['Event']['start'])); ?>",
					startTime: slotNumIDSplitted[1],
					end: endEvent
				},
				success: function(){
					alert('alterei...');
				}
			});
		}
	});
	$( '#saveEvent' ).click(function(e){
		alert('enviar form via ajax');
		e.preventDefault();
	});
</script>
