<?php
class MembersController extends AppController {

	public $uses = array('Member', 'Song');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('confirm', 'register', 'login');
	}

	public function index() {
		$members = $this->Member->find('all');
		$this->set('members', $members);
	}

	public function detail($id = null) {
		if (!$this->Member->exists($id)) {
			throw new NotFoundException('不正なメンバーIDです');
		}
		// idの一致するメンバー情報を取得
		$member = $this->Member->find('first', array('conditions' => array('Member.id' => $id)));
		// $member_idが一致する曲を取得
		// そのままではメンバーidから曲を検索できないのでmembers_songsをLEFT JOINする
		$options = array(
			'joins' => array(
				array(
					'table' => 'members_songs',
					'alias' => 'MembersSong',
					'type' => 'inner',
					'conditions' => array(
						'Song.id = MembersSong.song_id',
					)
				)
			),
			'order' => array('Live.date DESC', 'Song.time DESC', 'Song.order DESC'),
			'conditions' => array('MembersSong.member_id' => $id)
		);
		$songs = $this->Song->find('all', $options);
		// データを渡す
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
				if (is_null($member['Member']['email'])) { // emailフィールドがnullならばセッションにメンバー情報を保存してregisterアクションにリダイレクト
					$this->Session->write('Member.confirm', $member);
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
		if ($this->Session->check('Member.confirm')) { // セッションMember.confirmがあれば
			$member = $this->Session->read('Member.confirm');
			if ($this->request->is('post')) {
				$this->request->data['Member']['id'] = $member['Member']['id'];
				if ($this->Member->save($this->request->data)) {
					$this->Session->setFlash('<strong>登録が完了しました。</strong>メールアドレスとパスワードを入力してログインしてください。', 'alert', array(
						'plugin' => 'BoostCake',
						'class' => 'alert-success'
					));
					$this->redirect(array('action' => 'login'));
				} else {
					$this->Session->setFlash('<strong>登録に失敗しました。</strong>恐れ入りますが，もう一度やり直してください。', 'alert', array(
						'plugin' => 'BoostCake',
						'class' => 'alert-danger'
					));
					$this->redirect(array('action' => 'confirm'));
				}
			} else { // Postでなければ
				$this->set('member', $member);
			}
		} else { // セッションがなければ
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

	public function edit($id = null) {
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Member']['id'] = $id;
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
		} else { // Post あるいは Put でなければ
			$options = array('conditions' => array('Member.id' => $id), 'fields' => array('Member.email', 'Member.nickname'));
			$this->request->data = $this->Member->find('first', $options);
		}
	}

	public function edit_password($id = null) {
		$this->edit($id);
	}

	public function admin_add() {
		if ($this->request->is('post')) {
			$date = getdate();
			$year = $date['mon'] > 3 ? $date['year'] : $date['year'] - 1;
			$this->request->data['Member']['year'] = $year;
			if ($this->Member->save($this->request->data)) {
				$this->Session->setFlash('<strong>追加しました。</strong>（ID: ' . $this->Member->id . '）', 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-success'
				));
				$this->request->data = array(); // 各input要素のvalueをリセット
			} else {
				$this->Session->setFlash('<strong>追加に失敗しました。</strong>もう一度やり直してください。', 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-danger'
				));
			}
		}
	}

	public function admin_edit_admin() {
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Member->exists($this->request->data['Member']['id']) && $this->Member->save($this->request->data)) {
				$member = $this->Member->findById($this->Member->id);
				$this->Session->setFlash('<strong>' . $member['Member']['last_name'] . ' ' . $member['Member']['first_name'] . '</strong> を管理者に設定しました。', 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-success'
				));
				$this->request->data = array(); // 各input要素のvalueをリセット
			} else {
				$this->Session->setFlash('<strong>管理者の設定に失敗しました。</strong>もう一度やり直してください。', 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-danger'
				));
			}
		}
	}

	public function isAuthorized($user = null) {
		// 表示名編集画面は認証IDとメンバーIDが一致した時のみ閲覧可
		if (in_array($this->action, array('edit', 'edit_password'))) {
			return $this->request->pass[0] === $user['id'];
		}
		return parent::isAuthorized($user);
	}

}
