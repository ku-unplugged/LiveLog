<?php
$this->assign('title', 'Live List');
// テーブルの列をリンクにするためのJSとCSS
$this->assign('script', $this->Html->script('trlink'));
$this->assign('css', $this->Html->css('trlink'));

function nendo($date) {
	$_date = getdate(strtotime($date));
	if ($_date['mon'] > 3) {
		return $_date['year'];
	} else {
		return $_date['year'] - 1;
	}
}
?>
<div class="page-header">
	<h1>Live List</h1>
</div>
<div class="row">
	<?php
	$year = nendo($lives[0]['Live']['date']);
	$i = 0;
	?>
	<div class="col-md-6">
		<h2><?php echo $year; ?></h2>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Date</th>
					<th>Name</th>
					<th>Place</th>
				</tr>
			</thead>
			<tbody>
<?php foreach ($lives as $live): ?>
<?php if ($year !== nendo($live['Live']['date'])) : $year = nendo($live['Live']['date']); $i++; ?>
			</tbody>
		</table>
	</div>
<?php if ($i % 2 === 0) : ?>
</div>
<div class="row">
<?php endif; ?>
	<div class="col-md-6">
		<h2><?php echo $year; ?></h2>
		<table class="table table-hover">
			<thead>
				<tr>
					<th>Date</th>
					<th>Name</th>
					<th>Place</th>
				</tr>
			</thead>
			<tbody>
<?php endif; ?>
				<tr data-href="<?php echo $this->Html->url(array('action' => 'detail', $live['Live']['id'])); ?>">
					<td><?php echo $this->element('time', array('date' => $live['Live']['date'])); ?></td>
					<td><?php echo h($live['Live']['name']); ?></td>
					<td><?php echo h($live['Live']['place']); ?></td>
				</tr>
<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
