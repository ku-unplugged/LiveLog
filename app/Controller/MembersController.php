<?php
class MembersController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('confirm', 'register');
	}

	public function index() {

	}

	public function confirm() {
		if ($this->request->is('post')) {
			$options = array(
				'conditions' => array(
					'Member.first_name' => $this->request->data['Confirm']['first_name'],
					'Member.last_name' => $this->request->data['Confirm']['last_name'],
					'Member.year' => $this->request->data['Confirm']['year']
				)
			);
			$member = $this->Member->find('first', $options);
			if (empty($member)) {
				$this->Session->setFlash('該当するメンバー情報がありません', 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-danger'
				));
			} else {
				if (is_null($member['Member']['email'])) {
					$this->Session->write('Member.confirm', $member['Member']);
					$this->redirect(array('action' => 'register'));
				} else {
					$this->Session->setFlash(
						'すでに登録済みです。メールアドレスとパスワードを入力してログインしてください<br>
						メールアドレス・パスワードを忘れた，あるいは登録に心当りがない方は，お手数ですが管理者までご連絡ください',
						'alert',
						array(
							'plugin' => 'BoostCake',
							'class' => 'alert-warning'
						)
					);
				}
			}
		}
	}

	public function register() {
		if ($this->Session->check('Member.confirm')) {
			$member = $this->Session->read('Member.confirm');
			if ($this->request->is('post')) {
				$data = array('Member' => array(
					'id' => $member['id'],
					'email' => $this->request->data['Register']['email'],
					'password' => $this->request->data['Register']['password']
				));
				if ($this->Member->save($data)) {
					$this->Session->destroy();
					$this->Session->setFlash('登録が完了しました', 'alert', array(
						'plugin' => 'BoostCake',
						'class' => 'alert-success'
					));
					$this->redirect(array('action' => 'login'));
				} else {
					$this->Session->destroy();
					$this->Session->setFlash('登録に失敗しました。恐れ入りますがもう一度やり直してください', 'alert', array(
						'plugin' => 'BoostCake',
						'class' => 'alert-danger'
					));
					$this->redirect(array('action' => 'confirm'));
				}
			} else {
				$this->set($member);
			}
		} else {
			$this->redirect(array('action' => 'confirm'));
		}
	}

	public function login() {

	}

}
