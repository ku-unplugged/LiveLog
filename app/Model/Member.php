<?php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class Member extends AppModel {

	public $virtualFields = array(
		'name' => 'CONCAT(Member.last_name, " ", Member.first_name)'
	);

	public $order = 'Member.furigana';

	public $validate = array(
		'email' => array(
			'rule'		=> array('email'),
			'message'	=> '有効なメールアドレスを入力してください。'
		),
		'password' => array(
			'rule'		=> array('notEmpty'),
			'message'	=> 'パスワードを設定してください。'
		),
		'year' => array(
			'rule'		=> array('date', 'y')
		),
		'last_name' => array(
			'rule'		=> array('notEmpty')
		),
		'first_name' => array(
			'rule'		=> array('notEmpty')
		),
		'furigana' => array(
			'rule'		=> array('notEmpty')
		)
	);

	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['password'])) {
			$passwordHasher = new SimplePasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
		}
		return true;
	}

}
