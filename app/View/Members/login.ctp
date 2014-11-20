<?php
$this->assign('title', 'Log In');
?>
<div class="page-header">
	<h1>Log In</h1>
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
		'placeholder' => 'メールアドレス'
	)); ?>
	<?php echo $this->Form->input('password', array(
		'placeholder' => 'パスワード'
	)); ?>
	<div class="form-group">
		<?php echo $this->Form->submit('Log In', array(
			'div' => 'col col-md-9 col-md-offset-3',
			'class' => 'btn btn-primary'
		)); ?>
	</div>
<?php echo $this->Form->end(); ?>
