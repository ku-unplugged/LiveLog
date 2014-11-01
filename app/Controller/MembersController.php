<?php
class MembersController extends AppController {

	public $uses = array('Member', 'Song');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('confirm', 'register', 'login');
	}

	public function index() {
		$options = array(
			'order' => array('Member.year DESC', 'Member.furigana')
		);
		$members = $this->Member->find('all', $options);
		$this->set('members', $members);
	}

	public function detail($id = null) {
		if (!$this->Member->exists($id)) {
			throw new NotFoundException('不正なメンバーIDです');
		}
		$member = $this->Member->find('first', array('conditions' => array('Member.id' => $id)));

		// $member_idが一致する曲を取得
		$options = array(
			'joins' => array(
				array('table' => 'members_songs',
					'alias' => 'MembersSong',
					'type' => 'inner',
					'conditions' => array(
						'Song.id = MembersSong.song_id',
					)
				)
			),
			'order' => array('Live.date DESC', 'Song.time', 'Song.order'),
			'conditions' => array(
				'MembersSong.member_id' => $id
			)
		);
		$songs = $this->Song->find('all', $options);

		// データを渡してdetailビューを表示
		$this->set('member', $member);
		$this->set('songs', $songs);
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
					'class' => 'alert-warning'
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
					'class' => 'alert-warning'
				));
			}
		}
	}

	public function admin_login() {
		$this->login();
	}

	public function logout() {
		$this->redirect($this->Auth->logout());
	}

	public function admin_add() {
		if ($this->request->is('post')) {
			$data = $this->request->data;
			if ($this->Member->save($data)) {
				$this->Session->setFlash('<strong>追加しました。</strong>（ID: ' . $this->Member->id . '）', 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-success'
				));
				$this->request->data = array();
			} else {
				$this->Session->setFlash('<strong>追加に失敗しました。</strong>もう一度やり直してください。', 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-danger'
				));
			}
		}
	}

	public function edit($id = null) {
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Member->save($this->request->data)) {
				$this->Session->setFlash('<strong>更新しました。</strong>', 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-success'
				));
				return $this->redirect(array('action' => 'detail', $id));
			} else {
				$this->Session->setFlash('<strong>更新に失敗しました。</strong>もう一度やり直してください。', 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-danger'
				));
			}
		} else {
			$options = array('conditions' => array('Member.id' => $id));
			$this->request->data = $this->Member->find('first', $options);
		}
	}

	public function isAuthorized($user = null) {
		if ($this->action === 'edit') {
			return $this->request->pass[0] === $user['id'];
		}
		return parent::isAuthorized($user);
	}

}
