<div style="padding-top: 15px;">
	<h4>
	<?php
		if ( count($posts) > 0 ) {
			echo $posts[0]['Category']['name'];
		} 
	?>
	</h4>
	<?php
	foreach ($posts as $key => $post) {
	?>	
	<div class="well row" style="margin: 5px;">
		<p class="post-title"><?php echo $this->Html->link($post['Post']['title'],array('controller'=>'posts','action'=>'view',$post['Post']['id']),array('class'=>'btn-link')); ?>
		</p>
		<p class="post-author-date">
		<?php 
			echo 
				'<span style="color: red">'.CakeTime::timeAgoInWords($post['Post']['created'],array('format' => 'F jS, Y', 'end' => '+1 year')).
				'</span> / By '.$this->Html->link($post['User']['fullname'],array('controller'=>'posts','action'=>'blog','?'=>array('uid'=>$post['User']['id'])),array('class'=>'btn-link-red')). 
				' / in '.$this->Html->link($post['Category']['name'],array('controller'=>'posts','action'=>'blog','?'=>array('cid'=>$post['Category']['id'])),array('class'=>'btn-link-red')). 
				' / With <span style="color: red">(0) Comments </span> /' ; 
		?>
		</p>
		<div class="col-xs-3">
			<?php 
				echo $this->Html->image($post['Post']['image'],array('class'=>'img-responsive','style'=>'padding: 5px'));
			?>
		</div>
		<div class="col-xs-9">
			<div style="height: 93px; overflow: hidden;">
			<?php
				echo substr($post['Post']['body'],0,300); 
			?>
			</div>
			<p class="text-right">
			<?php
				echo $this->Html->link('Read more',array('controller'=>'posts','action'=>'view',$post['Post']['id']),array('class'=>'btn btn-sm btn-danger'));
			?>
			</p>
		</div>
	</div>
	<?php
	}
	?>
</div>