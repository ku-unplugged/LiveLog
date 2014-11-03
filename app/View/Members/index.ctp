<?php
$this->assign('title', 'Members');
?>
<div class="page-header">
	<h1>Members</h1>
</div>
<div class="row">
	<?php
	// 入部年度 year と i を初期化
	$year = (int)$members['0']['Member']['year'];
	$i = 0;
	?>
	<div class="col-sm-3">
		<h2><?php echo h($year); ?></h2>
		<ol>
<?php foreach ($members as $member) : ?>
<?php if ($year !== (int)$member['Member']['year']): $year = (int)$member['Member']['year']; $i++; // 入部年度異なればdiv.col-sm-3を閉じて新たな入部年度を表示 ?>
		</ol>
	</div>
<?php if ($i % 4 === 0): // 4年毎にdiv.rowを閉じる ?>
</div>
<div class="row">
<?php endif; ?>
	<div class="col-sm-3">
		<h2><?php echo h($year); ?></h2>
		<ol>
<?php endif; ?>
			<li>
				<?php echo $this->Html->link(
					empty($member['Member']['nickname']) ? h($member['Member']['name']) : h($member['Member']['nickname']),
					'/members/detail/' . $member['Member']['id']
				); ?>
				<?php if (!empty($member['Member']['email']) && $member['Member']['admin'] === true) echo '*'; ?>
			</li>
<?php endforeach; ?>
		</ol>
	</div>
</div>
