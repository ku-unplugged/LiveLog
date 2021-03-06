<?php
$this->assign('title', 'Edit');
?>
<div class="page-header">
	<h1>Edit</h1>
</div>
<?php echo $this->Form->create(array(
	'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-md-3 control-label'
		),
		'wrapInput' => 'col col-md-9',
		'class' => 'form-control'
	),
	'class' => 'well form-horizontal'
)); ?>
	<?php echo $this->Form->input('email', array(
		'label' => 'メールアドレス'
	)); ?>
	<?php echo $this->Form->input('nickname', array(
		'label' => '表示名',
		'after' => '<p class="col-md-9 col-md-offset-3 help-block">同姓の人がいて紛らわしい，あだ名の方がわかりやすい，サークル外の人には名前を伏せたい，などの場合に利用してください</p>'
	)); ?>
	<div class="form-group">
		<?php echo $this->Form->submit('更新', array(
			'div' => 'col col-md-9 col-md-offset-3',
			'class' => 'btn btn-warning'
		)); ?>
	</div>
<?php echo $this->Form->end(); ?>
<p>
	<?php echo  $this->Html->link('パスワードを変更する', '/members/edit_password/' . $auth['id']); ?>
</p>
