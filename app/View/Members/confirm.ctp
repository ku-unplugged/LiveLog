<?php
$this->assign('title', 'Confirm Membership');
?>
<div class="page-header">
	<h1>Confirm Membership</h1>
</div>
<p>
	ユーザ登録は，京大アンプラグドのライブに出演し，すでにLiveLogに名前が登録されている人のみ行えます。<br>
	下記フォームよりメンバーシップを確認して下さい。
</p>
<?php echo $this->Form->create('Confirm', array(
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
	<?php echo $this->Form->input('year', array(
		'placeholder' => '入部年度（例: 2014）',
		'requied'
	)); ?>
	<?php echo $this->Form->input('last_name', array(
		'placeholder' => '苗字（例: 京大）',
		'requied'
	)); ?>
	<?php echo $this->Form->input('first_name', array(
		'placeholder' => '名前（例: アンプラ太郎）',
		'requied'
	)); ?>
	<div class="form-group">
		<?php echo $this->Form->submit('Confirm', array(
			'div' => 'col col-md-9 col-md-offset-3',
			'class' => 'btn btn-primary'
		)); ?>
	</div>
<?php echo $this->Form->end(); ?>
