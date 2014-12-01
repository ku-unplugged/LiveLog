<?php
$this->assign('title', 'Statistics');
?>
<div class="page-header">
	<h1>Statistics<small> - 自分</small></h1>
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
	$now = getdate();
	$nendo = $now['mon'] > 3 ? $now['year'] : $now['year'] - 1;
	$year = array();
	for ($y = $nendo; $y >= $auth['year']; $y--) {
		$year[$y] = $y;
	}
	$year['all'] = '全';
	echo $this->Form->input('select', array(
		'options' => $year,
		'name' => 'year',
		'default' => isset($this->request->query['year']) ? $this->request->query['year'] : 'all'
	));
	?>
	年度の自分の統計を見る
	<?php echo $this->Form->submit('Go', array(
		'div' => 'form-group',
		'class' => 'btn btn-default'
	)); ?>
<?php echo $this->Form->end(); ?>
<hr>
<p class="lead">
	曲数: <?php echo h($song_sum); ?>
</p>
<div class="row">
	<div class="col-md-3">
		<h2>共演数</h2>
		<table class="table table-striped">
			<thead>
				<th>Name</th>
				<th>Sum</th>
			</thead>
			<tbody>
				<?php foreach ($mem_rank as $row) : ?>
				<tr>
					<td>
						<?php
						$name = empty($row['m']['nickname']) ? h($row[0]['name']) : h($row['m']['nickname']);
						echo $this->Html->link($name, '/members/detail/' . $row['m']['id']);
						?>
					</td>
					<td><?php echo h($row[0]['sum']); ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<p>計 <?php echo count($mem_rank); ?> 人</p>
	</div>
	<div class="col-md-3">
		<h2>アーティスト</h2>
		<table class="table table-striped">
			<thead>
				<th>Artist</th>
				<th>Sum</th>
			</thead>
			<tbody>
				<?php foreach ($art_rank as $row) : ?>
					<tr>
						<td><?php echo $this->Html->link($row['s']['name'], '/songs/?keyword=' . $row['s']['name']); ?></td>
						<td><?php echo h($row[0]['sum']); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<div class="col-md-3">
		<h2>構成人数</h2>
		<table class="table table-striped">
			<thead>
				<th>Band</th>
				<th>Percent</th>
			</thead>
			<tbody>
				<?php foreach ($band_num as $row): ?>
				<tr>
					<td><?php echo h($row['band']['num']); ?>人</td>
					<td><?php echo h($row[0]['percent']); ?>%</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<p>
			平均: <?php echo h($band_avg_std[0][0]['avg']); ?><br>
			標準偏差: <?php echo h($band_avg_std[0][0]['std']); ?>
		</p>
	</div>
	<div class="col-md-3">
		<h2>楽器</h2>
		<table class="table table-striped">
			<thead>
				<th>Inst</th>
				<th>Sum</th>
			</thead>
			<tbody>
				<?php foreach ($inst_rank as $row): ?>
				<tr>
					<td><?php echo h($row['i']['inst']); ?></td>
					<td><?php echo h($row[0]['sum']); ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
