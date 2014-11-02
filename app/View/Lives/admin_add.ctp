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
	'class' => 'well form-horizontal'
)); ?>
	<?php echo $this->Form->input('_date', array(
		'label' => 'Date',
		'placeholder' => '例: 2014-06-13（区切りはハイフンで1桁の際は頭に0を足す）',
		'name' => 'data[Live][date]'
	)); ?>
	<?php echo $this->Form->input('name', array(
		'placeholder' => '例: 6月ライブ（数字・アルファベットは半角）'
	)); ?>
	<?php echo $this->Form->input('place', array(
		'placeholder' => '例: 4共21（数字は半角）'
	)); ?>
	<div class="form-group">
		<?php echo $this->Form->submit('Add Live', array(
			'div' => 'col col-md-9 col-md-offset-3',
			'class' => 'btn btn-default'
		)); ?>
	</div>
<?php echo $this->Form->end(); ?>
