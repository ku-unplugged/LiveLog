<?php
$this->assign('title', 'Change Password');
?>
<div class="page-header">
	<h1>Change Password</h1>
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
	<?php echo $this->Form->input('password', array(
		'label' => '新しいパスワード'
	)); ?>
	<div class="form-group">
		<?php echo $this->Form->submit('変更する', array(
			'div' => 'col col-md-9 col-md-offset-3',
			'class' => 'btn btn-danger'
		)); ?>
	</div>
<?php echo $this->Form->end(); ?>
