<?php
$this->assign('title', 'Edit or Delete Song');
?>
<div class="page-header">
	<h1>Edit Song</h1>
</div>
<?php echo $this->Form->create(array(
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
		'name' => 'data[Song][live_id]',
		'default' => $this->request->data['Song']['live_id']
	)); ?>
	<?php echo $this->Form->input('nf_time', array(
		'label' => 'Time (NF)',
		'name' => 'data[Song][time]',
		'value' => $this->request->data['Song']['time']
	)); ?>
	<?php echo $this->Form->input('order'); ?>
	<?php echo $this->Form->input('name'); ?>
	<?php echo $this->Form->input('artist'); ?>
	<?php echo $this->Form->input('url'); ?>
	<?php echo $this->Form->hidden('id'); ?>
	<div class="form-group">
		<?php echo $this->Form->submit('Update', array(
			'div' => 'col col-sm-10 col-sm-offset-2',
			'class' => 'btn btn-warning'
		)); ?>
	</div>
<?php echo $this->Form->end(); ?>
<div class="page-header">
	<h1>Delete Song</h1>
</div>
<?php echo $this->Form->postButton('Delete',
	array('action' => 'delete', $this->request->pass[0]),
	array('class' => 'btn btn-danger')
); ?>
