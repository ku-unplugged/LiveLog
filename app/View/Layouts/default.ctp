<?php
/**
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

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<?php
		echo $this->Html->charset();
		echo $this->Html->meta(array('http-equiv' => 'X-UA-Compatible', 'content' => 'IE=edge'));
		echo $this->Html->meta(array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1'));
	?>
	<title>
		<?php echo $this->fetch('title'); ?> - LiveLog
	</title>
	<?php
		// echo $this->Html->meta('icon');

		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('main');
		echo $this->Html->script(array('jquery.min', 'bootstrap.min', 'analytics'));

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<link rel="apple-touch-icon" sizes="57x57" href="icons/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="icons/apple-touch-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="icons/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="icons/apple-touch-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="icons/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="icons/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="icons/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="icons/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="icons/apple-touch-icon-180x180.png">
	<link rel="icon" type="image/png" href="icons/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="icons/favicon-194x194.png" sizes="194x194">
	<link rel="icon" type="image/png" href="icons/favicon-96x96.png" sizes="96x96">
	<link rel="icon" type="image/png" href="icons/android-chrome-192x192.png" sizes="192x192">
	<link rel="icon" type="image/png" href="icons/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="icons/manifest.json">
	<link rel="shortcut icon" href="icons/favicon.ico">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-TileImage" content="icons/mstile-144x144.png">
	<meta name="msapplication-config" content="icons/browserconfig.xml">
	<meta name="theme-color" content="#f0ad4e">
</head>
<body>
	<nav class="navbar navbar-livelog" role="navigation">
		<div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<?php echo $this->Html->link('LiveLog', '/', array('class' => 'navbar-brand')); ?>
			</div>

			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="navbar-collapse">
			<ul class="nav navbar-nav">
				<li<?php echo $this->request->controller === 'songs' ? ' class="active"' : '' ?>>
					<?php echo $this->Html->link('Song Search', '/songs'); ?>
				</li>
				<li<?php echo $this->request->controller === 'lives' ? ' class="active"' : '' ?>>
					<?php echo $this->Html->link('Live List', '/lives'); ?>
				</li>
<?php if (isset($auth)): // ログインしていれば ?>
				<li<?php echo $this->request->controller === 'members' ? ' class="active"' : '' ?>>
					<?php echo $this->Html->link('Members', '/members'); ?>
				</li>
				<li class="dropdown<?php echo $this->request->controller === 'statistics' ? ' active' : '' ?>">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Statistics <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li><?php echo $this->Html->link('年度ごと', '/statistics'); ?></li>
						<li><?php echo $this->Html->link('回生ごと', '/statistics/member'); ?></li>
						<li><?php echo $this->Html->link('自分', '/statistics/me'); ?></li>
					</ul>
				</li>
	<?php if ($auth['admin'] === true): // 管理者ならば?>
				<li<?php echo isset($this->request->params['admin']) ? ' class="active"' : '' ?>>
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Admin <span class="caret"></span></a>
					<ul class="dropdown-menu" role="menu">
						<li class="dropdown-header">Add</li>
						<li><?php echo $this->Html->link('Member', '/admin/members/add'); ?></li>
						<li><?php echo $this->Html->link('Live', '/admin/lives/add'); ?></li>
						<li><?php echo $this->Html->link('Song', '/admin/songs/add'); ?></li>
						<li><?php echo $this->Html->link('Song (NF)', '/admin/songs/add_nf'); ?></li>
						<li><?php echo $this->Html->link('Admin', '/admin/members/edit_admin'); ?></li>
					</ul>
				</li>
	<?php endif; ?>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><?php echo $this->Html->link($auth['name'], '/members/detail/' . $auth['id']); ?></li>
				<li><?php echo $this->Html->link('Log Out', '/members/logout'); ?></li>
			</ul>
<?php else: // ログインしていなければ ?>
			</ul>
			<?php echo $this->Html->link(
				'<button type="button" class="btn btn-info navbar-btn navbar-right">新規登録</button>',
				'/members/confirm',
				array('escape' => false)
			); ?>
			<?php echo $this->Form->create('Member', array(
				'url' => array(
					'controller' => 'members',
					'action' => 'login'
				),
				'inputDefaults' => array(
					'div' => 'form-group',
					'label' => false,
					'wrapInput' => false,
					'class' => 'form-control'
				),
				'class' => 'navbar-form navbar-right',
			)); ?>
			<?php echo $this->Form->input('email', array(
				'placeholder' => 'email'
			)); ?>
			<?php echo $this->Form->input('password', array(
				'placeholder' => 'password'
			)); ?>
			<?php echo $this->Form->submit('Log In', array(
				'div' => false,
				'class' => 'btn btn-default'
			)); ?>
			<?php echo $this->Form->end(); ?>
<?php endif; ?>
			</div><!-- /.navbar-collapse -->
		</div><!-- /.container -->
	</nav>
	<div class="container">
		<section>
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Session->flash('auth'); ?>
			<?php echo $this->fetch('content'); ?>
		</section>
		<footer>
			<p class="text-center"><small>&copy; 2014 <?php echo $this->Html->link('京大アンプラグド', 'http://ku-unplugged.net/', array('target' => '_blank')); ?></small></p>
		</footer>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
