<ul class="list-inline">
	<?php foreach ($members as $member): ?>
	<li><?php echo h($member['MembersSong']['instrument']) . '.' . h(empty($member['nickname']) ? $member['last_name'] : $member['nickname']); ?></li>
	<?php endforeach; ?>
</ul>
