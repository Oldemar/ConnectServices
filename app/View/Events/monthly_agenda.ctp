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
	<table class="table table-bordered">
		<tr>
			<th style="width: 7.25%">Time/Day</th>
			<?
			for ($i=0;$i<7;$i++)
			{
			?>
			<th class="text-center" style="width: 13.25%">
				<?php
					echo CakeTime::format(date('Y-m-d',strtotime($date. "+$i days")), '%B %e');
				?>
			</th>
			<?
			}
			?>
		</tr>
			<?
				foreach ($eventsByDay as $time => $dates) 
				{
					echo '<tr><td style="width: 7.25%">'.gmdate('h:i a', $time*1800).'</td>';

					foreach ($dates as $key => $dateEvent) 
					{
						echo '<td class="droppable" data-date="'. date('Y-m-d',strtotime($date . "+$key days")) .'" data-start="'. gmdate('h:i:s', $time*1800) .'" data-end="'. gmdate('h:i:s', $time*1800+900) .'" data-uid="" style="width: 13.25%; "><div style="width: 100%;">';
						$z=0;
						$w=120;
						foreach ($dateEvent as $keyEvent => $events) 
						{
							$z++;
							$w-=10;
							$m=$z*10;
							if ($events['Event']['pinned'])
							{
								$dgbc = '';
								$dgbs = ' cursor: not-allowed';
							}
							else
							{
								$dgbc = ' draggable';
								$dgbs = 'zzz';
							}
							echo "<div class=\"event ".$dgbc."\" data-uid=\"".$events['User']['id']."\" data-eid=\"".$events['Event']['id']."\" style=\"float: left; color: #fff; background-color: ".$events['EventType']['color']."; width: 50%; ".$dgbs."\"><h4><small><u>".$events['User']['username'].'</u></h4>'.$events['Event']['title']."</small></div>";
						}
						echo '</div></td>';
					}

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
</script>
<script type="text/javascript">
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
					start: $(this).attr('data-date')+' '+$(this).attr('data-star'),
					end: $(this).attr('data-date')+' '+$(this).attr('data-end')
				} 
			})
		}
	});
</script>
