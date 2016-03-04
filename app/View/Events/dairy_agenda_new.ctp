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
					<div class="col-xs-2 visible-xs">
					<?php
						echo $this->Html->link('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>', 
							array('action'=>'dairyAgendaNew',date('Y-m-d', strtotime($date . "-1 day"))), 
							array('class'=>'btn btn-md btn-info aDate','escape'=>false));
					?>
					</div>
					<div class="col-sm-2 col-lg-1 hidden-xs text-center">
					<?php
						echo $this->Html->link('Previous', 
							array('action'=>'dairyAgendaNew',date('Y-m-d', strtotime($date . "-1 day"))), 
							array('class'=>'btn btn-sm btn-info'));
					?>
					</div>
					<div class="col-xs-6 col-sm-4 col-lg-6 text-center">
						<strong><big><?php echo date('F d, Y',strtotime($date)); ?></big></strong>
					</div>
					<div class="col-xs-2 visible-xs text-center">
					<?php
						echo $this->Html->link('<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>', '#', 
							array('class'=>'btn btn-md btn-success','id'=>'btnDatePicker','escape'=>false));
						echo $this->Form->input('aDateHidden', array(
							'type'=>'text',
							'class'=>'form-control srcInput aDateHidden',
							'id'=>'aDate',
							'label'=>false,
							'div'=>false
							));
					?>
					</div>
					<div class="col-sm-4 hidden-xs form-group" style="margin-bottom: 0">
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
					<div class="col-xs-2 visible-xs">
					<?php
						echo $this->Html->link('<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>', 
							array('action'=>'dairyAgendaNew',date('Y-m-d', strtotime($date . "+1 day"))), 
							array('class'=>'btn btn-md btn-info','escape'=>false));
					?>
					</div>
					<div class="col-sm-2 col-lg-1 hidden-xs text-center">
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
			echo '<td class="eventAdd droppable" data-date="'. date('Y-m-d',strtotime($date)) .'" data-start="'. gmdate('h:i:s', $time*1800) .'" data-end="'. $time .'" data-uid="'.$objLoggedUser->getID().'" style="width: 90%; "><div style="width: 100%;">';
			$z=0;
			$w=120;
			foreach ($events as $keyEvent => $event) 
			{
				$z++;
				$w-=10;
				$m=$z*10;
				$dgb = $event['Event']['pinned']?'':' draggable';
				echo '<div class="event '.$dgb.'" data-uid="'.$event['User']['id'].'" data-eid="'.$event['Event']['id'].'" style="float: left; color: #fff; background-color: '.$event['EventType']['color'].'; width: 20%; padding: 3px;"><p style="margin: 0 0 3px; color: white; font-weight: bold;">'.$event['User']['username'].'</p><hr style="margin: 1px"><span style="color: yellow">'.$event['Event']['title']."</span></div>";
			}
			echo '</div></td>';
		
			echo '</tr>';
		}
	?>
	</table>
</div>
<!-- Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Event</h4>
			</div>
			<div class="modal-body">
				<?php
					echo $this->Form2->create('Event');
					if (in_array($objLoggedUser->getAttr('role_id'), array('2','9')))
					{
						echo $this->Form2->input('EventType', array(
							'class'=>'form-control pull-left',
							'style'=>'width: 250px',
							'placeholder'=>'This field is required',
							'label'=>array(
								'class'=>'pull-left',
								'style'=>'width: 100px'
								)));
				?>
				<div style="clear: both"></div>
				<?php
						echo $this->Form2->input('user_id', array(
							'class'=>'form-control pull-left',
							'style'=>'width: 250px',
							'label'=>array(
								'class'=>'pull-left',
								'style'=>'width: 100px'
							)));
					}
					else
					{
						echo $this->Form2->input('EventType', array(
							'type'=>'hidden',
							'value'=>'6'));
						echo $this->Form2->input('user_id', array(
							'type'=>'hidden',
							'value'=>$objLoggedUser->getID()
							));
					}
				?>
				<div style="clear: both"></div>
				<?php
					echo $this->Form2->input('title', array(
						'class'=>'form-control pull-left',
						'style'=>'width: 250px',
						'required'=>'required',
						'placeholder'=>'This field is required',
						'label'=>array(
							'class'=>'pull-left',
							'style'=>'width: 100px'
						)));
				?>
				<div style="clear: both"></div>
				<?php
					echo $this->Form2->input('details', array(
						'type'=>'textarea',
						'class'=>'form-control pull-left',
						'style'=>'width: 250px',
						'required'=>'required',
						'placeholder'=>'This field is required',
						'label'=>array(
							'class'=>'pull-left',
							'style'=>'width: 100px'
						)));
				?>
				<div style="clear: both"></div>
				<?php
					echo $this->Form2->input('start', array(
						'type'=>'text',
						'required'=>'required',
						'placeholder'=>'This field is required',
						'id'=>'saleDate',
						'class'=>'form-control pull-left aData',
						'style'=>'width: 250px',
						'value'=>date('Y-m-d'),
						'label'=>array(
							'class'=>'pull-left',
							'style'=>'width: 100px'
							)));
				?>
				<div style="clear: both"></div>
				<?php
					echo $this->Form2->input('end', array(
						'type'=>'text',
						'required'=>'required',
						'placeholder'=>'This field is required',
						'id'=>'saleDate',
						'class'=>'form-control pull-left aData',
						'style'=>'width: 250px',
						'value'=>date('Y-m-d'),
						'label'=>array(
							'class'=>'pull-left',
							'style'=>'width: 100px'
							)));
				?>
				<div style="clear: both"></div>
				<?php
					echo $this->Form2->end();
				?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>
<script>
	$( ".draggable" ).draggable({ 
		containment: "#weeklyAgenda",
		revert: 'invalid'
	})
	$( "#aDate, .aData" ).datepicker({
		dateFormat: 'yy-mm-dd'
	}).change(function(){
		window.location = $('#aDate').val();
	});
	$('#btnDatePicker').click(function() {
    	$('#aDateHidden').datepicker('show');
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
	$('.eventAdd, .event').on('click', function(){

		$('#eventModal').modal('show');
	});
</script>
