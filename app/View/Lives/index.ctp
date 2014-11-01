<?php
$this->assign('title', 'Live List');
// テーブルの列をリンクにするためのJSとCSS
$this->assign('script', $this->Html->script('trlink'));
$this->assign('css', $this->Html->css('trlink'));
?>
<div class="page-header">
	<h1>Live List</h1>
</div>
<div class="row">
	<div class="col-md-6">
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
