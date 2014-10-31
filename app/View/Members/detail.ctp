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
<table class="table table-striped">
	<thead>
		<tr>
			<th>Date</th>
			<th>Live</th>
			<th>Song</th>
			<th>Artist</th>
			<th>Members</th>
			<th>Video</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($songs as $song): ?>
		<tr>
			<td><?php echo $this->element('time', array('date' => $song['Live']['date'])) ?></td>
			<td><?php echo $this->Html->link($song['Live']['name'], '/lives/detail/' . $song['Live']['id']); ?></td>
			<td><?php echo h($song['Song']['name']); ?></td>
			<td><?php echo h($song['Song']['artist']); ?></td>
			<td><?php echo $this->element('members', array('members' => $song['Member'])); ?></td>
			<td class="text-center">
				<?php if (!empty($song['Song']['url'])) {
					echo $this->Html->link('<span class="glyphicon glyphicon-play-circle"></span>', $song['Song']['url'], array('escape' => false, 'target' => '_blank'));
				} ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
