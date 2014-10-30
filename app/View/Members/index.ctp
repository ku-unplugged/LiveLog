<?php
$this->assign('title', 'Members');
?>
<div class="page-header">
	<h1>Members</h1>
</div>
<div class="row">
	<?php $year = (int)$members['0']['Member']['year']; ?>
	<div class="col-sm-3">
		<h2><?php echo h($year); ?></h2>
		<ol>
<?php foreach ($members as $member) : ?>
	<?php if ($year !== (int)$member['Member']['year']): $year--; ?>
		</ol>
	</div>
	<div class="col-sm-3">
		<h2><?php echo h($year); ?></h2>
		<ol>
	<?php endif; ?>
			<li class=""><?php echo empty($member['Member']['nickname']) ? h($member['Member']['name']) : h($member['Member']['nickname']); ?></li>
<?php endforeach; ?>
		</ol>
	</div>
</div>
