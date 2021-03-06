<?php
$this->assign('title', '新規登録');
?>
<div class="page-header">
	<h1>新規登録</h1>
</div>
<p>
	ようこそ！　<?php echo h($member['Member']['last_name']) . ' ' . h($member['Member']['first_name']); ?> さん<br>
	メールアドレスとパスワードを入力して登録を完了してください。
</p>
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
		'label' => 'メールアドレス',
		'after' => '<p class="col-md-9 col-md-offset-3 help-block">メールアドレスはすべてのアンプラグダーに公開されます</p>',

	)); ?>
	<?php echo $this->Form->input('password', array(
		'label' => 'パスワード'
	)); ?>
	<div class="form-group">
		<?php echo $this->Form->submit('登録する', array(
			'div' => 'col col-md-9 col-md-offset-3',
			'class' => 'btn btn-primary'
		)); ?>
	</div>
<?php echo $this->Form->end(); ?>
