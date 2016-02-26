<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<?php
//	echo '<pre>'.print_r($lastpost,true).'</pre>';
//	echo '<pre>'.print_r($salesByUsers,true).'</pre>';
?>
<div class="row" style="padding: 10px">
	<div class="col-xs-12 col-sm-6">
		<div class="well" id="lastPost" style="min-height:350px">
			<p>
				<?php 
					echo $this->Html->image($lastpost['Post']['image'],array('align'=>'left','width'=>'50%','style'=>'padding:0 10px 0 0'));
				?>
				<span class="post-title"><?php echo $lastpost['Post']['title']; ?></span><br><br>
				<?php
					if (strlen($lastpost['Post']['body']) > 500) {
						echo substr($lastpost['Post']['body'],0,500).'...'.$this->Html->link('See More...',array('controller'=>'pages','action'=>'blog')); 
					} else {
						echo $lastpost['Post']['body']; 
					}
				?>
			</p>
			<p class="post-author-date">
				<?php echo 'By '.$lastpost['User']['fullname'].' on '.CakeTime::nice($lastpost['Post']['created']); ?>
			</p>
		</p>
		</div>
	</div>
	<div class="col-xs-12 col-sm-6">
		<div class="well" id="agendaCSI" style="min-height: 350px;">
			<p style="font-size: 18px; font-weight: bold;">Coming Soon</p>
			<?php
			if ( count( $csievents ) > 0 ) {
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
			}
			?>
		</div>
	</div>
</div>
