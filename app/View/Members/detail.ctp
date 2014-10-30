<?php
$this->assign('title', h($member['Member']['name']));
?>
<div class="page-header">
	<h1>
		<?php echo h($member['Member']['name']); ?>
		<?php if (!empty($member['Member']['nickname'])) {
			echo '<span class="small"> - ' . h($member['Member']['nickname']) . '</span>';
		} ?>
	</h1>
</div>
<table class="table table-hover">
	<thead>
		<tr>
			<th>Date</th>
			<th>Live</th>
			<th>Song</th>
			<th>Artist</th>
			<th>Members</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($songs as $song): ?>
		<tr<?php if (isset($auth) && !empty($song['Song']['url'])) echo ' data-href="' . h($song['Song']['url']) . '"'; ?>>
			<td><?php echo $this->element('time', array('date' => $song['Live']['date'])) ?></td>
			<td><?php echo h($song['Live']['name']); ?></td>
			<td><?php echo h($song['Song']['name']); ?></td>
			<td><?php echo h($song['Song']['artist']); ?></td>
			<td><?php echo $this->element('members', array('members' => $song['Member'])); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
