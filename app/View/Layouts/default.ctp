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
		echo $this->Html->meta('icon');

		// Bootstrap
		// echo $this->Html->css('cake.generic');
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->script(array('jquery.min', 'bootstrap.min'));

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		echo $this->Html->script('analytics');
	?>
	<style>
		.navbar-form.navbar-right:last-child { margin-right: 0; }
		td .list-inline { margin-bottom: 0; }
	</style>
</head>
<body>
	<nav class="navbar navbar-inverse" role="navigation">
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
				<?php if ($auth['admin'] === true): // 管理者ならば?>
				<li<?php echo isset($this->request->params['admin']) ? ' class="active"' : '' ?>>
					<?php echo $this->Html->link('Admin', '/pages/admin'); ?>
				<?php endif; ?>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li>
					<?php echo $this->Html->link($auth['name'], '/members/detail/' . $auth['id']); ?>
				</li>
				<li><?php echo $this->Html->link('Sign Out', '/members/logout'); ?></li>
			</ul>
			<?php else: // ログインしていなければ ?>
			</ul>
			<?php echo $this->Html->link(
				'<button type="button" class="btn btn-info navbar-btn navbar-right">Sign Up</button>',
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
			<?php echo $this->Form->submit('Sign In', array(
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
