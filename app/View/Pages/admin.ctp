<?php
$this->assign('title', 'Admin');
?>
<div class="page-header">
	<h1>Admin</h1>
</div>
<ul>
	<li class="lead">
		<?php echo $this->Html->link('ライブの追加', array(
			'admin' => true,
			'controller' => 'lives',
			'action' => 'add'
		)); ?>
	</li>
	<li class="lead">
		<?php echo $this->Html->link('メンバーの追加', array(
			'admin' => true,
			'controller' => 'members',
			'action' => 'add'
		)); ?>
	</li>
</ul>
