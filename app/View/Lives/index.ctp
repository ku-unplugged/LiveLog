<div class="page-header">
	<h1>過去のセットリスト</h1>
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
		<?php foreach($lives as $row): ?>
		<tr>
			<td><?php echo $this->element('time', array('date' => $row['Live']['date'])); ?></td>
			<td><?php echo $this->Html->link($row['Live']['name'], '/Lives/detail/'.$row['Live']['id']); ?></td>
			<td><?php echo h($row['Live']['place']); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
