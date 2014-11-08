<?php
$this->assign('title', 'Statistics:Member');
?>
<div class="page-header">
	<h1>Statistics: Member</h1>
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
	for ($y = $nendo; $y >= 2008; $y--) {
		$year[$y] = $y;
	}
	echo $this->Form->input('select', array(
		'options' => $year,
		'name' => 'year',
		'default' => isset($this->request->query['year']) ? $this->request->query['year'] : $auth['year']
	));
	?>
	年度入部メンバーの統計を見る
	<?php echo $this->Form->submit('Go', array(
		'div' => 'form-group',
		'class' => 'btn btn-default'
	)); ?>
<?php echo $this->Form->end(); ?>
<hr>
<div class="row">
	<div class="col-md-3">
		<h2>出演数</h2>
		<table class="table table-striped">
			<thead>
				<th>#</th>
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
						$rank = $i + 1;
						$sum = $row[0]['sum'];
						if ($i >= 10) break;
					} ?>
					<tr>
						<td><?php echo h($rank); ?></td>
						<td>
							<?php
							$name = empty($row['m']['nickname']) ? h($row[0]['name']) : h($row['m']['nickname']);
							echo $this->Html->link($name, '/members/detail/' . $row['m']['id']);
							?>
						</td>
						<td><?php echo h($row[0]['sum']); ?></td>
					</tr>
				<?php
				$i++;
				endforeach;
				?>
			</tbody>
		</table>
	</div>
	<div class="col-md-3">
		<h2>アーティスト</h2>
		<table class="table table-striped">
			<thead>
				<th>#</th>
				<th>Artist</th>
			</thead>
			<tbody>
				<?php
				$i = 0;
				$rank = 1;
				$sum = $art_rank[0][0]['sum'];
				foreach ($art_rank as $row):
					if ($row[0]['sum'] !== $sum) {
						$rank = $i +1;
						$sum = $row[0]['sum'];
						if ($i >= 10) break;
					} ?>
					<tr>
						<td><?php echo h($rank); ?></td>
						<td><?php echo $this->Html->link($row['s']['name'], '/songs/?keyword=' . $row['s']['name']); ?></td>
					</tr>
				<?php
				$i++;
				endforeach;
				?>
			</tbody>
		</table>
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
					<td><?php echo h($row[0]['inst']); ?></td>
					<td><?php echo h($row[0]['sum']); ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
