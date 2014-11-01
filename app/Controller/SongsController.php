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
		$members = $this->Member->find('list', array('order' => array('Member.year DESC', 'Member.furigana')));
		$lives = $this->Live->find('list');
		$this->set('members', $members);
		$this->set('lives', $lives);
		if ($this->request->is('post')) {
			$data = $this->request->data;
			$this->Song->bindModel(array('hasMany' => array('MembersSong')));
			if ($this->Song->saveAssociated($data)) {
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
	}

	public function admin_add_nf() {
		$this->admin_add();
	}

	public function admin_delete() {
		if ($this->request->is(array('post', 'delete'))) {
			$this->Song->id = (int)$this->request->data['DeleteSong']['id'];
			if (!$this->Song->exists()) {
				throw new NotFoundException('不正なIDです');
			}
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
		return $this->redirect(array(
			'admin' => false,
			'controller' => 'pages',
			'action' => 'display',
			'admin'
		));
	}

}
