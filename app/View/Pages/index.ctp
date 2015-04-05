<?php
$this->assign('title', 'Home');
?>
<div class="text-center jumbotron">
	<h1>
		<img src="img/logo.png" alt="LiveLog" class="center-block img-responsive">
	</h1>
	<p>
		京都大学を中心に活動するアコースティック軽音サークル<br>
		「<?php echo $this->Html->link('京大アンプラグド', 'http://ku-unplugged.net/', array('target' => '_blank')); ?>」のセットリスト検索システムです。
	</p>
	<?php if (!isset($auth)) : ?>
	<p>
		<?php echo $this->Html->link('新規登録（会員のみ）', '/members/confirm', array(
			'class' => 'btn btn-info btn-lg',
			'role' => 'button'
		)) ?>
	</p>
</div>
<div class="page-header">
	<h2>Membership</h2>
</div>
<p>
	ユーザ登録は，<?php echo $this->Html->link('京大アンプラグド', 'http://ku-unplugged.net/', array('target' => '_blank')); ?>のメンバーしか行うことができません。<br>
</p>
<p>
	ただし，ユーザ登録をしなくても，
	<ul>
		<li>曲名・アーティスト名から過去の演奏を検索する「<?php echo $this->Html->link('Song Search', '/songs'); ?>」</li>
		<li>ライブごとのセットリストを表示する「<?php echo $this->Html->link('Live List', '/lives'); ?>」</li>
	</ul>
	を利用できます。
</p>
<p>
	また，ユーザ登録をすると，
	<ul>
		<li>全メンバーの一覧や各メンバーの演奏履歴を表示する「Members」</li>
		<li>京大アンプラグドに関する様々な統計を見ることができる「Statistics」</li>
		<li>各ライブの演奏動画</li>
	</ul>
	を利用できるようになります。
</p>
<?php else : ?>
</div>
<?php endif; ?>
