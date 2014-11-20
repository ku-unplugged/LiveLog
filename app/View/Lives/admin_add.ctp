<?php
$this->assign('title', 'Add Live');
?>
<div class="page-header">
	<h1>Add Live</h1>
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
	<?php echo $this->Form->input('_date', array(
		'label' => 'Date',
		'placeholder' => '2014-06-13',
		'after' => '<p class="col-md-9 col-md-offset-3 help-block">区切りはハイフンで，月日が1桁の場合は0を付ける</p>',
		'name' => 'data[Live][date]'
	)); ?>
	<?php echo $this->Form->input('name', array(
		'placeholder' => '6月ライブ'
	)); ?>
	<?php echo $this->Form->input('place', array(
		'placeholder' => '4共21',
		'after' => '<p class="col-md-9 col-md-offset-3 help-block">英数字は原則半角</p>'
	)); ?>
	<div class="form-group">
		<?php echo $this->Form->submit('Add Live', array(
			'div' => 'col col-md-9 col-md-offset-3',
			'class' => 'btn btn-default'
		)); ?>
	</div>
<?php echo $this->Form->end(); ?>
<script>
	function myConfirm() {
		return confirm(
			$('#LiveDate').val()
			+ '\n'
			+ $('#LiveName').val()
			+ '\n@'
			+ $('#LivePlace').val()
			+ '\nを追加します'
		);
	}
</script>
