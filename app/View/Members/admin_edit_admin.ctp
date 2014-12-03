<?php
$this->assign('title', 'Add Admin');
?>
<div class="page-header">
	<h1>Add Admin</h1>
</div>
<p>
	メンバーIDは，そのメンバーの詳細ページのURL末尾の数字です。<br>
	たとえば，あなたの詳細ページのURLは「<?php echo $this->Html->link('~/members/detail/<strong>' . $auth['id'] . '</strong>', '/members/detail/' . $auth['id'], array('escape' => false)); ?>」で，あなたのメンバーIDは <strong><?php echo h($auth['id']); ?></strong> です。
</p>
<?php echo $this->Form->create(array(
	'inputDefaults' => array(
		'div' => 'form-group',
		'label' => false,
		'wrapInput' => false,
		'class' => 'form-control'
	),
	'class' => 'well form-inline',
	'onsubmit' => 'return myConfirm()'
)); ?>
	<?php echo $this->Form->input('id', array(
		'type' => 'number',
		'required' => 'required',
		'placeholder' => 'メンバーID'
	)); ?>
	<?php echo $this->Form->hidden('admin', array(
		'value' => true
	)); ?>
	<?php echo $this->Form->submit('管理者にする', array(
		'div' => 'form-group',
		'class' => 'btn btn-warning'
	)); ?>
<?php echo $this->Form->end(); ?>
<script>
function myConfirm() {
	return confirm(
		'メンバーID: '
		+ $('#MemberId').val()
		+ '\nを管理者に設定します'
	);
}
</script>
