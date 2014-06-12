<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'Connect Services');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<link type="text/css" rel="stylesheet" href="<? echo $this->webroot; ?>bootstrap/css/bootstrap.css">
	<link href="<?php echo $this->webroot ; ?>bootstrap/css/bootstrap-glyphicons.css" rel="stylesheet">

	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

<? /*	 
	<script type="text/javascript" src="<? echo $this->webroot; ?>js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="<? echo $this->webroot; ?>js/jquery-ui.js"></script>
*/ ?>
	<!-- Bootstrap  -->
	<script type="text/javascript" src="<? echo $this->webroot; ?>bootstrap/js/bootstrap.js"></script>

	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array(
			'ConnServ_style',
			'blue'));

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<link type="text/css" rel="stylesheet" href="<? echo $this->webroot; ?>css/jquery-ui.css">
</head>
<body>
	<div id="container">
		<div id="header">
			<div class="navbar navbar-inverse navbar-fixed-top">
				<div class="container">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-inverse-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<?php
						if (isset($logged_in) && $logged_in) {
							echo $this->Html->link( $cakeDescription, array('controller'=>'users', 'action'=>'dashboard'), array('class'=>'navbar-brand')) ;
					?>
					<ul class="nav navbar-nav">
						<li>
							<? echo $this->Html->link('Dashboard', array('controller'=>'users', 'action'=>'dashboard')); ?>
						</li>
						<?
							if(Authcomponent::User('role_id') == 8) {
						?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Developer<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>
									<?php 
										echo $this->Html->link('Users', array('controller'=>'Users')); 
									?>
								</li>
								<li>
									<?php 
										echo $this->Html->link('Log', array('controller'=>'logs')); 
									?>
							</ul>
						</li>
						<?
						}
						if (in_array(Authcomponent::User('role_id'), array('1','2','4','8'))) {
						?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Pay Roll<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>
									<?php 
										echo $this->Html->link('Not Comissioned ', array('controller'=>'sales','action'=>'listsales','Payroll')); 
									?>
								</li>
								<li>
									<?php 
										echo $this->Html->link('List Payrolls', array('controller'=>'payrolls','action'=>'index')); 
									?>
								</li>
							</ul>
						</li>
						<?
						}
						if (in_array(Authcomponent::User('role_id'), array('1','2','4','8','9'))) {
						?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">Advances<b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>
									<?php 
										echo $this->Html->link('Not Comissioned ', array('controller'=>'sales','action'=>'listsales','Advance')); 
									?>
								</li>
								<li>
									<?php 
										echo $this->Html->link('List Advances', array('controller'=>'advances','action'=>'index')); 
									?>
								</li>
							</ul>
						</li>
						<?
						}
						if($isAuthorized) {
						?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								Admin
								<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li>
								<?php 
									echo $this->Html->link('Users', array('controller'=>'users', 'action'=>'index')); 
								?>
								</li>
								<li>
									<?php 
									  echo $this->Html->link('Sales', array('controller'=>'sales', 'action'=>'index')); 
									?>
								</li>
								<li>
								<?php 
									echo $this->Html->link('Roles', array('controller'=>'roles', 'action'=>'index')); 
								?>
								</li>
								<li>
								<?php 
									echo $this->Html->link('Savings', array('controller'=>'savings', 'action'=>'index')); 
								?>
								</li>
								<li>
									<?php 
									  echo $this->Html->link('Sales', array('controller'=>'sales', 'action'=>'index')); 
									?>
								</li>
								<li>
									<?php 
									  echo $this->Html->link('Services', array('controller'=>'services', 'action'=>'index')); 
									?>
								</li>
								<li>
									<?php 
									  echo $this->Html->link('Carriers', array('controller'=>'carriers', 'action'=>'index')); 
									?>
								</li>
								<li>
									<?php 
									  echo $this->Html->link('Comissions', array('controller'=>'comissions', 'action'=>'index')); 
									?>
								</li>
								<li>
									<?php 
									  echo $this->Html->link('Customers', array('controller'=>'customers', 'action'=>'index')); 
									?>
								</li>
								<li>
									<?php 
									  echo $this->Html->link('Pay Rolls', array('controller'=>'payrolls','action'=>'index')); 
									?>
								</li>
							</ul>
						</li>
						<?
							}
						?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								Sales
								<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li>
									<?php 
										echo $this->Html->link('New Sale', array('controller'=>'sales','action'=>'add')); 
									?>
								</li>
								<?php
									if ( !in_array($objLoggedUser->getAttr('role_id'), array('1', '8', '9')) )
									{
								?>
								<li>
									<?php
										echo $this->Html->link('My Sales', array('controller'=>'sales','action'=>'mysales')); 
									?>
								</li>
								<?php
									}
									if ( !in_array($objLoggedUser->getAttr('role_id'), array('6', '7')) )
									{
								?>
								<li>
								<?php
										echo $this->Html->link('All Sales', array('controller'=>'sales','action'=>'allsales')); 
									}
								?>
								</li>
								<?
								if ($objLoggedUser->getAttr('role_id') != '2')
								{
								?>
								<li>
									<?php 
									if (in_array($objLoggedUser->getAttr('role_id'), array('5','6'))) 
										echo $this->Html->link('My PayRoll', '#'); 
									?>
								</li>
								<?
								}
								?>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								Customer<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li>
								<?
									echo $this->Html->link('List',array('controller'=>'customers','action'=>'index')); 
								?>
								</li>
								<li>
								<?
									echo $this->Html->link('New',array('controller'=>'customers','action'=>'add')); 
								?>
								</li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								Agenda<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li>
								<?
									echo $this->Html->link('Week',array('controller'=>'events','action'=>'weeklyAgenda',date('Y-m-d',strtotime($today)))); 
								?>
								</li>
								<li>
								<?
									echo $this->Html->link('Day',array('controller'=>'events','action'=>'dairyAgenda',date('Y-m-d',strtotime($today)))); 
								?>
								</li>
							</ul>
						</li>
						<li class="dropdown pull-right">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<? echo $username ; ?>
								<b class="caret"></b>
							</a>
							<ul class="dropdown-menu">
								<li>
								<? echo $this->Html->link('Profile', array('controller'=>'users','action'=>'edit',$objLoggedUser->GetID())); ?>
								</li>
								<li>
								<? echo $this->Html->link('Logout', array('controller'=>'users','action'=>'logout')); ?>
								</li>
						  	</ul>
						</li>
					</ul>
					<? 
					} 
					else 
					{
						echo $this->Html->link( $cakeDescription, '/', array('class'=>'navbar-brand')) ;

					?>
					<ul class="nav navbar-nav">
						<li>
						<? echo $this->Html->link('About Us', '#'); ?>
						</li>
					</ul>
					<?php
					} 
					?>
				</div><!-- /.container -->
			</div>
		</div>
		<div id="content">
			<div class="container">
				<?php //echo $this->Session->flash(); ?>
				<?php echo $this->fetch('content'); ?>
			</div>
		</div>
		<div id="footer">
		</div>
	</div>
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>
