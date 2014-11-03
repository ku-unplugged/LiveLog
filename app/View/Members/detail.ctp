<?php
$this->assign('title', h($member['Member']['name']));
?>
<div class="page-header">
	<h1>
		<?php echo h($member['Member']['name']); ?>
		<span class="small">
		<?php if (!empty($member['Member']['nickname']))
			echo ' - ' . h($member['Member']['nickname']); ?>
		<?php if ($auth['id'] === $member['Member']['id'])
			echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>', '/members/edit/' . $auth['id'], array('escape' => false)); ?>
		</span>
	</h1>
</div>
<div class="table-responsive">
	<table class="table table-striped table-condensed">
		<thead>
			<tr>
				<th>Live</th>
				<?php if (date('n') === '11'): // NF期のみ曲順を表示 ?>
				<th>#</th>
				<?php endif; ?>
				<th>Song</th>
				<th>Artist</th>
				<th>Members</th>
				<th><span class="glyphicon glyphicon-play-circle"></span></th>
				<?php if ($auth['admin'] === true): ?>
				<th><span class="glyphicon glyphicon-edit"></span></th>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach($songs as $song): ?>
			<tr>
				<td><?php echo $this->Html->link($song['Live']['name_year'], '/lives/detail/' . $song['Live']['id']); ?></td>
				<?php if (date('n') === '11'):  // NF期のみ曲順を表示 ?>
				<td>
					<?php if (!empty($song['Song']['time'])):?>
						<time datetime="<?php echo h($song['Song']['time']); ?>"><?php echo date('H:i', strtotime($song['Song']['time'])); ?></time>
					<?php endif; ?>
					<?php echo h($song['Song']['order']); ?>
				</td>
				<? endif; ?>
				<td><?php echo h($song['Song']['name']); ?></td>
				<td><?php echo h($song['Song']['artist']); ?></td>
				<td><?php echo $this->element('members', array('members' => $song['Member'])); ?></td>
				<td>
					<?php if (!empty($song['Song']['url'])) {
						echo $this->Html->link(
							'<span class="glyphicon glyphicon-play-circle"></span>',
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
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
