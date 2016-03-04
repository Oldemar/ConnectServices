<div class="row">
	<div class="col-xs-12">
		<h4>Search</h4>
		<?php 
			echo $this->Form2->create('Search', array(
				'class'=>'form-inline',
				'id'=>'formSearch'
				));
			echo $this->Form2->input('search',array(
				'class'=>'form-control',
				'placeholder'=>'Type something...',
				'label'=>false,
				'div'=>false
				));
			echo '    ';
			echo $this->Form2->button('Search',array(
				'type'=>'submit',
				'class'=>'btn btn-md btn-primary'
				));
		?>
	</div>
</div>