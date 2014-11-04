<?php
$this->assign('title', 'Statistics');
?>
<div class="page-header">
	<h1>Statistics</h1>
</div>
<?php echo $this->Form->create('Stats', array(
	'type' => 'get',
	'inputDefaults' => array(
		'div' => 'form-group',
		'label' => false,
		'wrapInput' => false,
		'class' => 'form-control'
	),
	'class' => 'form-inline'
)); ?>
	<?php
	$year = array();
	for ($y = (int)date('Y'); $y >= 2011; $y--) {
		$year[(string)$y] = $y;
	}
	$year['all'] = '全';
	echo $this->Form->input('select', array(
		'options' => $year,
		'name' => 'year',
		'default' => isset($this->request->query['year']) ? $this->request->query['year'] : ''
	));
	?>
	年度の
	<?php
	$types = array('l' => 'ライブ', 'm' => '入部メンバー');
	echo $this->Form->input('select', array(
		'options' => $types,
		'name' => 'type',
		'default' => isset($this->request->query['type']) ? $this->request->query['type'] : ''
	));
	?>
	の統計を見る
	<?php echo $this->Form->submit('Go', array(
		'div' => 'form-group',
		'class' => 'btn btn-info'
	)); ?>
<?php echo $this->Form->end(); ?>
<hr>
<div class="page-header">
	<h2>出演数ランキング</h2>
</div>
<div class="row">
	<div class="col-md-6">
		<table class="table table-striped">
			<thead>
				<th>Rank</th>
				<th>Name</th>
				<th>Sum</th>
			</thead>
			<tbody>
				<?php
				$i = 0;
				$rank = 1;
				$sum = $mem_rank[0][0]['sum'];
				foreach ($mem_rank as $row):
					if ($row[0]['sum'] !== $sum) {
						$rank++;
						$sum = $row[0]['sum'];
						if ($i >= 5) break;
					} ?>
					<tr>
						<td><?php echo h($rank); ?></td>
						<td><?php echo empty($row['m']['nickname']) ? h($row[0]['name']) : h($row['m']['name']); ?></td>
						<td><?php echo h($row[0]['sum']); ?></td>
					</tr>
				<?php
				$i++;
				endforeach;
				?>
			</tbody>
		</table>
	</div>
</div>
<div class="page-header">
	<h2>アーティストランキング</h2>
</div>
<div class="row">
	<div class="col-md-6">
		<table class="table table-striped">
			<thead>
				<th>Rank</th>
				<th>Name</th>
				<th>Sum</th>
			</thead>
			<tbody>
				<?php
				$i = 0;
				$rank = 1;
				$sum = $art_rank[0][0]['sum'];
				foreach ($art_rank as $row):
					if ($row[0]['sum'] !== $sum) {
						$rank++;
						$sum = $row[0]['sum'];
						if ($i >= 10) break;
					} ?>
					<tr>
						<td><?php echo h($rank); ?></td>
						<td><?php echo h($row['s']['name']); ?></td>
						<td><?php echo h($row[0]['sum']); ?></td>
					</tr>
				<?php
				$i++;
				endforeach;
				?>
			</tbody>
		</table>
	</div>
</div>
<div class="page-header">
	<h2>楽器ランキング</h2>
</div>
<div class="row">
	<div class="col-md-4">
		<table class="table table-striped">
			<thead>
				<th>Instrument</th>
				<th>Sum</th>
			</thead>
			<tbody>
				<?php foreach ($inst_rank as $row): ?>
				<tr>
					<td><?php echo h($row[0]['inst']); ?></td>
					<td><?php echo h($row[0]['sum']); ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<?php if ($type !== 'm'): ?>
<div class="page-header">
	<h2>構成人数</h2>
</div>
<div class="row">
	<div class="col-md-4">
		<table class="table table-striped">
			<thead>
				<th>構成人数</th>
				<th>Sum</th>
			</thead>
			<tbody>
				<?php foreach ($band_num as $row): ?>
				<tr>
					<td><?php echo h($row['band']['num']); ?>人</td>
					<td><?php echo h($row[0]['sum']); ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<p>
	平均: <?php echo h($band_avg_std[0][0]['avg']); ?> / 標準偏差: <?php echo h($band_avg_std[0][0]['std']); ?>
</p>
<?php endif; ?>
