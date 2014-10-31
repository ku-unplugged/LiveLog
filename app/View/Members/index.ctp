<?php
$this->assign('title', 'Members');
?>
<div class="page-header">
	<h1>Members</h1>
</div>
<div class="row">
	<?php
	$year = (int)$members['0']['Member']['year'];
	$i = 0;
	?>
	<div class="col-sm-3">
		<h2><?php echo h($year); ?></h2>
		<ol>
<?php foreach ($members as $member) : ?>
<?php if ($year !== (int)$member['Member']['year']): $year--; $i++; ?>
		</ol>
	</div>
<?php if ($i % 4 === 0): ?>
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
			</li>
<?php endforeach; ?>
		</ol>
	</div>
</div>
