<?php 
//	echo '<pre>'.print_r($posts,true).'</pre>';
?>
<div class="row" style="padding-top: 20px;">
	<div class="col-xs-12">
		<h4>Recents</h4>
		<?php
		foreach ($recentposts as $key => $recent) {
		?>
		<div class="row" style="border-bottom: 1px solid #ddd; padding: 5px 0">
			<div class="col-xs-4">
			<?php
				echo $this->Html->image($recent['Post']['image'], array('class'=>'img-responsive'));
			?>
			</div>
			<div class="col-xs-8">
			<?php
				echo '<big>'.$this->Html->link($recent['Post']['title'],array('controller'=>'posts','action'=>'view',$recent['Post']['id'])).'</big>';
			?>
			</div>
		</div>
		<?php
		}
		?>
	</div>
</div>

