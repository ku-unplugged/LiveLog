<?php
class LivesController extends AppController {

	public $uses = array('Live', 'Song');  // 指定しなければ Life になる

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'detail');
	}

	public function index() {
		// livesテーブルから今日以前のライブのレコードを取得
		$options = array(
			'conditions' => array(
				'Live.date <' => date('Y-m-d')
			),
			'recursive' => 0
		);
		$lives = $this->Live->find('all', $options);
		// debug($lives);

		// データを渡してindexビューを表示
		$this->set('lives', $lives);
	}

	public function detail() {
		// URLにidがなければindexにリダイレクト，あれば$live_idに代入
		if (isset($this->request->pass[0])) {
			$live_id = $this->request->pass[0];
		} else {
			$this->redirect(array('action' => 'index'));
		}

		// $live_idが一致するライブの曲を取得
		$options = array(
			'conditions' => array('Song.live_id' => $live_id),
			'order' => array('Song.order')
		);
		$songs = $this->Song->find('all', $options);
		// debug($songs);

		// データを渡してdetailビューを表示
		$this->set('songs', $songs);
	}

	public function admin_add() {
		if ($this->request->is('post')) {
			$data = $this->request->data;
			if ($this->Live->save($data)) {
				$this->Session->setFlash('<strong>追加しました。</strong>（ID: ' . $this->Live->id . '）', 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-success'
				));
				$this->request->data = array();
			} else {
				$this->Session->setFlash('<strong>追加に失敗しました。</strong>もう一度やり直してください。' . $this->Member->id, 'alert', array(
					'plugin' => 'BoostCake',
					'class' => 'alert-danger'
				));
			}
		}
	}

}
