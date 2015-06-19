<?php
/*
 * View/Events/agenda.ctp
 *
 * Licensed under MIT
 * http://www.opensource.org/licenses/mit-license.php
 */
//echo '<pre>'.print_r($eventsByDay,true).'</pre>';
?>
<div id="weeklyAgenda">
	<table class="table table-bordered table-hover">
		<tr>
			<td colspan='2'>
				<div class="row">
					<div class="col-sm-2 col-lg-1 text-center">
					<?php
						echo $this->Html->link('Previous', 
							array('action'=>'dairyAgendaNew',date('Y-m-d', strtotime($date . "-1 day"))), 
							array('class'=>'btn btn-sm btn-info'));
					?>
					</div>
					<div class="col-sm-8 col-lg-6 text-center">
						<strong><big><?php echo date('F d, Y',strtotime($date)); ?></big></strong>
					</div>
					<div class="col-lg-3 hidden-xs hidden-sm text-right form-group" style="margin-bottom: 0">
					<?php
						echo $this->Form->input('aDate', array(
							'type'=>'text',
							'class'=>'form-control srcInput',
							'id'=>'aDate',
							'label'=>false,
							'div'=>false
							));
					?>
					</div>
					<div class="col-lg-1 hidden-xs hidden-sm text-left form-group">
					<?php
						echo $this->Html->link('Go',array('action'=>'dairyAgendaNew',date('Y-m-d')),array('class'=>'btn btn-sm btn-default'));
					?>
					</div>
					<div class="col-sm-2 col-lg-1 text-center">
					<?php
						echo $this->Html->link('Next', 
							array('action'=>'dairyAgendaNew',date('Y-m-d', strtotime($date . "+1 day"))), 
							array('class'=>'btn btn-sm btn-info'));
					?>
					</div>

				</div>
			</td>
		</tr>
	<?php
		foreach ($eventsByDay as $time => $events) 
		{
			echo '<tr><td class="text-center">'.gmdate('h:i a', $time*1800).'</td>';
			echo '<td class="droppable" data-date="'. date('Y-m-d',strtotime($date)) .'" data-start="'. gmdate('h:i:s', $time*1800) .'" data-end="'. $time .'" data-uid="" style="width: 90%; "><div style="width: 100%;">';
			$z=0;
			$w=120;
			foreach ($events as $keyEvent => $event) 
			{
				$z++;
				$w-=10;
				$m=$z*10;
				$dgb = $event['Event']['pinned']?'':' draggable';
				echo "<div class=\"event ".$dgb."\" data-uid=\"".$event['User']['id']."\" data-eid=\"".$event['Event']['id']."\" style=\"float: left; color: #fff; background-color: ".$event['EventType']['color']."; width: 10%; padding: 3px;\"><p style=\"margin: 0 0 3px; color: white; font-weight: bold;\">".$event['User']['username'].'</p><hr style="margin: 1px"><span style="color: yellow">'.$event['Event']['title']."</span></div>";
			}
			echo '</div></td>';
		
			echo '</tr>';
		}
	?>
	</table>
</div>
<script>
	$( ".draggable" ).draggable({ 
		containment: "#weeklyAgenda",
		revert: 'invalid'
	})
	$( "#aDate" ).datepicker({
		dateformat: 'yy-mm-dd'
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
</script>
