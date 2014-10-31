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
			debug($data);
			//$this->Song->bindModel(array('hasMany' => array('MembersSong')));
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

}
