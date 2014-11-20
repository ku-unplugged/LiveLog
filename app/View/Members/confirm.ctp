<?php
$this->assign('title', '会員資格の確認');
?>
<div class="page-header">
	<h1>会員資格の確認</h1>
</div>
<p>
	ユーザ登録は，京大アンプラグドのライブに出演し，すでにLiveLogに名前が登録されている人のみ行えます。<br>
	下記フォームより会員資格を確認して下さい。
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
		'label' => '入部年度（西暦）',
		'placeholder' => '2014',
		'requied'
	)); ?>
	<?php echo $this->Form->input('last_name', array(
		'label' => '姓',
		'placeholder' => '京大',
		'requied'
	)); ?>
	<?php echo $this->Form->input('first_name', array(
		'label' => '名',
		'placeholder' => 'アンプラ太郎',
		'requied'
	)); ?>
	<div class="form-group">
		<?php echo $this->Form->submit('確認する', array(
			'div' => 'col col-md-9 col-md-offset-3',
			'class' => 'btn btn-primary'
		)); ?>
	</div>
<?php echo $this->Form->end(); ?>
