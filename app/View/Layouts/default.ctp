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

	<link rel="stylesheet" href="<?php echo $this->webroot; ?>bootstrap/css/connect_bootstrap.css">
	<link href="<?php echo $this->webroot ; ?>js/jquery-ui-1.11.4/jquery-ui.css" rel="stylesheet">

	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="<?php echo $this->webroot ; ?>js/jquery-ui-1.11.4/jquery-ui.js"></script>
	<!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

	<!-- Bootstrap  -->
	<script src="<?php echo $this->webroot; ?>bootstrap/js/bootstrap.js"></script>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array(
			'ConnServ_style'));

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<link type="text/css" rel="stylesheet" href="<?php echo $this->webroot; ?>css/jquery-ui.css">
	<style type="text/css">
		/* bootstrap hack: fix content width inside hidden tabs */
		.tab-content > .tab-pane,
		.pill-content > .pill-pane {
		    display: block;     /* undo display:none          */
		    height: 0;          /* height:0 is also invisible */ 
		    overflow-y: hidden; /* no-overflow                */
		}
		.tab-content > .active,
		.pill-content > .active {
		    height: auto;       /* let the content decide it  */
		} /* bootstrap hack end */
	</style>
</head>
<body>
	<div id="container">
		<div id="header">
			<nav class="navbar navbar-inverse navbar-fixed-top">
				<div class="container-fluid" style="max-width: 1200px">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#csimenu" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<?php
						if (isset($logged_in) && $logged_in) {
							echo $this->Html->link( $this->Html->image('logo_inverse.jpg',array('height'=>'30')), '/', array('class'=>'navbar-brand', 'escape'=>false, 'style'=>'margin:-8px')) ;
						?>
					</div>
					<div class="collapse navbar-collapse" id="csimenu">
						<ul class="nav navbar-nav">
							<li>
								<?php echo $this->Html->link('Dashboard', array('controller'=>'users', 'action'=>'dashboard')); ?>
							</li>
							<li>
								<?php echo $this->Html->link('BLOG', array('controller'=>'posts', 'action'=>'blog')); ?>
							</li>
							<?php
							if($isAuthorized) {
							?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									Payroll
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
									<li>
										<?php echo $this->Html->link('Prepare', array('controller'=>'payrolls', 'action'=>'listsales')); ?>
									</li>
									<li>
										<?php echo $this->Html->link('List', array('controller'=>'payrolls', 'action'=>'index')); ?>
									</li>
								</ul>
							</li>
							<?php
							} else {
							?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									Earnings
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
									<li>
										<?php
											echo $this->Html->link('My Payrolls', array('controller'=>'payrolls', 'action'=>'mypayrolls',$objLoggedUser->getID()));
										?>
									</li>
									<li>
										<?php
											echo $this->Html->link('My Savings', array('controller'=>'savings', 'action'=>'mysavings',$objLoggedUser->getID()));
										?>
									</li>
									<li>
										<?php
											echo $this->Html->link('My Advances', array('controller'=>'advances', 'action'=>'myadvances',$objLoggedUser->getID()));
										?>
									</li>
								</ul>
							</li>
							<?php 
							}
							if ($isAuthorized) { 
							?>
							<li>
								<?php 
									echo $this->Html->link('Graphics', array('controller'=>'graphics', 'action'=>'index')); 
								?>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									Support
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
										echo $this->Html->link('Roles', array('controller'=>'roles', 'action'=>'index')); 
									?>
									</li>
									<li>
										<?php 
										  echo $this->Html->link('Services', array('controller'=>'services', 'action'=>'index')); 
										?>
									</li>
									<li>
										<?php 
										  echo $this->Html->link('Regions', array('controller'=>'regions', 'action'=>'index')); 
										?>
									</li>
									<li>
										<?php 
										  echo $this->Html->link('BLOG Categories', array('controller'=>'categories', 'action'=>'index')); 
										?>
									</li>
									<li>
										<?php 
										  echo $this->Html->link('Event Types', array('controller'=>'eventtypes', 'action'=>'index')); 
										?>
									</li>
								</ul>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									Admin
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
									<li>
									<?php 
										echo $this->Html->link('Advances', array('controller'=>'advances', 'action'=>'index')); 
									?>
									</li>
									<li>
									<?php 
										echo $this->Html->link('Applicants', array('controller'=>'applicants', 'action'=>'index')); 
									?>
									</li>
									<li>
										<?php 
										  echo $this->Html->link('BLOG', array('controller'=>'posts', 'action'=>'index')); 
										?>
									</li>
									<li>
										<?php 
										  echo $this->Html->link('Customers', array('controller'=>'customers', 'action'=>'index')); 
										?>
									</li>
									<li>
										<?php 
										  echo $this->Html->link('PayRoll List', array('controller'=>'payrolls', 'action'=>'index')); 
										?>
									</li>
									<li>
										<?php 
										  echo $this->Html->link('Sales', array('controller'=>'sales', 'action'=>'index')); 
										?>
									</li>
									<li>
									<?php 
										echo $this->Html->link('Savings', array('controller'=>'savings', 'action'=>'index')); 
									?>
									</li>
								</ul>
							</li>
							<?php } ?>
							<?php
							if (Authcomponent::User('role_id') !='7') {	?>
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
											echo $this->Html->link('Not Comissioned Sales', array('controller'=>'sales','action'=>'allsales')); 
									?>
									</li>
									<li>
									<?php
											echo $this->Html->link('Charge Back', array('controller'=>'sales','action'=>'chargeback')); 
									?>
									</li>
									<?php
										}
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
									<?php
										echo $this->Html->link('Week',array('controller'=>'events','action'=>'weeklyAgenda',date('Y-m-d',strtotime($today)))); 
									?>
									</li>
									<li>
									<?php
										echo $this->Html->link('Day',array('controller'=>'events','action'=>'dairyAgendaNew',date('Y-m-d',strtotime($today)))); 
									?>
									</li>
								</ul>
							</li>
							<li class="dropdown pull-right">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">
									<?php echo $username ; ?>
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
									<li>
									<?php echo $this->Html->link('Profile', array('controller'=>'users','action'=>'edit',$objLoggedUser->GetID())); ?>
									</li>
									<li>
									<?php echo $this->Html->link('Logout', array('controller'=>'users','action'=>'logout')); ?>
									</li>
							  	</ul>
							</li>
						</ul>
						<?php
							}
						}
						else 
						{
							echo $this->Html->link( $this->Html->image('logo_inverse.jpg',array('height'=>'30')), '/', array('class'=>'navbar-brand', 'escape'=>false, 'style'=>'margin:-8px')) ;
						?>
					</div>
					<div class="collapse navbar-collapse" id="csimenu">
						<ul class="nav navbar-nav">
							<li>
								<?php echo $this->Html->link('Applicant', array('controller'=>'applicants', 'action'=>'add')) ?>
							</li>
							<li>
							<?php echo $this->Html->link('About Us', '#'); ?>
							</li>
						</ul>
						<?php
						} 
						?>
					</div>
				</div><!-- /.container -->
			</nav>
		</div>
		<div id="content">
			<div class="container">
				<?php //echo $this->Session->flash(); ?>
				<?php echo $this->fetch('content'); ?>
			</div>
		</div>
		<div id="footer">
			<div class="navbar-inverse navbar-fixed-bottom" style="height: 30px !important;">
				<div class="container-fluid text-center" style="max-width: 1200px; color: white">
					<small><em>© 2009 by Connect Services, Inc.</em></small><br>
					<span class="pull-right" style="font-size: 8px; margin-bottom: 3px"><em>by Oldemar Vieira</em></span>
				</div>
			</div>
		</div>
	</div>
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>
