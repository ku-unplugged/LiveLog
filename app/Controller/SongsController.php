<?php
class SongsController extends AppController {

	public $uses = array('Song', 'Live', 'Member');

	public $components = array('Search.Prg');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index');
	}

	public function index() {
		if ($this->request->is('get')) {
			$this->Prg->commonProcess();
			$this->paginate = array(
				'conditions' => $this->Song->parseCriteria($this->passedArgs),
				'limit' => 20,
				'order' => array(
					'Live.date' => 'DESC',
					'Song.time' => 'ASC',
					'Song.order' => 'ASC'
				)
			);
			$this->set('songs', $this->paginate());
		}
	}

	public function admin_add() {
		if ($this->request->is('post')) {
			// そのままではメンバーを追加できないのでMembersSongモデルをhasManyする
			$this->Song->bindModel(array('hasMany' => array('MembersSong')));
			if ($this->Song->saveAssociated($this->request->data)) {
				$this->Session->setFlash('<strong>追加しました。</strong>（ID: ' . $this->Song->id . '）', 'alert', array(
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
		$members = $this->Member->find('list', array('order' => array('Member.year DESC', 'Member.furigana')));
		$lives = $this->Live->find('list', array('limit' => 10));
		$this->set('members', $members);
		$this->set('lives', $lives);
	}

	public function admin_add_nf() {
		$this->admin_add();
	}

	public function admin_edit($id = null) {
		if (!$this->Song->exists($id)) {
			throw new NotFoundException(__('不正なソングIDです。'));
		}
		$this->Song->unbindModel(array('hasAndBelongsToMany' => array('Member')));
		$this->Song->bindModel(array('hasMany' => array('MembersSong')), false);
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Song->saveAssociated($this->request->data)) {
				$this->Session->setFlash('<strong>更新しました。</strong>', 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-success'
				));
			} else {
				$this->Session->setFlash('<strong>更新に失敗しました。</strong>もう一度やり直してください。', 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-danger'
				));
			}
		} else {
			$options = array('conditions' => array('Song.id' => $id));
			$this->request->data = $this->Song->find('first', $options);
		}
		$members = $this->Member->find('list', array('order' => array('Member.year DESC', 'Member.furigana')));
		$lives = $this->Live->find('list');
		$this->set('members', $members);
		$this->set('lives', $lives);
	}

	public function admin_delete($id = null) {
		$this->Song->id = $id;
		if (!$this->Song->exists()) {
			throw new NotFoundException('不正なソングIDです');
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->request->is(array('post', 'delete'))) {
			if ($this->Song->delete()) {
				$this->Session->setFlash('<strong>削除しました。</strong>', 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-success'
				));
			} else {
				$this->Session->setFlash('<strong>削除に失敗しました。</strong>もう一度やり直してください。', 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-danger'
				));
			}
		}
		return $this->redirect(array('admin' => false, 'action' => 'index'));
	}

}
