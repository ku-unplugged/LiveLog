<?php
$this->assign('title', 'Sign Up');
?>
<div class="page-header">
	<h1>Sign Up</h1>
</div>
<p>
	ようこそ！　<?php echo h($last_name) . ' ' . h($first_name); ?> さん<br>
	メールアドレスとパスワードを入力して登録を完了してください。
</p>
<?php echo $this->Form->create('Register', array(
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
		'placeholder' => 'メールアドレス'
	)); ?>
	<?php echo $this->Form->input('password', array(
		'placeholder' => '4文字以上のパスワード'
	)); ?>
	<div class="form-group">
		<?php echo $this->Form->submit('Sign Up', array(
			'div' => 'col col-md-9 col-md-offset-3',
			'class' => 'btn btn-primary'
		)); ?>
	</div>
<?php echo $this->Form->end(); ?>
