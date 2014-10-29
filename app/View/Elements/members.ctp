<ul class="list-inline">
	<?php foreach($members as $member): ?>
	<li><?php echo h($member['MembersSong']['instrument']) . '.' . h($member['last_name']); ?></li>
	<?php endforeach; ?>
</ul>
