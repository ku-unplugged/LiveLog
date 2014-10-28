<div class="page-header">
	<h1>Song Search</h1>
</div>
<?php echo $this->Form->create('Song', array(
	'type' => 'get',
	'inputDefaults' => array(
		'div' => 'form-group',
		'label' => false,
		'wrapInput' => false,
		'class' => 'form-control'
	),
	'class' => 'form-inline well'
)); ?>
	<?php echo $this->Form->input('artist', array('placeholder' => 'Artist')); ?>
	<?php echo $this->Form->input('name', array('placeholder' => 'Song')); ?>
	<?php echo $this->Form->submit('Search', array(
		'div' => 'form-group',
		'class' => 'btn btn-default'
	)); ?>
<?php echo $this->Form->end(); ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th><?php echo $this->Paginator->sort('Live.date', 'Date') ?></th>
			<th>Live</th>
			<th>Order</th>
			<th>Song</th>
			<th>Artist</th>
			<th>Members</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($songs as $song): ?>
		<tr>
			<td><?php echo h($song['Live']['date']); ?></td>
			<td><?php echo h($song['Live']['name']); ?></td>
			<td><?php echo h($song['Song']['order']); ?></td>
			<td><?php echo h($song['Song']['name']); ?></td>
			<td><?php echo h($song['Song']['artist']); ?></td>
			<td>
				<ul class="list-inline">
					<?php foreach($song['Member'] as $member): ?>
					<li><?php echo h($member['MembersSong']['instrument']) . '.' . h($member['last_name']); ?></li>
					<?php endforeach; ?>
				</ul>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php echo $this->Paginator->pagination(array('ul' => 'pagination')); ?>
