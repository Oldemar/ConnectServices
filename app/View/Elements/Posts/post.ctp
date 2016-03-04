<div class="row" style="padding: 10px">
	<div class="well col-xs-12">
		<p class="post-title"><?php echo $post['Post']['title']; ?></p>
		<p class="post-author-date">
		<?php 
			echo 
				'Posted in '.$this->Html->link($post['Category']['name'],array('controller'=>'posts','action'=>'blog','?'=>array('cid'=>$post['Category']['id'])),array('class'=>'btn-link-red')).
				' / By '.$this->Html->link($post['User']['fullname'],array('controller'=>'posts','action'=>'blog','?'=>array('uid'=>$post['User']['id'])),array('class'=>'btn-link-red')).
				' / on <span style="color: red">'.CakeTime::nice($post['Post']['created']).'</span>'; ?>
		</p>
		<p>
			<?php 
				echo $this->Html->image($post['Post']['image'],array('align'=>'left','width'=>'50%','style'=>'padding:0 10px 0 0'));
			?>
			<?php
				echo $post['Post']['body']; 
			?>
		</p>
	</div>
</div>

