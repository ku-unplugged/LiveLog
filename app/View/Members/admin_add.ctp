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
	'class' => 'well form-horizontal',
	'onsubmit' => 'return myConfirm()'
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
		'label' => '姓',
		'placeholder' => '京大'
	)); ?>
	<?php echo $this->Form->input('first_name', array(
		'label' => '名',
		'placeholder' => 'アンプラ太郎'
	)); ?>
	<?php echo $this->Form->input('furigana', array(
		'label' => 'ふりがな',
		'after' => '<p class="col-md-9 col-md-offset-3 help-block">姓名の間はスペースなしで詰める</p>',
		'placeholder' => 'きょうだいあんぷらたろう'
	)); ?>
	<div class="form-group">
		<?php echo $this->Form->submit('追加する', array(
			'div' => 'col col-md-9 col-md-offset-3',
			'class' => 'btn btn-default'
		)); ?>
	</div>
<?php echo $this->Form->end(); ?>
<script>
	function myConfirm() {
		return confirm(
			$('#MemberSelect').val()
			+ '年\n'
			+ $('#MemberLastName').val() + ' '+ $('#MemberFirstName').val()
			+ '\n'
			+ $('#MemberFurigana').val()
			+ '\nを追加します'
		);
	}
</script>
