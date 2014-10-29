<?php
$this->assign('title', 'Live List');
?>
<div class="page-header">
	<h1>Live List</h1>
</div>
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
		<tr>
			<td><?php echo $this->element('time', array('date' => $live['Live']['date'])); ?></td>
			<td><?php echo $this->Html->link($live['Live']['name'], '/lives/detail/'.$live['Live']['id']); ?></td>
			<td><?php echo h($live['Live']['place']); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
