<?php
$this->assign('title', 'Add Songs from CSV');
?>
<div class="page-header">
	<h1>Add Songs from CSV</h1>
</div>
<?php echo $this->Form->create('CSV', array(
	'type' => 'file',
	'inputDefaults' => array(
		'div' => 'form-group',
		'label' => array(
			'class' => 'col col-sm-2 control-label'
		),
		'wrapInput' => 'col col-sm-10',
		'class' => 'form-control'
	),
	'class' => 'well form-horizontal'
)); ?>
	<?php echo $this->Form->input('live', array(
		'label' => 'ライブ'
	)); ?>
  <?php echo $this->Form->input('csv', array(
    'type' => 'file'
	)); ?>
	<div class="form-group">
		<?php echo $this->Form->submit('Add', array(
			'div' => 'col col-sm-10 col-sm-offset-2',
			'class' => 'btn btn-default'
		)); ?>
	</div>
<?php echo $this->Form->end(); ?>
