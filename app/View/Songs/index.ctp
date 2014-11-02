<?php
$this->assign('title', 'Song Search');
?>
<div class="page-header">
	<h1>Song Search</h1>
</div>
<?php echo $this->Form->create('Search', array(
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
	'class' => 'form-inline'
)); ?>
	<?php echo $this->Form->input('keyword', array(
		'placeholder' => '曲名・アーティスト名',
		'value' => isset($this->request->query['keyword']) ? $this->request->query['keyword'] : ''
	)); ?>
	<?php echo $this->Form->button('<span class="glyphicon glyphicon-search"></span>', array(
		'div' => 'form-group',
		'class' => 'btn btn-default'
	)); ?>
<?php echo $this->Form->end(); ?>
<hr>
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
				<th><?php echo $this->Paginator->sort('Live.date', 'Live'); ?></th>
				<th>#</th>
				<th>Song</th>
				<th>Artist</th>
				<th>Members</th>
				<?php if(isset($auth)): ?>
				<th><span class="glyphicon glyphicon-play-circle"></span></th>
				<?php if ($auth['admin'] === true): ?>
				<th><span class="glyphicon glyphicon-edit"></span></th>
				<?php endif; ?>
				<?php endif; ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach($songs as $song): ?>
			<tr>
				<td><?php echo $this->Html->link($song['Live']['name_year'], '/lives/detail/' . $song['Live']['id']); ?></td>
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
				<td>
					<?php if (!empty($song['Song']['url'])) {
						echo $this->Html->link('<span class="glyphicon glyphicon-play-circle"></span>', $song['Song']['url'], array('escape' => false, 'target' => '_blank'));
					} ?>
				</td>
				<?php if ($auth['admin'] === true): ?>
				<td>
					<?php echo $this->Html->link('
						<span class="glyphicon glyphicon-edit"></span>',
						array('admin' => true, 'action' => 'edit', $song['Song']['id']),
						array('escape' => false)
					); ?>
				</td>
				<?php endif; ?>
				<?php endif; ?>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	</div>
<?php echo $this->Paginator->pagination(array('ul' => 'pagination')); ?>
<?php endif; ?>
