<?php
class LivesController extends AppController {

	public $uses = array('Live', 'Song');  // 指定しなければ Life になる

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
		$this->set('lives', $lives);
		$this->render('index');
	}

}
