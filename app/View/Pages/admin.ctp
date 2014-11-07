<?php
$this->assign('title', 'Admin');
?>
<div class="page-header">
	<h1>Admin</h1>
</div>
<p>
	過去のセットリストはいつでも追加していただいて大丈夫です。<br>
	ただし，曲単位ではなくライブ単位での追加をお願いします。<br>
	URLの欄は三吉まで連絡いただければ，後で編集しておきます。
</p>
<p>
	また，2011年度のNFは楽器の情報がなかったので，編成が分かる曲があれば修正をお願いします。
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
