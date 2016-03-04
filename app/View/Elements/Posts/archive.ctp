<?php 
//	echo '<pre>'.print_r($postsbymonth,true).'</pre>';
?>
<div class="row" style="padding-top: 20px;">
	<div class="col-xs-12" style="border-bottom: 1px solid #ddd;">
		<h4>Archive</h4>
		<?php
		$arrMonth = array('','January','February','March','April','May','June','July','August','September','October','November','December');
		foreach ($postsbymonth as $key => $month) {
		?>
			<p style="padding-left: 15px;">
			<?php echo $this->Html->link($arrMonth[$month[0]['month']].' ('.count($month[0]['total']).')',array('controller'=>'posts','action'=>'blog','?'=>array('cid'=>null,'month'=>$month[0]['month'])), array('btn-link')); ?>
			</p>
		<?php
		}
		?>
	</div>
</div>
