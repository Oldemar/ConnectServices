<?php
/*
 * View/Events/agenda.ctp
 *
 * Licensed under MIT
 * http://www.opensource.org/licenses/mit-license.php
 */
//echo '<pre>'.print_r($eventsByDay1,true).'</pre>';
?>
<div id="weeklyAgenda">
	<table class="table table-bordered table-hover">
		<tr>
			<td colspan='8'>
				<div class="row">
					<div class="col-sm-2 col-lg-1 text-center">
					<?php
						echo $this->Html->link('Previous', 
							array('action'=>'weeklyAgenda',date('Y-m-d', strtotime($date . "-6 days"))), 
							array('class'=>'btn btn-sm btn-info'));
					?>
					</div>
					<div class="col-sm-8 col-lg-10 text-center">
						<strong><big>Weekly Agenda</big></strong>
					</div>
					<div class="col-sm-2 col-lg-1 text-center">
					<?php
						echo $this->Html->link('Next', 
							array('action'=>'weeklyAgenda',date('Y-m-d', strtotime($date . "+8 days"))), 
							array('class'=>'btn btn-sm btn-info'));
					?>
					</div>

				</div>
			</td>
		</tr>
		<tr>
			<th style="minwidth: 7.25%"></th>
			<?php
			for ($i=0;$i<7;$i++)
			{
			?>
			<th class="text-center" style="width: 13.25%;<?php echo ($i>4) ? 'background-color: #eee;' : ''; ?>">
				<?php 
					echo CakeTime::format(date('Y-m-d',strtotime($date. "+$i days")), '%B %e');
				?>
			</th>
			<?php
			}
			?>
		</tr>
			<?php
				foreach ($eventsByDay as $time => $dates) 
				{
					echo '<tr><td style="width: 7.25%">'.gmdate('h:i a', $time*1800).'</td>';

					foreach ($dates as $key => $dateEvent) 
					{
						$bg = $key > 4 ? 'background-color: #eee;' : '';
						echo '<td class="droppable" data-date="'. date('Y-m-d',strtotime($date . "+$key days")) .'" data-start="'. gmdate('h:i:s', $time*1800) .'" data-end="'. $time .'" data-uid="" style="width: 13.25%;'.$bg.'; "><div style="width: 100%;">';
						$z=0;
						$w=120;
						foreach ($dateEvent as $keyEvent => $events) 
						{
							$z++;
							$w-=10;
							$m=$z*10;
							$dgb = $events['Event']['pinned']?'':' draggable';
							echo "<div class=\"event ".$dgb."\" data-uid=\"".$events['User']['id']."\" data-eid=\"".$events['Event']['id']."\"  data-title=\"".$events['Event']['title']."\" style=\"float: left; color: #fff; background-color: ".$events['EventType']['color']."; width: 50%; padding: 3px;\"><p style=\"margin: 0 0 3px; color: white; font-weight: bold;\">".$events['User']['username'].'</p><hr style="margin: 1px"><small><span style="color: yellow">'.$events['Event']['title']."</span></small></div>";
						}
						echo '</div></td>';
					}

					echo '</tr>';
				}
			?>
	</table>
</div>
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="myModalLabel">Reschedule</h4>
			</div>
			<div class="modal-body">
				<h4>Event</h4>
				<h5 id="modalEventTitle" style="padding-left:15px"></h5>
				<div class="row well form-group">
				<div class="col-lg-1">
					<h5>FROM:</h5>
				</div>
				<div class="col-lg-3 dateEventModal"></div>
				<div class="col-lg-1">
					<h5>TO:</h5>
				</div>
				<div class="col-lg-6">
				<?php
					echo $this->Form->input('aDate', array(
						'type'=>'datetime',
						'class'=>'form-control srcInput',
//						'id'=>'aDate',
						'label'=>false,
						'div'=>false
						));
				?>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<script>
	$( ".draggable" ).draggable({ 
		containment: "#weeklyAgenda",
		revert: 'invalid'
	});

	$( ".droppable" ).droppable({
		tolerance: "pointer",
		drop: function(event, ui) {
			$(this).append(ui.draggable.css({position: "relative", top:"", left:""}));
			$.ajax({
				url: "<?php echo Router::url(array('controller'=>'events','action'=>'update'));?>",
				type: 'post',
				dataType: 'Json',
				data: {
					id: ui.draggable.attr('data-eid'),
					user: ui.draggable.attr('data-uid'),
					start: $(this).attr('data-date')+' '+$(this).attr('data-start')
				} 
			})
		}
	});

	$( "#aDate" ).datepicker({
		dateFormat: 'yy-mm-dd',
		minDate: 0

	});

	$('.event').click(function( e ){
		$('#dateEventModal').html($(e.target).closest('td').attr('data-date'));
		$('#modalEventTitle').html($(this).attr('data-title'));

		$('#eventModal').modal('show');
	});
</script>
