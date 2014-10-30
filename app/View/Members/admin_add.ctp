<?php
$this->assign('title', 'Add Member');
?>
<div class="page-header">
	<h1>Add Member</h1>
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
	<?php
	$year = array();
	for ($y = (int)date('Y'); $y >= 1993; $y--) {
		$year[(string)$y] = $y;
	}
	echo $this->Form->input('select', array(
		'label' => '入部年度',
		'options' => $year,
		'name' => 'data[Member][year]'
	));
	?>
	<?php echo $this->Form->input('last_name', array(
		'label' => '苗字',
		'placeholder' => '例: 京大'
	)); ?>
	<?php echo $this->Form->input('first_name', array(
		'label' => '名前',
		'placeholder' => '例: アンプラ太郎'
	)); ?>
	<?php echo $this->Form->input('furigana', array(
		'label' => 'ふりがな',
		'placeholder' => '例: きょうだいあんぷらたろう（スペースなし）'
	)); ?>
	<div class="form-group">
		<?php echo $this->Form->submit('Add Member', array(
			'div' => 'col col-md-9 col-md-offset-3',
			'class' => 'btn btn-default'
		)); ?>
	</div>
<?php echo $this->Form->end(); ?>
