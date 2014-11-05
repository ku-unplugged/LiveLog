<?php
$this->assign('title', 'Edit or Delete Song');
$this->assign('script', $this->Html->script(array('select2.min', 'select2_locale_ja')));
$this->assign('css', $this->Html->css(array('select2', 'select2-bootstrap')));
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
	<?php
	$i = 0;
	foreach($this->request->data['MembersSong'] as $member_song) :
	?>
	<div class="form-group">
		<label class="col col-sm-2 control-label">Member<?php echo $i + 1; ?></label>
		<?php echo $this->Form->hidden('MembersSong.' . $i . '.id'); ?>
		<?php echo $this->Form->input('MembersSong.' . $i . '.instrument', array(
			'label' => false,
			'div' => false,
			'wrapInput' => 'col col-sm-2'
		)); ?>
		<?php echo $this->Form->input('MembersSong.' . $i . '.sub_instrument', array(
			'label' => false,
			'div' => false,
			'wrapInput' => 'col col-sm-2'
		)); ?>
		<?php echo $this->Form->input('MembersSong.' . $i . '.member_id', array(
			'label' => false,
			'div' => false,
			'wrapInput' => 'col col-sm-6',
			'class' => 'form-control select2'
		)); ?>
	</div>
	<?php
	$i++;
	endforeach;
	?>
	<div class="form-group">
		<?php echo $this->Form->submit('Update', array(
			'div' => 'col col-sm-10 col-sm-offset-2',
			'class' => 'btn btn-warning'
		)); ?>
	</div>
<?php echo $this->Form->end(); ?>
<script>
	$(document).ready(function() { $(".select2").select2({
		minimumInputLength: 1
	}); });
</script>
<div class="page-header">
	<h1>Delete Song</h1>
</div>
<?php echo $this->Form->postButton('Delete',
	array('action' => 'delete', $this->request->pass[0]),
	array('class' => 'btn btn-danger')
); ?>
