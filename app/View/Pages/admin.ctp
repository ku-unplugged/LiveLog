<?php
$this->assign('title', 'Admin');
?>
<div class="page-header">
	<h1>Admin</h1>
</div>
<ul>
	<li class="lead">
		<?php echo $this->Html->link('ライブの追加', array(
			'admin' => true,
			'controller' => 'lives',
			'action' => 'add'
		)); ?>
	</li>
	<li class="lead">
		<?php echo $this->Html->link('メンバーの追加', array(
			'admin' => true,
			'controller' => 'members',
			'action' => 'add'
		)); ?>
	</li>
	<li class="lead">
		<?php echo $this->Html->link('曲の追加', array(
			'admin' => true,
			'controller' => 'songs',
			'action' => 'add'
		)); ?>
	</li>
	<li class="lead">
		<?php echo $this->Html->link('曲の追加（NF専用）', array(
			'admin' => true,
			'controller' => 'songs',
			'action' => 'add_nf'
		)); ?>
	</li>
</ul>
<h2>曲の削除</h2>
<?php echo $this->Form->create('DeleteSong', array(
	'url' => array(
		'admin' => true,
		'controller' => 'songs',
		'action' => 'delete'
	),
	'inputDefaults' => array(
		'div' => 'form-group',
		'label' => false,
		'wrapInput' => false,
		'class' => 'form-control'
	),
	'class' => 'form-inline'
)); ?>
	<?php echo $this->Form->input('id', array(
		'placeholder' => 'ID'
	)); ?>
	<?php echo $this->Form->submit('Delete', array(
		'div' => 'form-group',
		'class' => 'btn btn-danger'
	)); ?>
<?php echo $this->Form->end(); ?>
