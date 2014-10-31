<?php
$this->assign('title', 'Edit Nickname');
?>
<div class="page-header">
	<h1>Edit Nickname</h1>
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
	<?php echo $this->Form->input('nickname', array(
		'placeholder' => 'ニックネーム'
	)); ?>
	<?php echo $this->Form->hidden('id'); ?>
	<div class="form-group">
		<?php echo $this->Form->submit('Update', array(
			'div' => 'col col-md-9 col-md-offset-3',
			'class' => 'btn btn-default'
		)); ?>
	</div>
<?php echo $this->Form->end(); ?>
