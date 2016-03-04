<div class="row" style="padding: 10px">
	<div class="col-xs-12 col-sm-8">
	<?php
		echo $this->element('Posts/posts',array('posts'=>$posts));
	?>
	</div>
	<div class="col-sm-4">
		<div class="row">
			<div class="col-sm-12">
			<?php
				echo $this->element('Posts/recents',array('posts'=>$posts));
			?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
			<?php
				echo $this->element('Posts/categories',array('postsbycategory'=>$postsbycategory));
			?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
			<?php
				echo $this->element('Posts/archive',array('postsbymonth'=>$postsbymonth));
			?>
			</div>
		</div>
	</div>
</div>
