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
