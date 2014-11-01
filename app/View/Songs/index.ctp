<?php
$this->assign('title', 'Song Search');
?>
<div class="page-header">
	<h1>Song Search</h1>
</div>
<?php echo $this->Form->create('Song', array(
	'url' => array(
		'controller' => 'songs',
		'action' => 'index'
	),
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
	<?php echo $this->Form->input('artist', array(
		'placeholder' => 'Artist',
		'required' => false
	)); ?>
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
<div class="table-responsive">
	<table class="table table-striped">
		<thead>
			<tr>
				<?php if (isset($auth) && $auth['admin'] === true): ?>
				<th><?php echo $this->Paginator->sort('Song.id', 'ID'); ?></th>
				<?php endif; ?>
				<th><?php echo $this->Paginator->sort('Live.date', 'Date'); ?></th>
				<th>Live</th>
				<th>#</th>
				<th>Song</th>
				<th>Artist</th>
				<th>Members</th>
				<?php if(isset($auth)): ?>
				<th>Video</th>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach($songs as $song): ?>
			<tr>
				<?php if (isset($auth) && $auth['admin'] === true): ?>
				<td><?php echo h($song['Song']['id']); ?></td>
				<?php endif; ?>
				<td><?php echo $this->element('time', array('date' => $song['Live']['date'])) ?></td>
				<td><?php echo $this->Html->link($song['Live']['name'], '/lives/detail/' . $song['Live']['id']); ?></td>
				<td>
					<?php if (!empty($song['Song']['time'])):?>
						<time datetime="<?php echo h($song['Song']['time']); ?>"><?php echo date('H:i', strtotime($song['Song']['time'])); ?></time>
					<?php endif; ?>
					<?php echo h($song['Song']['order']); ?>
				</td>
				<td><?php echo h($song['Song']['name']); ?></td>
				<td><?php echo h($song['Song']['artist']); ?></td>
				<td><?php echo $this->element('members', array('members' => $song['Member'])); ?></td>
				<?php if(isset($auth)): ?>
				<td class="text-center">
					<?php if (!empty($song['Song']['url'])) {
						echo $this->Html->link('<span class="glyphicon glyphicon-play-circle"></span>', $song['Song']['url'], array('escape' => false, 'target' => '_blank'));
					} ?>
				</td>
				<?php endif; ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	</div>
<?php echo $this->Paginator->pagination(array('ul' => 'pagination')); ?>
<?php endif; ?>
