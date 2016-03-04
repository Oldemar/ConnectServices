<?php 
//	echo '<pre>'.print_r($postsbycategory,true).'</pre>';
?>

<div class="row" style="padding-top: 20px;">
	<div class="col-xs-12" style="border-bottom: 1px solid #ddd;">
		<h4>Categories</h4>
		<?php
		foreach ($postsbycategory as $key => $category) {
		?>
			<p style="padding-left: 15px;">
			<?php
				if ( count($category['Post']) > 0 ) {
					echo $this->Html->link($category['Category']['name'].' ('.count($category['Post']).')',array('controller'=>'posts','action'=>'blog','?'=>array('cid'=>$category['Category']['id'],'month'=>null)), array('btn-link')); 
				} else {
					echo $category['Category']['name'].' ('.count($category['Post']).')';
				} 
			?>
			</p>
		<?php
		}
		?>
	</div>
</div>

