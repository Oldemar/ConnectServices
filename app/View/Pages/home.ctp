<?php
//	echo '<pre>'.print_r($lastpost,true).'</pre>';
//	echo '<pre>'.print_r($salesByUsers,true).'</pre>';
?>
<div class="row" style="padding: 10px">
	<div class="col-xs-12 col-sm-8">
		<div class="row">
			<div class="well col-xs-12">
				<p class="post-title">
				<?php 
					echo $this->Html->link($lastpost['Post']['title'],
						array('controller'=>'posts','action'=>'view',$lastpost['Post']['id']),
						array('class'=>'btn-link')); 
				?>
				</p>
				<p>
					<?php 
						echo $this->Html->image($lastpost['Post']['image'],array('align'=>'left','width'=>'50%','style'=>'padding:0 10px 0 0'));
					?>
					<?php
						if (strlen($lastpost['Post']['body']) > 500) {
							echo substr($lastpost['Post']['body'],0,500).'...'.
								$this->Html->link('See more',array('controller'=>'posts','action'=>'view',$lastpost['Post']['id']),array('class'=>'btn-link')); 
						} else {
							echo $lastpost['Post']['body']; 
						}
					?>
				</p>
				<p class="post-author-date">
				<?php 
					echo 
						'Posted in '.$this->Html->link($lastpost['Category']['name'],array('controller'=>'posts','action'=>'blog','?'=>array('cid'=>$lastpost['Category']['id'],'month'=>null)),array('class'=>'btn-link-red')).
						' / By '.$this->Html->link($lastpost['User']['fullname'],array('controller'=>'posts','action'=>'blog','?'=>array('uid'=>$lastpost['User']['id'])),array('class'=>'btn-link-red')).
						' / on <span style="color: red">'.CakeTime::nice($lastpost['Post']['created']).'</span>'; ?>
				</p>
			</div>
		</div>
	</div>
	<div class="col-xs-12 col-sm-4">
		<div class="well" id="agendaCSI">
			<?php
			if ( count( $csievents ) > 0 ) {
			?>
			<p style="font-size: 18px; font-weight: bold;">Coming Soon</p>
			<?php
				foreach ($csievents as $key => $event) {
			?>
			<div class="row" >
				<div class="col-xs-12" style="padding: 5px">
					<p class=" bg-success" style="padding: 5px">
					<?php
						echo '<big><strong>'.$event['Event']['title'].'</big></strong>';
					?>
					<br>
					<?php
						echo $event['Event']['details'];
					?>
					<br>
					<?php
						echo '<small><em>'.CakeTime::format($event['Event']['start'], '%B %e, %Y %H:%M %p').'</em></small>';
					?>
					</p>
				</div>
			</div>
			<?php
				}
			} else {
			?>
			<p style="font-size: 18px; font-weight: bold;">There is no Events Upcoming</p>
			<?php	
			}
			?>
		</div>
		<div class="well">
			<h4>Quote of the day</h4>
			<p id="quoteText"></p>
			<p class="text-right" style="font-style: italic;" id="quoteAuthor"></p>
		</div>
	</div>
</div>
<script type="text/javascript">
	$.ajax({
		url:"http://quotesondesign.com/api/3.0/api-3.0.json",
		method:'GET',
		dataType: 'json',
		crossDomain: false
	}).done(function(data){
		$('#quoteText').html(data['quote']);
		$('#quoteAuthor').html(data['author']);
	});
</script>
