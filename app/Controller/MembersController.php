<?php
class MembersController extends AppController {

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('confirm', 'register', 'login');
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
				$this->Session->setFlash('<strong>該当するメンバー情報がありません。</strong>', 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-danger'
				));
			} else {
				if (is_null($member['Member']['email'])) {
					$this->Session->write('Member.confirm', $member['Member']);
					$this->redirect(array('action' => 'register'));
				} else {
					$this->Session->setFlash(
						'<strong>すでに登録済みです。</strong>メールアドレスとパスワードを入力してサインインしてください。<br>
						メールアドレス・パスワードを忘れた，あるいは登録に心当りがない方は，お手数ですが管理者までご連絡ください。',
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
					$this->Session->setFlash('<strong>登録が完了しました。</strong>メールアドレスとパスワードを入力してサインインしてください。', 'alert', array(
						'plugin' => 'BoostCake',
						'class' => 'alert-success'
					));
					$this->redirect(array('action' => 'login'));
				} else {
					$this->Session->setFlash('<strong>登録に失敗しました。</strong>恐れ入りますがもう一度やり直してください。', 'alert', array(
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
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				return $this->redirect($this->Auth->redirectUrl());
			} else {
				$this->Session->setFlash('<strong>メールアドレスまたはパスワードが正しくありません。</strong>', 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-danger'
				));
			}
		}
	}

}
