<table>
	<tr>
		<th>Date</th>
		<th>Name</th>
		<th>Place</th>
	</tr>
	<?php foreach($lives as $row): ?>
	<tr>
		<td><?php echo date('Y/n/j', strtotime($row['Live']['date'])); ?></td>
		<td><?php echo h($row['Live']['name']); ?></td>
		<td><?php echo h($row['Live']['place']); ?></td>
	</tr>
	<?php endforeach; ?>
</table>
