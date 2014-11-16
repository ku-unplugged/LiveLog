<?php
$this->assign('title', 'Admin');
?>
<div class="page-header">
	<h1>Admin</h1>
</div>
<p>
	<?php echo $this->Html->link('過去のセットリスト', 'http://ku-unplugged.net/old/lives/live_index.html', array('target' => '_blank')); ?>はいつでも追加していただいて大丈夫です。<br>
	ただし，曲単位ではなくライブ単位での追加をお願いします。<br>
</p>
<p>
	また，2011年度以前は楽器の情報がなかったので，間違いに気がついた方は修正をお願いします。
</p>
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
	<li class="lead">
		<?php echo $this->Html->link('曲の追加', array(
			'admin' => true,
			'controller' => 'songs',
			'action' => 'add'
		)); ?>
	</li>
	<li class="lead">
		<?php echo $this->Html->link('曲の追加（NF専用）', array(
			'admin' => true,
			'controller' => 'songs',
			'action' => 'add_nf'
		)); ?>
	</li>
</ul>
