<?php
$this->assign('title', 'Song Search');
?>
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
	<?php echo $this->Form->input('sname', array('placeholder' => 'Song')); ?>
	<?php echo $this->Form->input('artist', array('placeholder' => 'Artist')); ?>
	<?php echo $this->Form->submit('Search', array(
		'div' => 'form-group',
		'class' => 'btn btn-default'
	)); ?>
<?php echo $this->Form->end(); ?>

<?php if (empty($songs)): ?>
<div class="alert alert-warning" role="alert">検索結果が見つかりませんでした。</div>
<?php else: ?>
<p class="text-right">
	<?php echo $this->Paginator->counter(array('format' => 'range')); ?>
</p>
<table class="table table-striped">
	<thead>
		<tr>
			<th><?php echo $this->Paginator->sort('Live.date', 'Date') ?></th>
			<th>Live</th>
			<th>Song</th>
			<th>Artist</th>
			<th>Members</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($songs as $song): ?>
		<tr>
			<td><?php echo $this->element('time', array('date' => $song['Live']['date'])) ?></td>
			<td><?php echo h($song['Live']['name']); ?></td>
			<td><?php echo h($song['Song']['name']); ?></td>
			<td><?php echo h($song['Song']['artist']); ?></td>
			<td><?php echo $this->element('members', array('members' => $song['Member'])); ?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php echo $this->Paginator->pagination(array('ul' => 'pagination')); ?>
<?php endif; ?>
