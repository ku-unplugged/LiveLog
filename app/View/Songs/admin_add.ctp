<?php
$this->assign('title', 'Add Song');
$this->assign('script', $this->Html->script('select2.min') . $this->Html->script('select2_locale_ja'));
$this->assign('css', $this->Html->css('select2') . $this->Html->css('select2-bootstrap'));
?>
<div class="page-header">
	<h1>Add Song</h1>
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
	<?php echo $this->Form->input('live'); ?>
	<?php echo $this->Form->input('order', array(
		'placeholder' => '曲順（例: 1）'
	)); ?>
	<?php echo $this->Form->input('name', array(
		'placeholder' => '曲名（例: アンプラのテーマ）'
	)); ?>
	<?php echo $this->Form->input('artisut', array(
		'placeholder' => 'アーティスト名（例: Unpluggeders）'
	)); ?>
	<?php echo $this->Form->input('url', array(
		'placeholder' => '動画URL（例: https://www.youtube.com/watch?v=w24A2eesrUA）'
	)); ?>
	<div id="member0" class="form-group">
		<label class="col col-sm-2 control-label">Member1</label>
		<?php echo $this->Form->input('instrument', array(
			'label' => false,
			'name' => 'data[MembersSong][0][instrument]',
			'div' => false,
			'wrapInput' => 'col col-sm-2',
			'placeholder' => '楽器（例: Gt）'
		)); ?>
		<?php echo $this->Form->input('sub_instrument', array(
			'label' => false,
			'name' => 'data[MembersSong][0][sub_instrument]',
			'div' => false,
			'wrapInput' => 'col col-sm-2',
			'placeholder' => 'サブ楽器（例: Cho）'
		)); ?>
		<?php echo $this->Form->input('members', array(
			'label' => false,
			'name' => 'data[MembersSong][0][member_id]',
			'div' => false,
			'wrapInput' => 'col col-sm-6',
			'class' => 'form-control'
		)); ?>
	</div>
	<div id="addMember" class="form-group">
		<div class="col col-sm-2 text-right">
			<button type="button" id="addMemberBtn" class="btn btn-link"><span class="glyphicon glyphicon-plus"></span></button>
		</div>
	</div>
	<div class="form-group">
		<?php echo $this->Form->submit('Add Song', array(
			'div' => 'col col-sm-10 col-sm-offset-2',
			'class' => 'btn btn-default'
		)); ?>
	</div>
<?php echo $this->Form->end(); ?>
<script>
	var options = $('#SongMembers').contents();
	var i = 0;
	$('#addMemberBtn').click(function() {
		i++;
		$('<div id="member' + i + '" class="form-group">'
			+ '<label class="col col-sm-2 control-label">Member' + (i + 1) + '</label>'
			+ '<div class="col col-sm-2"><input name="data[MembersSong][' + i + '][instrument]" class="form-control" type="text"></div>'
			+ '<div class="col col-sm-2"><input name="data[MembersSong][' + i + '][sub_instrument]" class="form-control" type="text"></div>'
			+ '<div class="col col-sm-6"><select name="data[MembersSong][' + i + '][member_id]" class="form-control"></select></div>'
		+ '</div>')
		.find('select')
			.append(options.clone())
			.select2({ minimumInputLength: 2 })
		.end()
		.insertBefore('#addMember');
	});
</script>
<script>
	$(document).ready(function() { $("#SongMembers").select2({
		minimumInputLength: 2
	}); });
</script>
