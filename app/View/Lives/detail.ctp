<div class="page-header">
	<h1>
		<?php echo h($songs[0]['Live']['name']); ?>
		<span class="small text-left">
			- <?php echo $this->element('time', array('date' => $songs[0]['Live']['date'])) . '@' . $songs[0]['Live']['place']; ?>
		</span>
	</h1>
</div>
<ol>
	<?php foreach($songs as $list): ?>
	<li>
		<?php echo h($list['Song']['name']) . ' / ' . h($list['Song']['artist']); ?>
		<ul class="list-inline">
			<?php foreach($list['Member'] as $member): ?>
				<li><?php echo h($member['MembersSong']['instrument']) . '.' . h($member['last_name']); ?></li>
			<?php endforeach; ?>
		</ul>
	</li>
	<?php endforeach; ?>
</ol>
