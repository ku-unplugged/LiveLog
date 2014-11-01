<?php
$this->assign('title', h($songs[0]['Live']['name_year']));
?>
<div class="page-header">
	<h1>
		<?php echo h($songs[0]['Live']['name']); ?>
		<span class="small">
			- <?php echo $this->element('time', array('date' => $songs[0]['Live']['date'])) . '@' . $songs[0]['Live']['place']; ?>
		</span>
	</h1>
</div>
<?php if (empty($songs[0]['Song']['time'])): ?>
<ol>
	<?php foreach ($songs as $song): ?>
	<li class="lead">
		<?php echo h($song['Song']['name']) . ' / ' . h($song['Song']['artist']); ?>
		<?php if (isset($auth) && !empty($song['Song']['url'])) {
			echo $this->Html->link('<span class="glyphicon glyphicon-play-circle"></span>', $song['Song']['url'], array('escape' => false, 'target' => '_blank'));
		} ?>
		<?php echo $this->element('members', array('members' => $song['Member'])); ?>
	</li>
	<?php endforeach; ?>
</ol>
<?php else: ?>
<div class="table-responsive">
	<table class="table table-striped">
		<thead>
			<tr>
				<th>Time</th>
				<th>Order</th>
				<th>Song</th>
				<th>Artist</th>
				<th>Members</th>
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
				<td class="text-center">
					<?php if (!empty($song['Song']['url'])) {
						echo $this->Html->link('<span class="glyphicon glyphicon-play-circle"></span>', $song['Song']['url'], array('escape' => false, 'target' => '_blank'));
					} ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
<?php endif; ?>
