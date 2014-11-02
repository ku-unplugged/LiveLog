<?php
$this->assign('title', h($songs[0]['Live']['name_year']));
?>
<div class="page-header">
	<h1>
		<?php echo h($songs[0]['Live']['name']); ?>
		<span class="small">
			- <?php echo $this->element('time', array('date' => $songs[0]['Live']['date'])) . '@' . h($songs[0]['Live']['place']); ?>
		</span>
	</h1>
</div>
<?php if (empty($songs[0]['Song']['time'])): // 最初の曲にNF用のtimeフィールドが設定されていなければ ?>
<ol>
	<?php foreach ($songs as $song): ?>
	<li class="lead">
		<?php echo h($song['Song']['name']) . ' / ' . h($song['Song']['artist']); ?>
		<small>
		<?php if (isset($auth) && !empty($song['Song']['url'])) { // ログインしていてかつURLが空でなければ
			echo $this->Html->link(
				'<span class="glyphicon glyphicon-play-circle"></span>',
				$song['Song']['url'],
				array('escape' => false, 'target' => '_blank')
			); // 動画へのリンクを表示
		} ?>
		<?php if (isset($auth) && $auth['admin'] === true) { // 管理者ならば
			echo $this->Html->link(
				'<span class="glyphicon glyphicon-edit"></span>',
				array('admin' => true, 'controller' => 'songs', 'action' => 'edit', $song['Song']['id']),
				array('escape' => false)
			); // 編集画面へのリンクを表示
		} ?>
	</small>
		<?php echo $this->element('members', array('members' => $song['Member'])); ?>
	</li>
	<?php endforeach; ?>
</ol>
<?php else: // NFであれば ?>
<div class="table-responsive">
	<table class="table table-striped table-condensed">
		<thead>
			<tr>
				<th>Time</th>
				<th>Order</th>
				<th>Song</th>
				<th>Artist</th>
				<th>Members</th>
				<?php if(isset($auth)): ?>
				<th><span class="glyphicon glyphicon-play-circle"></span></th>
				<?php if ($auth['admin'] === true): ?>
				<th><span class="glyphicon glyphicon-edit"></span></th>
				<?php endif; ?>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach($songs as $song): ?>
			<tr>
				<td><time datetime="<?php echo h($song['Song']['time']); ?>"><?php echo date('H:i', strtotime($song['Song']['time'])); ?></time></td>
				<td><?php echo h($song['Song']['order']); ?></td>
				<td><?php echo h($song['Song']['name']); ?></td>
				<td><?php echo h($song['Song']['artist']); ?></td>
				<td><?php echo $this->element('members', array('members' => $song['Member'])); ?></td>
				<?php if(isset($auth)): ?>
				<td>
					<?php if (!empty($song['Song']['url'])) {
						echo $this->Html->link('<span class="glyphicon glyphicon-play-circle"></span>',
							$song['Song']['url'],
							array('escape' => false, 'target' => '_blank')
						);
					} ?>
				</td>
				<?php if ($auth['admin'] === true): ?>
				<td>
					<?php echo $this->Html->link(
						'<span class="glyphicon glyphicon-edit"></span>',
						array('admin' => true, 'controller' => 'songs', 'action' => 'edit', $song['Song']['id']),
						array('escape' => false)
					); ?>
				</td>
				<?php endif; ?>
				<?php endif; ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php endif; ?>
