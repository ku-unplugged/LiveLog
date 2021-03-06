<?php
$this->assign('title', 'Add Song');
$this->assign('script', $this->Html->script(array('select2.min', 'select2_locale_ja')));
$this->assign('css', $this->Html->css(array('select2', 'select2-bootstrap')));
?>
<div class="page-header">
	<h1>Add NF Song</h1>
</div>
<p>
	<b>楽器の入力について</b><br>
	記号がわからない時は過去の事例（Statisticsの楽器）から探す。そこになければ一般に使われている記号を参考にする。<br>
	入力順は「Vo → Vn・Fl・Sax等メロディ楽器 → Gt → Pf → Ba → Cj → パーカス」<br>
	同じ楽器が2つあるときはメロディとバッキングに分かれているならメロディが先で，違いがなければ名前の順。
</p>
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
		'label' => 'ライブ'
	)); ?>
	<?php
	// ここから
	echo $this->Form->input('nf_time', array(
		'label' => 'Time',
		'name' => 'data[Song][time]',
		'placeholder' => '09:30',
		'label' => '時間'
	));
	// ここまでが違う
	?>
	<?php echo $this->Form->input('order', array(
		'placeholder' => '1',
		'label' => '曲順'
	)); ?>
	<?php echo $this->Form->input('name', array(
		'placeholder' => 'アンプラのテーマ',
		'label' => '曲名'
	)); ?>
	<?php echo $this->Form->input('artist', array(
		'placeholder' => 'Unpluggeders',
		'label' => 'アーティスト'
	)); ?>
	<div class="form-group">
		<label class="col col-sm-2 control-label">メンバー1</label>
		<?php echo $this->Form->input('MembersSong.0.instrument', array(
			'label' => false,
			'div' => false,
			'wrapInput' => 'col col-sm-2',
			'placeholder' => '楽器（例: Gt）',
			'required' => 'required'
		)); ?>
		<?php echo $this->Form->input('MembersSong.0.sub_instrument', array(
			'label' => false,
			'div' => false,
			'wrapInput' => 'col col-sm-2',
			'placeholder' => 'サブ楽器（例: Vo）'
		)); ?>
		<?php echo $this->Form->input('MembersSong.0.member_id', array(
			'label' => false,
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
		<?php echo $this->Form->submit('Add', array(
			'div' => 'col col-sm-10 col-sm-offset-2',
			'class' => 'btn btn-default'
		)); ?>
	</div>
<?php echo $this->Form->end(); ?>
<script>
	var options = $('#MembersSong0MemberId').contents();
	var i = 0;
	$('#addMemberBtn').click(function() {
		i++;
		$('<div class="form-group">'
			+ '<label class="col col-sm-2 control-label">メンバー' + (i + 1) + '</label>'
			+ '<div class="col col-sm-2"><input name="data[MembersSong][' + i + '][instrument]" class="form-control" type="text" required=""></div>'
			+ '<div class="col col-sm-2"><input name="data[MembersSong][' + i + '][sub_instrument]" class="form-control" type="text"></div>'
			+ '<div class="col col-sm-6"><select name="data[MembersSong][' + i + '][member_id]" class="form-control"></select></div>'
		+ '</div>')
		.find('select')
			.append(options.clone())
			.select2({ minimumInputLength: 1 })
		.end()
		.insertBefore('#addMember');
	});
</script>
<script>
	$(document).ready(function() { $("#MembersSong0MemberId").select2({
		minimumInputLength: 1
	}); });
</script>
