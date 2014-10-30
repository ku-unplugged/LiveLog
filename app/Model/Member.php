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
			'required'	=> true,
			'message'	=> '有効なメールアドレスを入力してください。'
		),
		'password' => array(
			'rule'		=> array('minLength', '4'),
			'required'	=> true,
			'message'	=> '4文字以上のパスワードを設定してください。'
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
