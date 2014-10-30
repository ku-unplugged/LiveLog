<ul class="list-inline">
	<?php foreach ($members as $member): ?>
	<li>
		<?php
		echo h($member['MembersSong']['instrument']) . '.';
		if (isset($auth)) {
			echo $this->Html->link(
				empty($member['nickname']) ? h($member['last_name']) : h($member['nickname']),
				'/members/detail/' . $member['id']
			);
		} else {
			echo h(empty($member['nickname']) ? $member['last_name'] : $member['nickname']);
		}
		?>
	</li>
	<?php endforeach; ?>
</ul>
