<div class="page-header">
	<h1>
		<?php echo h($songs[0]['Live']['name']); ?>
		<span class="small text-left">
			- <?php echo $this->element('time', array('date' => $songs[0]['Live']['date'])) . '@' . $songs[0]['Live']['place']; ?>
		</span>
	</h1>
</div>
<ol>
	<?php foreach($songs as $song): ?>
	<li>
		<?php echo h($song['Song']['name']) . ' / ' . h($song['Song']['artist']); ?>
		<?php echo $this->element('members', array('members' => $song['Member'])); ?>
	</li>
	<?php endforeach; ?>
</ol>
