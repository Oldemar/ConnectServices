<?php
if (isset($logged_in) && $logged_in) {
    header('Location:'.Router::url(array('controller'=>'users','action'=>'dashboard')));
}
else 
{
?>
<?php 
    echo $this->Session->flash();
    echo $this->Form->create('User', array(
        'action'=>'login',
        'class'=>'form-signin', 
        'role'=>'form'
        )); 
    ?>
    <h2 class="form-signin-heading text-center">Please log in</h2>
    <?php
    echo $this->Form->input('username', array(
        'type'=>'text',
        'label'=>false,
        'class'=>"form-control",
        'placeholder'=>"Type your username"
        ));  
    echo $this->Form->input('password', array(
        'label'=>false,
        'class'=>"form-control"
        ));
    echo $this->Form->input('login',array(
        'type'=>'submit',
        'label'=>false,
        'value'=>'Login',
        'class'=>'btn btn-lg btn-primary btn-block'
        ));
    ?>
    <h2 class="form-signin-heading text-center">Or</h2>
    <p>
    <?php 
        echo $this->Html->link('Sign Up',array('action'=>'add','controller'=>'users'), array('class'=>'btn btn-lg btn-success btn-block'));
        echo $this->Form->end();
    ?>
    <br clear="all"><br clear="all">
 
<?php
}
?>
</p>